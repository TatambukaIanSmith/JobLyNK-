# Testing Instructions - Duplicate User Prevention

## 🎯 **Step-by-Step Testing Guide**

### **Test 1: Real-Time Email Validation**

1. **Open Registration Page**
   ```
   http://127.0.0.1:8000/register
   ```

2. **Test Existing Emails** (should show red X + error message):
   - Type: `test@example.com`
   - Type: `employer@example.com`
   - Type: `TEST@EXAMPLE.COM` (case test)

3. **Test New Email** (should show green checkmark):
   - Type: `newuser123@example.com`

### **Expected Real-Time Behavior:**
- **While typing**: No indicator
- **After 500ms**: Loading spinner appears
- **Existing email**: Red X + "Email already exists" + "Login instead?" link
- **Available email**: Green checkmark + "Email is available"

---

### **Test 2: Form Submission Prevention**

1. **Fill Complete Form** with duplicate email:
   ```
   Account Type: Worker (click the card)
   First Name: John
   Last Name: Doe  
   Email: test@example.com
   Phone: +1234567890
   Location: New York
   Password: password123
   Confirm Password: password123
   Bio: Test user
   ✓ Accept Terms
   ```

2. **Click "Create Account"**

3. **Expected Result**:
   ```
   ⚠️ Please fix the following issues:
   • An account with this email address already exists. Please use a different email or try logging in.
   
   ℹ️ Already have an account? [Login Instead] ← Blue button
   ```

---

### **Test 3: Successful Registration**

1. **Use Unique Email**: `testuser.$(date)@example.com`
2. **Fill all required fields**
3. **Submit form**
4. **Expected**: Successful registration → redirect to login page

---

## 🔍 **What to Look For:**

### **✅ Success Indicators:**
- Real-time email checking works as you type
- Visual feedback (icons, colors, messages)
- Clear error messages for duplicates
- "Login Instead" button appears for duplicates
- Debug info shows selected account type
- Form prevents submission with duplicates

### **❌ Issues to Report:**
- No real-time checking (JavaScript errors?)
- Duplicate emails allowed through
- Confusing error messages
- Missing visual feedback
- Account type not being detected

---

## 🛠️ **Debugging Tools:**

### **Browser Developer Tools (F12):**
1. **Console Tab**: Check for JavaScript errors
2. **Network Tab**: See API requests to `/api/check-email`
3. **Elements Tab**: Inspect form data being submitted

### **Expected Console Output:**
```javascript
Selected account type: worker
Form data being submitted:
accountType: worker
name: John Doe
email: test@example.com
...
```

---

## 📱 **Mobile Testing:**
- Test on phone/tablet if available
- Check responsive design
- Ensure touch interactions work

---

## 🎯 **Quick Test Checklist:**

- [ ] Registration page loads without errors
- [ ] Account type selection works (cards highlight)
- [ ] Real-time email checking shows feedback
- [ ] Existing emails show "already exists" message
- [ ] New emails show "available" message
- [ ] Form submission blocked for duplicates
- [ ] Error messages are clear and helpful
- [ ] "Login Instead" button works
- [ ] Successful registration with new email works

---

**Ready to test!** Open `http://127.0.0.1:8000/register` and try the scenarios above.