<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use chillerlan\QRCode\QRCode;

class settingsController extends Controller
{
    public function settings()
    {
        return view('files.settings');
    }

    public function showTwoFactorSetup()
    {
        $user = Auth::user();
        
        if ($user->two_factor_secret) {
            return redirect()->route('settings')->with('message', 'Two-factor authentication is already enabled.');
        }

        $secret = $this->generateTOTPSecret();
        $appName = 'JOB-lyNK';
        $data = "otpauth://totp/{$appName}:{$user->email}?secret={$secret}&issuer={$appName}";
        
        $qrCodeDataUrl = null;
        try {
            $qrCode = new QRCode();
            $qrCodeDataUrl = $qrCode->render($data);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('QR Code generation failed: ' . $e->getMessage());
        }
        
        return view('files.two-factor-setup', [
            'secret' => $secret,
            'qrCodeUrl' => $qrCodeDataUrl,
        ]);
    }

    public function confirmTwoFactorSetup(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
            'secret' => ['required', 'string'],
        ]);

        $user = Auth::user();
        $verified = $this->verifyTOTPCode($request->secret, $request->code);

        if (!$verified) {
            throw ValidationException::withMessages([
                'code' => ['The provided code is invalid.'],
            ]);
        }

        $user->two_factor_secret = $request->secret;
        $recoveryCodes = $this->generateRecoveryCodes();
        $user->two_factor_recovery_codes = json_encode($recoveryCodes);
        $user->save();

        return redirect()->route('settings')->with('success', 'Two-factor authentication has been enabled successfully. Save your recovery codes in a safe place.');
    }

    public function disableTwoFactor(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        $user = Auth::user();

        if (!\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['The provided password is incorrect.'],
            ]);
        }

        $user->two_factor_secret = null;
        $user->two_factor_recovery_codes = null;
        $user->save();

        return redirect()->route('settings')->with('success', 'Two-factor authentication has been disabled.');
    }

    /**
     * Generate Base32 TOTP Secret
     */
    private function generateTOTPSecret(): string
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secret = '';
        for ($i = 0; $i < 32; $i++) {
            $secret .= $alphabet[random_int(0, 31)];
        }
        return $secret;
    }

    /**
     * Verify TOTP Code
     */
    private function verifyTOTPCode(string $secret, string $code): bool
    {
        $time = floor(time() / 30);
        
        for ($i = -1; $i <= 1; $i++) {
            $hash = hash_hmac('sha1',
                pack('N*', 0) . pack('N*', $time + $i),
                $secret,
                true);
            $offset = ord($hash[19]) & 0xf;
            $otp = (((ord($hash[$offset]) & 0x7f) << 24) |
                    ((ord($hash[$offset + 1]) & 0xff) << 16) |
                    ((ord($hash[$offset + 2]) & 0xff) << 8) |
                    (ord($hash[$offset + 3]) & 0xff)) % 1000000;
            
            if (str_pad($otp, 6, '0', STR_PAD_LEFT) === $code) {
                return true;
            }
        }
        
        return false;
    }

    private function generateRecoveryCodes(): array
    {
        $codes = [];
        for ($i = 0; $i < 10; $i++) {
            $codes[] = Str::random(8);
        }
        return $codes;
    }
}
