<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class paymentController extends Controller
{
    /**
     * Display the payment page
     */
    public function payment(Request $request)
    {
        $jobId = $request->get('job_id');
        $job = null;
        
        if ($jobId) {
            $job = Job::with('employer')->find($jobId);
            if (!$job || $job->employer_id !== Auth::id()) {
                return redirect()->route('employerDashboard')->with('error', 'Job not found or unauthorized access.');
            }
        }
        
        // Calculate payment amounts
        $jobPostingFee = 2.99;
        $platformFee = 0.50;
        $processingFee = 0.25;
        $totalAmount = $jobPostingFee + $platformFee + $processingFee;
        
        return view('files.payment', compact('job', 'jobPostingFee', 'platformFee', 'processingFee', 'totalAmount'));
    }

    /**
     * Process payment request
     */
    public function processPayment(Request $request)
    {
        // Check if user is authenticated for job-related payments
        if ($request->job_id && !Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to complete payment for job posting.',
                'redirect_url' => route('login'),
            ], 401);
        }

        $request->validate([
            'payment_method' => 'required|string',
            'job_id' => 'nullable|exists:job_postings,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_type' => 'required|in:job_posting,subscription,feature_upgrade',
        ]);

        try {
            DB::beginTransaction();

            // Create payment record
            $payment = Payment::create([
                'user_id' => Auth::id(),
                'job_id' => $request->job_id,
                'payment_type' => $request->payment_type,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
                'transaction_id' => $this->generateTransactionId(),
                'metadata' => $this->preparePaymentMetadata($request),
            ]);

            // Process payment based on method
            $result = $this->processPaymentByMethod($payment, $request);

            if ($result['success']) {
                // Update job status if it's a job posting payment
                if ($request->job_id && $request->payment_type === 'job_posting') {
                    $job = Job::find($request->job_id);
                    if ($job) {
                        $job->update([
                            'status' => 'active',
                            'payment_status' => 'paid',
                            'published_at' => now(),
                        ]);
                    }
                }

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => $result['message'],
                    'payment_id' => $payment->id,
                    'transaction_id' => $payment->transaction_id,
                    'redirect_url' => $result['redirect_url'] ?? null,
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => $result['message'],
                ], 400);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment processing error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Payment processing failed. Please try again.',
            ], 500);
        }
    }

    /**
     * Handle payment callback/webhook
     */
    public function paymentCallback(Request $request)
    {
        $transactionId = $request->get('transaction_id');
        $status = $request->get('status');
        
        if (!$transactionId) {
            return response()->json(['error' => 'Transaction ID required'], 400);
        }

        $payment = Payment::where('transaction_id', $transactionId)->first();
        
        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        // Update payment status
        $payment->update([
            'status' => $status === 'success' ? 'completed' : 'failed',
            'paid_at' => $status === 'success' ? now() : null,
            'metadata' => array_merge($payment->metadata ?? [], [
                'callback_data' => $request->all(),
                'callback_received_at' => now()->toISOString(),
            ]),
        ]);

        // If payment successful and it's for a job posting, activate the job
        if ($status === 'success' && $payment->job_id && $payment->payment_type === 'job_posting') {
            $job = Job::find($payment->job_id);
            if ($job && $job->status !== 'active') {
                $job->update([
                    'status' => 'active',
                    'payment_status' => 'paid',
                    'published_at' => now(),
                ]);
            }
        }

        return response()->json(['success' => true]);
    }

    /**
     * Get payment status
     */
    public function getPaymentStatus($transactionId)
    {
        $payment = Payment::where('transaction_id', $transactionId)
            ->with(['user', 'job'])
            ->first();

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        // Check if user can access this payment
        if ($payment->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'payment' => [
                'id' => $payment->id,
                'transaction_id' => $payment->transaction_id,
                'amount' => $payment->amount,
                'status' => $payment->status,
                'payment_method' => $payment->payment_method,
                'payment_type' => $payment->payment_type,
                'created_at' => $payment->created_at,
                'paid_at' => $payment->paid_at,
                'job' => $payment->job ? [
                    'id' => $payment->job->id,
                    'title' => $payment->job->title,
                    'status' => $payment->job->status,
                ] : null,
            ]
        ]);
    }

    /**
     * Get user's payment history
     */
    public function getPaymentHistory()
    {
        $payments = Payment::where('user_id', Auth::id())
            ->with(['job'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($payments);
    }

    /**
     * Process payment based on selected method
     */
    private function processPaymentByMethod(Payment $payment, Request $request)
    {
        $method = $request->payment_method;

        switch ($method) {
            case 'mtn':
            case 'airtel':
            case 'mpesa':
            case 'orange':
            case 'tigo':
            case 'telecel':
                return $this->processMobileMoneyPayment($payment, $request);

            case 'visa':
            case 'mastercard':
            case 'amex':
            case 'discover':
                return $this->processCardPayment($payment, $request);

            case 'paypal':
                return $this->processPayPalPayment($payment, $request);

            case 'applepay':
            case 'googlepay':
                return $this->processDigitalWalletPayment($payment, $request);

            default:
                return [
                    'success' => false,
                    'message' => 'Unsupported payment method',
                ];
        }
    }

    /**
     * Process mobile money payment
     */
    private function processMobileMoneyPayment(Payment $payment, Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|string',
        ]);

        // In a real implementation, you would integrate with mobile money APIs
        // For now, we'll simulate the process
        
        $methodNames = [
            'mtn' => 'MTN Mobile Money',
            'airtel' => 'Airtel Money',
            'mpesa' => 'M-Pesa',
            'orange' => 'Orange Money',
            'tigo' => 'Tigo Pesa',
            'telecel' => 'Telecel Cash',
        ];

        $methodName = $methodNames[$request->payment_method] ?? 'Mobile Money';

        // Update payment metadata
        $payment->update([
            'metadata' => array_merge($payment->metadata ?? [], [
                'mobile_number' => $request->mobile_number,
                'provider' => $methodName,
                'initiated_at' => now()->toISOString(),
            ]),
        ]);

        // Simulate API call to mobile money provider
        // In production, you would make actual API calls here
        
        return [
            'success' => true,
            'message' => "Payment request sent to your {$methodName} account. Please check your phone and enter your PIN to complete the payment.",
            'requires_confirmation' => true,
        ];
    }

    /**
     * Process card payment
     */
    private function processCardPayment(Payment $payment, Request $request)
    {
        $request->validate([
            'card_number' => 'required|string',
            'expiry_date' => 'required|string',
            'cvv' => 'required|string',
            'card_name' => 'required|string',
        ]);

        // In a real implementation, you would integrate with payment processors like Stripe, PayPal, etc.
        // For now, we'll simulate the process

        // Mask card number for security
        $maskedCardNumber = '**** **** **** ' . substr($request->card_number, -4);

        $payment->update([
            'metadata' => array_merge($payment->metadata ?? [], [
                'card_last_four' => substr(str_replace(' ', '', $request->card_number), -4),
                'card_type' => $request->payment_method,
                'cardholder_name' => $request->card_name,
                'processed_at' => now()->toISOString(),
            ]),
        ]);

        // Simulate successful payment processing
        $payment->markAsCompleted();

        return [
            'success' => true,
            'message' => 'Payment processed successfully! Your transaction has been completed.',
        ];
    }

    /**
     * Process PayPal payment
     */
    private function processPayPalPayment(Payment $payment, Request $request)
    {
        // In a real implementation, you would redirect to PayPal
        return [
            'success' => true,
            'message' => 'Redirecting to PayPal...',
            'redirect_url' => 'https://www.paypal.com/checkout', // This would be the actual PayPal URL
        ];
    }

    /**
     * Process digital wallet payment
     */
    private function processDigitalWalletPayment(Payment $payment, Request $request)
    {
        $walletNames = [
            'applepay' => 'Apple Pay',
            'googlepay' => 'Google Pay',
        ];

        $walletName = $walletNames[$request->payment_method] ?? 'Digital Wallet';

        return [
            'success' => true,
            'message' => "Redirecting to {$walletName}...",
            'redirect_url' => '#', // This would be the actual wallet URL
        ];
    }

    /**
     * Generate unique transaction ID
     */
    private function generateTransactionId(): string
    {
        return 'TXN_' . strtoupper(Str::random(10)) . '_' . time();
    }

    /**
     * Prepare payment metadata
     */
    private function preparePaymentMetadata(Request $request): array
    {
        return [
            'user_agent' => $request->userAgent(),
            'ip_address' => $request->ip(),
            'created_at' => now()->toISOString(),
            'payment_breakdown' => [
                'job_posting_fee' => 2.99,
                'platform_fee' => 0.50,
                'processing_fee' => 0.25,
            ],
        ];
    }

    /**
     * Admin: Get all payments
     */
    public function adminGetPayments(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $query = Payment::with(['user', 'job']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment method
        if ($request->has('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by date range
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json($payments);
    }
}
