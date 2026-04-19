# Password Authentication Flow - Where Passwords Come From

## 🔍 **Password Source & Flow**

### **1. Database Storage**
The system fetches passwords from the **`users` table** in your MySQL database:

```sql
-- Users table structure
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,  -- ← PASSWORDS STORED HERE
  `role` enum('worker','employer','admin') NOT NULL DEFAULT 'worker',
  -- ... other fields
);
```

### **2. Sample User Passwords**
The test users were created with **bcrypt-hashed passwords**:

```sql
-- From database_schema.sql (lines 262-263)
INSERT INTO `users` (`name`, `email`, `password`, `role`, `email_verified_at`, `created_at`, `updated_at`) VALUES
('Test Worker', 'test@example.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'worker', NOW(), NOW(), NOW()),
('Test Employer', 'employer@example.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'employer', NOW(), NOW(), NOW());
```

**Plain text password for both users**: `password`
**Hashed version**: `$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi`

## 🔐 **Authentication Flow**

### **Step 1: Login Form Submission**
```html
<!-- resources/views/files/login.blade.php -->
<form method="POST" action="{{ route('login') }}">
    @csrf
    <input name="email" type="email" required>
    <input name="password" type="password" required>
    <button type="submit">Sign In</button>
</form>
```

### **Step 2: Laravel Authentication Process**
1. **Route**: `POST /login` → Laravel Fortify handles this
2. **Validation**: Email and password are validated
3. **Database Query**: Laravel queries the `users` table:
   ```sql
   SELECT * FROM users WHERE email = 'test@example.com'
   ```
4. **Password Verification**: Laravel uses `Hash::check()` to compare:
   - **Input**: `password` (plain text from form)
   - **Database**: `$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi` (hashed)
   - **Result**: ✅ Match → Authentication successful

### **Step 3: User Model Configuration**
```php
// app/Models/User.php
class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'bio', 'location'
    ];

    protected $hidden = [
        'password',  // Hidden from JSON serialization
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',  // ← Auto-hashes on save
        ];
    }
}
```

### **Step 4: Authentication Configuration**
```php
// config/auth.php
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,  // ← Uses User model
    ],
],

'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',  // ← Uses users provider
    ],
],
```

## 🛠️ **How Password Hashing Works**

### **When Creating Users:**
```php
// Laravel automatically hashes passwords when saving
$user = User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => 'password',  // ← Plain text input
]);
// Database stores: $2y$12$... (bcrypt hash)
```

### **When Authenticating:**
```php
// Laravel's Hash::check() method
$inputPassword = 'password';  // From login form
$hashedPassword = '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';  // From database

if (Hash::check($inputPassword, $hashedPassword)) {
    // ✅ Authentication successful
    // User is logged in
}
```

## 📊 **Current Test Users**

| User | Email | Password | Role | Hash |
|------|-------|----------|------|------|
| Test Worker | test@example.com | `password` | worker | `$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi` |
| Test Employer | employer@example.com | `password` | employer | `$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi` |

## 🔄 **Complete Authentication Chain**

```
1. User enters credentials in login form
   ↓
2. Form submits to Laravel Fortify (/login)
   ↓
3. Fortify validates input
   ↓
4. Laravel queries users table by email
   ↓
5. Hash::check() compares input vs stored hash
   ↓
6. If match: User authenticated & session created
   ↓
7. If 2FA enabled: Redirect to 2FA challenge
   ↓
8. If 2FA disabled: Redirect to dashboard
```

## 🎯 **Key Points**

- ✅ **Passwords stored**: MySQL `users` table, `password` column
- ✅ **Hashing method**: bcrypt with cost factor 12
- ✅ **Authentication**: Laravel's built-in Hash::check()
- ✅ **Test password**: `password` for both demo users
- ✅ **Security**: Passwords never stored in plain text
- ✅ **Auto-hashing**: Laravel automatically hashes on User::create()

The system is using **Laravel's standard authentication** with **bcrypt password hashing** - industry standard and secure!