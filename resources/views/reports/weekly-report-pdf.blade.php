<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Weekly System Report - JOB-lyNK</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            color: #1f2937;
            line-height: 1.4;
            background: white;
            font-size: 10px;
        }
        
        /* Compact Header */
        .header {
            background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
            color: white;
            padding: 15px 20px;
            border-top: 4px solid #fbbf24;
        }
        
        .header-content {
            display: table;
            width: 100%;
        }
        
        .header-left {
            display: table-cell;
            vertical-align: middle;
            width: 70%;
        }
        
        .header-right {
            display: table-cell;
            vertical-align: middle;
            width: 30%;
            text-align: right;
        }
        
        .logo-text {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        
        .logo-subtitle {
            font-size: 9px;
            color: #bfdbfe;
            margin-top: 2px;
        }
        
        .report-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .report-period {
            font-size: 10px;
            color: #bfdbfe;
            margin-top: 2px;
        }
        
        .report-id-box {
            background: rgba(255, 255, 255, 0.2);
            padding: 5px 8px;
            border-radius: 4px;
            display: inline-block;
        }
        
        .report-id-label {
            font-size: 8px;
            color: #bfdbfe;
            display: block;
        }
        
        .report-id-value {
            font-family: 'Courier New', monospace;
            font-size: 11px;
            font-weight: bold;
        }
        
        .container {
            padding: 15px 20px;
        }
        
        /* Summary Box */
        .summary-box {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border-left: 3px solid #3b82f6;
            border-radius: 4px;
            padding: 10px 12px;
            margin-bottom: 12px;
        }
        
        .summary-text {
            font-size: 10px;
            line-height: 1.5;
            color: #1e40af;
            font-weight: 500;
        }
        
        /* Metrics Grid - 3 columns */
        .metrics-grid {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }
        
        .metrics-row {
            display: table-row;
        }
        
        .metric-cell {
            display: table-cell;
            width: 33.33%;
            padding: 3px;
            vertical-align: top;
        }
        
        .metric-box {
            border-left: 3px solid #e5e7eb;
            padding: 8px 10px;
            background: #f9fafb;
            border-radius: 3px;
            min-height: 50px;
        }
        
        .metric-box.blue { border-left-color: #3b82f6; background: #eff6ff; }
        .metric-box.green { border-left-color: #10b981; background: #f0fdf4; }
        .metric-box.purple { border-left-color: #7c3aed; background: #f5f3ff; }
        .metric-box.yellow { border-left-color: #f59e0b; background: #fffbeb; }
        .metric-box.orange { border-left-color: #f97316; background: #fff7ed; }
        .metric-box.pink { border-left-color: #ec4899; background: #fdf2f8; }
        
        .metric-label {
            font-size: 8px;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 4px;
        }
        
        .metric-value {
            font-size: 18px;
            font-weight: bold;
            color: #1f2937;
            line-height: 1;
        }
        
        .metric-icon {
            float: right;
            font-size: 12px;
            opacity: 0.4;
        }
        
        /* Section Headers */
        .section {
            margin-bottom: 10px;
            page-break-inside: avoid;
        }
        
        .section-header {
            border-left: 3px solid #2563eb;
            padding-left: 8px;
            margin-bottom: 8px;
            margin-top: 8px;
        }
        
        .section-title {
            font-size: 11px;
            font-weight: bold;
            color: #1f2937;
        }
        
        /* Performers Grid - 2 columns */
        .performers-grid {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }
        
        .performers-row {
            display: table-row;
        }
        
        .performer-cell {
            display: table-cell;
            width: 50%;
            padding: 3px;
        }
        
        .performer-box {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-left: 3px solid #f59e0b;
            border-radius: 3px;
            padding: 8px 10px;
        }
        
        .performer-title {
            font-size: 8px;
            color: #92400e;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        
        .performer-value {
            font-size: 11px;
            font-weight: bold;
            color: #1f2937;
        }
        
        /* Info Table */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        
        .info-table tr {
            border-bottom: 1px solid #e5e7eb;
        }
        
        .info-table td {
            padding: 6px 0;
            font-size: 9px;
        }
        
        .info-table td:first-child {
            font-weight: 600;
            color: #6b7280;
            width: 40%;
        }
        
        .info-table td:last-child {
            color: #1f2937;
            font-weight: 500;
        }
        
        /* Warning Box */
        .warning-box {
            background: #fef2f2;
            border-left: 3px solid #ef4444;
            border-radius: 3px;
            padding: 6px 8px;
            margin-top: 8px;
        }
        
        .warning-text {
            color: #991b1b;
            font-size: 9px;
            font-weight: 600;
        }
        
        /* Footer */
        .footer {
            margin-top: 15px;
            padding: 12px 20px;
            background: linear-gradient(135deg, #1e40af 0%, #6366f1 100%);
            color: white;
            text-align: center;
            font-size: 9px;
            border-top: 3px solid #fbbf24;
        }
        
        .footer-logo {
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 3px;
            letter-spacing: 1px;
        }
        
        .footer-tagline {
            color: #bfdbfe;
            margin-bottom: 6px;
        }
        
        .footer-contact {
            padding-top: 6px;
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            color: #bfdbfe;
        }
        
        /* Icons */
        .icon-users::before { content: "👥 "; }
        .icon-briefcase::before { content: "💼 "; }
        .icon-file::before { content: "📝 "; }
        .icon-check::before { content: "✅ "; }
        .icon-money::before { content: "💰 "; }
        .icon-card::before { content: "💳 "; }
        .icon-trophy::before { content: "🏆 "; }
        .icon-star::before { content: "⭐ "; }
        .icon-warning::before { content: "⚠️ "; }
        .icon-chart::before { content: "📊 "; }
    </style>
</head>
<body>
    <!-- Compact Header -->
    <div class="header">
        <div class="header-content">
            <div class="header-left">
                <div class="logo-text">JOB-lyNK</div>
                <div class="logo-subtitle">Official Weekly System Report</div>
                <div class="report-title">Weekly Performance Report</div>
                <div class="report-period">
                    {{ \Carbon\Carbon::parse($report->week_start_date)->format('M d') }} - 
                    {{ \Carbon\Carbon::parse($report->week_end_date)->format('M d, Y') }}
                </div>
            </div>
            <div class="header-right">
                <div class="report-id-box">
                    <span class="report-id-label">REPORT ID</span>
                    <div class="report-id-value">#{{ str_pad($report->id, 6, '0', STR_PAD_LEFT) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Executive Summary -->
        <div class="summary-box">
            <div class="summary-text">
                <strong>{{ $report->total_new_users }}</strong> users registered • 
                <strong>{{ $report->total_jobs_posted }}</strong> jobs posted • 
                <strong>{{ $report->total_applications }}</strong> applications • 
                <strong>{{ $report->total_workers_hired }}</strong> workers hired • 
                <strong>UGX {{ number_format($report->total_revenue, 0) }}</strong> revenue
            </div>
        </div>

        <!-- All Metrics in One Grid -->
        <div class="section">
            <div class="section-header">
                <div class="section-title"><span class="icon-chart"></span>Key Performance Metrics</div>
            </div>
            
            <div class="metrics-grid">
                <!-- Row 1 -->
                <div class="metrics-row">
                    <div class="metric-cell">
                        <div class="metric-box blue">
                            <div class="metric-label">New Users</div>
                            <div class="metric-value">{{ $report->total_new_users }}</div>
                        </div>
                    </div>
                    <div class="metric-cell">
                        <div class="metric-box green">
                            <div class="metric-label">Jobs Posted</div>
                            <div class="metric-value">{{ $report->total_jobs_posted }}</div>
                        </div>
                    </div>
                    <div class="metric-cell">
                        <div class="metric-box purple">
                            <div class="metric-label">Applications</div>
                            <div class="metric-value">{{ $report->total_applications }}</div>
                        </div>
                    </div>
                </div>
                
                <!-- Row 2 -->
                <div class="metrics-row">
                    <div class="metric-cell">
                        <div class="metric-box yellow">
                            <div class="metric-label">Workers Hired</div>
                            <div class="metric-value">{{ $report->total_workers_hired }}</div>
                        </div>
                    </div>
                    <div class="metric-cell">
                        <div class="metric-box orange">
                            <div class="metric-label">Total Revenue</div>
                            <div class="metric-value" style="font-size: 14px;">UGX {{ number_format($report->total_revenue / 1000, 0) }}K</div>
                        </div>
                    </div>
                    <div class="metric-cell">
                        <div class="metric-box pink">
                            <div class="metric-label">Transactions</div>
                            <div class="metric-value">{{ $report->total_transactions }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Performers -->
        <div class="section">
            <div class="section-header">
                <div class="section-title"><span class="icon-trophy"></span>Top Performers</div>
            </div>
            
            <div class="performers-grid">
                <div class="performers-row">
                    <div class="performer-cell">
                        <div class="performer-box">
                            <div class="performer-title"><span class="icon-trophy"></span>Most Active Employer</div>
                            <div class="performer-value">{{ $report->most_active_employer ?: 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="performer-cell">
                        <div class="performer-box">
                            <div class="performer-title"><span class="icon-star"></span>Most Active Worker</div>
                            <div class="performer-value">{{ $report->most_active_worker ?: 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Health & Report Info Combined -->
        <div class="section">
            <div class="section-header">
                <div class="section-title">⚙️ System Health & Report Information</div>
            </div>
            
            <table class="info-table">
                <tr>
                    <td><span class="icon-warning"></span>System Errors</td>
                    <td><strong>{{ $report->system_errors }}</strong></td>
                </tr>
                @if($report->average_response_time)
                <tr>
                    <td>⏱️ Avg Response Time</td>
                    <td><strong>{{ $report->average_response_time }}ms</strong></td>
                </tr>
                @endif
                <tr>
                    <td>📅 Generated On</td>
                    <td><strong>{{ $report->created_at->format('M d, Y \a\t h:i A') }}</strong></td>
                </tr>
                <tr>
                    <td>📋 Report Type</td>
                    <td><strong>Automated Weekly Report</strong></td>
                </tr>
            </table>

            @if($report->system_errors > 0)
            <div class="warning-box">
                <div class="warning-text">
                    <span class="icon-warning"></span>{{ $report->system_errors }} system errors detected. Review logs recommended.
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Compact Footer -->
    <div class="footer">
        <div class="footer-logo">JOB-lyNK</div>
        <div class="footer-tagline">Connecting Talent with Opportunity</div>
        <div class="footer-contact">
            Automated Report • For support: support@joblynk.com | +256 700 000 000
        </div>
    </div>
</body>
</html>
