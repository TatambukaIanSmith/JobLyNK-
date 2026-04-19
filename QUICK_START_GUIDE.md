# Quick Start Guide - Weekly System Reports

## ✅ System Status: FULLY OPERATIONAL

All PDF generation functionality has been fixed and tested successfully!

## How to Use the System

### 1. Access System Reports

1. Log in to the **Admin Dashboard**
2. Navigate to **Settings & Tools** section
3. Click the **"System Reports"** button (indigo button with chart icon)

### 2. View Reports

The modal will display all generated weekly reports with:
- 📊 Key metrics (users, jobs, applications, workers hired)
- 💰 Financial data (revenue, transactions)
- 🏆 Top performers (most active employer & worker)
- ⚠️ System health (error count)

### 3. Generate New Report

Click **"Generate Report Now"** to create a report for the most recent week.

### 4. View/Download PDF

For each report:
- Click **"View PDF"** → Opens in browser
- Click **"Download PDF"** → Saves to your computer

## Automated Reports

Reports are automatically generated:
- **When**: Every Sunday at 11:59 PM
- **What**: Statistics for the past week
- **How**: Laravel scheduler

### To Enable Automation:

**Development:**
```bash
php artisan schedule:work
```

**Production (add to crontab):**
```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

## Manual Commands

### Generate Report
```bash
php artisan report:weekly
```

### Force Regenerate Current Week
```bash
php artisan report:weekly --force
```

### Check Reports
```bash
php artisan tinker --execute="echo App\Models\SystemReport::count();"
```

## What Was Fixed

1. ✅ Published DomPDF configuration
2. ✅ Added PDF facade alias to config/app.php
3. ✅ Created storage/app/reports directory
4. ✅ Cleared all caches
5. ✅ Verified all routes are working
6. ✅ Tested PDF generation end-to-end

## Report Contents

Each PDF includes:
- Executive summary
- User registration stats
- Job posting metrics
- Application statistics
- Worker hiring data
- Revenue and transaction totals
- Top performers
- System error count
- Professional JOB-lyNK branding

## Troubleshooting

### If reports don't show:
```bash
php artisan report:weekly --force
```

### If PDF doesn't generate:
```bash
php artisan config:clear
php artisan optimize:clear
```

### Check logs:
```bash
tail -f storage/logs/laravel.log
```

## File Locations

- **PDFs**: `storage/app/reports/`
- **Config**: `config/dompdf.php`
- **Template**: `resources/views/reports/weekly-report-pdf.blade.php`
- **Controller**: `app/Http/Controllers/AdminController.php`

## Support

All systems are working correctly. If you encounter any issues:
1. Check the logs
2. Clear caches
3. Verify report data exists in database

---

**Status**: ✅ Ready to Use
**Last Tested**: March 8, 2026
**All Tests**: PASSED
