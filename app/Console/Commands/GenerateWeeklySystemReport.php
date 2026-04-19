<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SystemReport;
use App\Services\ReportService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class GenerateWeeklySystemReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:weekly {--force : Force generation even if report exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate weekly system report for the past week';

    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        parent::__construct();
        $this->reportService = $reportService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting weekly report generation...');

        // Calculate last week's date range (Monday to Sunday)
        $endDate = Carbon::now()->previous(Carbon::SUNDAY)->endOfDay();
        $startDate = Carbon::parse($endDate)->startOfWeek(Carbon::MONDAY);

        $this->info("Report period: {$startDate->format('Y-m-d')} to {$endDate->format('Y-m-d')}");

        // Check if report already exists
        $existingReport = SystemReport::where('week_start_date', $startDate->format('Y-m-d'))
            ->where('week_end_date', $endDate->format('Y-m-d'))
            ->first();

        if ($existingReport && !$this->option('force')) {
            $this->warn('Report for this week already exists. Use --force to regenerate.');
            return 0;
        }

        try {
            // Generate report data
            $this->info('Collecting statistics...');
            $reportData = $this->reportService->generateWeeklyReport($startDate, $endDate);

            // Save or update report
            if ($existingReport) {
                $existingReport->update($reportData);
                $report = $existingReport;
                $this->info('Report updated successfully.');
            } else {
                $report = SystemReport::create($reportData);
                $this->info('Report created successfully.');
            }

            // Display summary
            $summary = $this->reportService->generateSummary($reportData);
            $this->line("\n" . $summary);

            // Log success
            Log::info('Weekly system report generated', [
                'report_id' => $report->id,
                'week_start' => $startDate->format('Y-m-d'),
                'week_end' => $endDate->format('Y-m-d')
            ]);

            $this->info("\nReport ID: {$report->id}");
            $this->info('Weekly report generation completed successfully!');

            return 0;
        } catch (\Exception $e) {
            $this->error('Error generating report: ' . $e->getMessage());
            Log::error('Weekly report generation failed: ' . $e->getMessage());
            return 1;
        }
    }
}

