# Weekly System Reports - Implementation Guide

## ✅ Completed Components

### 1. Database Migration
- **File**: `database/migrations/2026_03_08_184201_create_system_reports_table.php`
- **Status**: ✅ Migrated successfully
- **Table**: `system_reports` with all required fields

### 2. SystemReport Model
- **File**: `app/Models/SystemReport.php`
- **Features**:
  - All fillable fields configured
  - Date casting for week dates
  - Helper methods for formatted output

### 3. ReportService
- **File**: `app/Services/ReportService.php`
- **Features**:
  - Collects accurate statistics from database
  - Calculates all metrics (users, jobs, applications, revenue, etc.)
  - Identifies most active employer and worker
  - Counts system errors from logs
  - Generates report summary text

### 4. Console Command
- **File**: `app/Console/Commands/GenerateWeeklySystemReport.php`
- **Command**: `php artisan report:weekly`
- **Features**:
  - Calculates last week's date range (Monday-Sunday)
  - Prevents duplicate reports
  - `--force` flag to regenerate existing reports
  - Logs all activities

### 5. Laravel Scheduler
- **File**: `routes/console.php`
- **Schedule**: Every Sunday at 11:59 PM
- **Command**: Automatically runs `report:weekly`

## 🔄 To Activate Scheduler

Add this to your cron tab (Linux/Mac) or Task Scheduler (Windows):

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

Or for development, run:
```bash
php artisan schedule:work
```

## 📊 Manual Report Generation

Generate report manually:
```bash
php artisan report:weekly
```

Force regenerate existing report:
```bash
php artisan report:weekly --force
```

## 🎯 Next Steps (To Be Implemented)

### 1. Admin Dashboard Integration
Add to AdminController:
```php
public function viewReports()
{
    $reports = SystemReport::orderBy('week_start_date', 'desc')->paginate(10);
    return view('admin.reports', compact('reports'));
}

public function getReportData($id)
{
    $report = SystemReport::findOrFail($id);
    return response()->json($report);
}
```

### 2. Add Routes
```php
Route::get('/admin/reports', [AdminController::class, 'viewReports'])->name('admin.reports');
Route::get('/admin/reports/{id}', [AdminController::class, 'getReportData'])->name('admin.reports.show');
```

### 3. Add to Admin Sidebar
Add menu item in Admin.blade.php sidebar:
```html
<a href="#" onclick="showReportsSection()" class="sidebar-link">
    <i class="fas fa-chart-line"></i>
    <span>System Reports</span>
</a>
```

### 4. Email Notifications (Optional)
Create mail class:
```bash
php artisan make:mail WeeklyReportMail
```

### 5. PDF Generation (Optional)
Install package:
```bash
composer require barryvdh/laravel-dompdf
```

## 📈 Report Data Structure

Each report contains:
- Week date range
- Total new users
- Total jobs posted
- Total applications
- Total workers hired
- Total transactions
- Total revenue
- Most active employer
- Most active worker
- System errors count
- Average response time

## 🔍 Testing

Test the report generation:
```bash
php artisan report:weekly
```

Check the database:
```sql
SELECT * FROM system_reports ORDER BY created_at DESC LIMIT 1;
```

## 📝 Notes

- Reports are generated for the previous week (Monday-Sunday)
- Duplicate prevention ensures one report per week
- All statistics are calculated directly from database
- System errors are counted from Laravel logs
- Revenue only counts completed payments
