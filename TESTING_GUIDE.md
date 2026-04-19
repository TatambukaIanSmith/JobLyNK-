# Testing Guide - JOB-lyNK

## Server Status
✅ Server is running at: `http://127.0.0.1:8000`

## Test Accounts

### Employer Account
- **Email:** `employer@example.com`
- **Password:** `password`

### Worker Account  
- **Email:** `test@example.com`
- **Password:** `password`

---

## Testing Job Posting Functionality

### Step 1: Login as Employer
1. Go to: `http://127.0.0.1:8000/login`
2. Login with employer credentials
3. Should redirect to: `/employerDashboard`

### Step 2: Access Post Job Form
1. Click "Post New Job" button or go to: `http://127.0.0.1:8000/postjob`
2. Verify:
   - ✅ Form loads correctly
   - ✅ Categories dropdown is populated (8 categories)
   - ✅ All form fields are visible

### Step 3: Fill and Submit Form
1. Fill in the form:
   - **Job Title:** "House Deep Cleaning"
   - **Category:** Select "Cleaning & Housekeeping"
   - **Description:** "Need thorough cleaning of a 3-bedroom house..."
   - **Location:** "Downtown, City Center"
   - **Job Type:** "One-time task"
   - **Payment Type:** "Hourly Rate"
   - **Budget:** 25
   - **Duration:** "3-5 hours"
   - **Start Date:** Tomorrow's date
   - **Urgency:** "Normal"
   - Select some skills (optional)
2. Click through all 3 steps
3. Submit the form

### Step 4: Verify Success
1. Should redirect to `/employerDashboard`
2. Should see success message: "Job 'House Deep Cleaning' posted successfully!"
3. Should see the job listed in "My Job Postings" section
4. Check database:
   ```bash
   php artisan tinker
   >>> App\Models\Job::count()
   >>> App\Models\Job::latest()->first()
   ```

### Step 5: Test Validation
1. Try submitting form with missing required fields
2. Should see validation errors displayed
3. Try invalid date (past date)
4. Should see date validation error

---

## Testing Role-Based Access

### Test 1: Employer Access
1. Login as employer
2. Try accessing `/postjob` → ✅ Should work
3. Try accessing `/worker` → ❌ Should get 403 error

### Test 2: Worker Access  
1. Login as worker
2. Try accessing `/postjob` → ❌ Should get 403 error
3. Try accessing `/worker` → ✅ Should work

### Test 3: Unauthenticated Access
1. Logout
2. Try accessing `/postjob` → Should redirect to login
3. Try accessing `/employerDashboard` → Should redirect to login

---

## Current Status

✅ **Completed:**
- Database schema created
- Role-based authentication
- Job posting form
- Job storage functionality
- Employer dashboard with job listings

⏳ **Next to Test:**
- Job listing page (for workers to see jobs)
- Job application functionality
- Search and filter functionality

---

## Debugging Tips

### Check Logs
```bash
tail -f storage/logs/laravel.log
```

### Check Database
```bash
php artisan tinker
>>> App\Models\Job::all()
>>> App\Models\User::where('role', 'employer')->first()
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```


