# Automatic Weekly Reports - Setup Guide

## How It Works

The system is configured to automatically generate weekly reports **every Sunday at 11:59 PM** without any manual intervention. However, Laravel's scheduler needs to be running for this to work.

## Current Configuration ✅

The scheduler is already configured in `routes/console.php`:
```php
Schedule::command('report:weekly')->weeklyOn(0, '23:59');
```

This means:
- **Day**: Sunday (0 = Sunday)
- **Time**: 11:59 PM
- **Action**: Generate weekly report automatically
- **No manual clicking required!**

## Setup Methods

Choose ONE of the following methods:

---

## Method 1: Development Mode (Simple)

### For Testing & Development

**Step 1**: Open a new terminal/command prompt

**Step 2**: Run the scheduler:
```bash
php artisan schedule:work
```

**OR** double-click the file: `START_SCHEDULER.bat`

**What happens:**
- The scheduler runs continuously
- Checks every minute if any tasks need to run
- When Sunday 11:59 PM arrives, it automatically generates the report
- Keep this terminal window open

**Pros:**
- ✅ Simple to start
- ✅ See real-time output
- ✅ Easy to stop (Ctrl+C)

**Cons:**
- ❌ Must keep terminal open
- ❌ Stops when you close the terminal
- ❌ Not suitable for production

---

## Method 2: Windows Task Scheduler (Production)

### For Production/Always Running

**Step 1**: Right-click `SETUP_WINDOWS_TASK_SCHEDULER.bat`

**Step 2**: Select **"Run as administrator"**

**Step 3**: Press any key to confirm

**What happens:**
- Creates a Windows Task that runs every minute
- The task executes `php artisan schedule:run`
- Laravel checks if any scheduled tasks need to run
- When Sunday 11:59 PM arrives, report is generated automatically
- Runs in the background, even after restart

**Pros:**
- ✅ Runs automatically in background
- ✅ Survives computer restarts
- ✅ No terminal needed
- ✅ Production-ready

**Cons:**
- ❌ Requires administrator privileges
- ❌ Less visible (runs silently)

### To Verify Windows Task:
1. Press `Win + R`
2. Type `taskschd.msc` and press Enter
3. Look for **"JOB-lyNK-Scheduler"** in the task list

### To Remove Windows Task:
```bash
schtasks /delete /tn "JOB-lyNK-Scheduler" /f
```

---

## Method 3: Linux/Production Server (Cron Job)

If you deploy to a Linux server, add this to your crontab:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

**To edit crontab:**
```bash
crontab -e
```

---

## Testing the Scheduler

### Test 1: Check if scheduler is working
```bash
php artisan schedule:list
```

You should see:
```
0 23 * * 0  php artisan report:weekly .... Next Due: [Next Sunday at 11:59 PM]
```

### Test 2: Generate a report manually (to test the system)
```bash
php artisan report:weekly --force
```

### Test 3: Check if reports are being created
```bash
php artisan tinker --execute="echo 'Reports: ' . App\Models\SystemReport::count();"
```

---

## How Automatic Generation Works

### Timeline:

**Sunday 11:59 PM arrives:**
1. ⏰ Scheduler detects it's time to run
2. 🔄 Executes `php artisan report:weekly`
3. 📊 ReportService collects statistics from database
4. 💾 Saves report to `system_reports` table
5. ✅ Report is ready to view in admin dashboard

**Monday morning:**
- You log into admin dashboard
- Click "System Reports"
- See the new report automatically generated
- View/Download PDF without doing anything

### What Gets Generated:

Each Sunday, the system automatically calculates:
- 👥 New users registered (last 7 days)
- 💼 Jobs posted (last 7 days)
- 📝 Applications submitted (last 7 days)
- ✅ Workers hired (last 7 days)
- 💰 Revenue generated (last 7 days)
- 💳 Transactions processed (last 7 days)
- 🏆 Most active employer
- ⭐ Most active worker
- ⚠️ System errors count

---

## Verification Checklist

After setting up the scheduler, verify:

- [ ] Scheduler is running (Method 1 or 2 active)
- [ ] Can see scheduled tasks: `php artisan schedule:list`
- [ ] Test report generation works: `php artisan report:weekly --force`
- [ ] Reports appear in admin dashboard
- [ ] PDF generation works

---

## Troubleshooting

### Issue: "No scheduled commands are ready to run"
**Solution**: This is normal! It means no tasks are due right now. The report will run automatically on Sunday at 11:59 PM.

### Issue: Reports not generating on Sunday
**Solution**: 
1. Check if scheduler is running: `php artisan schedule:list`
2. Verify Windows Task is active (if using Method 2)
3. Check logs: `storage/logs/laravel.log`

### Issue: Want to test without waiting for Sunday
**Solution**: 
```bash
php artisan report:weekly --force
```
This generates a report immediately for testing.

### Issue: Scheduler stopped working
**Solution**:
- **Method 1**: Restart `php artisan schedule:work`
- **Method 2**: Check Windows Task Scheduler is still active

---

## Current Status

✅ **Scheduler Configuration**: Complete
✅ **Report Command**: Working
✅ **Database**: Ready
✅ **PDF Generation**: Working
✅ **Admin Dashboard**: Ready

⚠️ **Action Required**: Choose and activate ONE of the setup methods above

---

## Recommended Setup

### For Development:
Use **Method 1** (START_SCHEDULER.bat)
- Easy to start/stop
- See what's happening
- Good for testing

### For Production:
Use **Method 2** (Windows Task Scheduler)
- Runs automatically
- Survives restarts
- No maintenance needed

---

## Summary

**Without Scheduler Running:**
- ❌ Reports will NOT generate automatically
- ❌ You must click "Generate Report Now" manually

**With Scheduler Running:**
- ✅ Reports generate automatically every Sunday at 11:59 PM
- ✅ No manual intervention needed
- ✅ Just view them in admin dashboard when ready

**Next Steps:**
1. Choose your setup method (1 or 2)
2. Follow the steps above
3. Wait for Sunday 11:59 PM (or test with `--force`)
4. Check admin dashboard for new reports

---

**Last Updated**: March 8, 2026
**Status**: Ready for Activation
