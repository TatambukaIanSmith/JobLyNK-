# OAuth Setup Guide for JOB-lyNK

This guide will help you set up Google and Facebook OAuth authentication for the JOB-lyNK platform.

## Prerequisites

- Laravel Socialite is already installed ✅
- OAuth routes are configured ✅
- OAuth controllers are implemented ✅

## 1. Google OAuth Setup

### Step 1: Create Google OAuth Application

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable the Google+ API:
   - Go to "APIs & Services" > "Library"
   - Search for "Google+ API" and enable it
4. Create OAuth 2.0 credentials:
   - Go to "APIs & Services" > "Credentials"
   - Click "Create Credentials" > "OAuth 2.0 Client IDs"
   - Choose "Web application"
   - Add authorized redirect URIs:
     - `http://localhost:8000/auth/google/callback` (for local development)
     - `https://yourdomain.com/auth/google/callback` (for production)

### Step 2: Configure Google Credentials

Add the following to your `.env` file:

```env
GOOGLE_CLIENT_ID=your_google_client_id_here
GOOGLE_CLIENT_SECRET=your_google_client_secret_here
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"
```

## 2. Facebook OAuth Setup

### Step 1: Create Facebook App

1. Go to [Facebook Developers](https://developers.facebook.com/)
2. Click "My Apps" > "Create App"
3. Choose "Consumer" as the app type
4. Fill in your app details
5. Add Facebook Login product:
   - Go to "Products" > "Facebook Login" > "Settings"
   - Add Valid OAuth Redirect URIs:
     - `http://localhost:8000/auth/facebook/callback` (for local development)
     - `https://yourdomain.com/auth/facebook/callback` (for production)

### Step 2: Configure Facebook Credentials

Add the following to your `.env` file:

```env
FACEBOOK_CLIENT_ID=your_facebook_app_id_here
FACEBOOK_CLIENT_SECRET=your_facebook_app_secret_here
FACEBOOK_REDIRECT_URI="${APP_URL}/auth/facebook/callback"
```

## 3. Testing OAuth Integration

### Local Testing

1. Make sure your Laravel app is running on `http://localhost:8000`
2. Update your `.env` file with the OAuth credentials
3. Clear the config cache: `php artisan config:clear`
4. Visit the registration page and test the OAuth buttons

### OAuth Flow

1. User clicks "Continue with Google" or "Continue with Facebook"
2. User is redirected to the OAuth provider
3. User authorizes the application
4. User is redirected back with authorization code
5. Application exchanges code for user information
6. User is either logged in (if account exists) or registered (if new user)

## 4. Account Type Preservation

The OAuth implementation preserves the selected account type (Worker/Employer) through the authentication flow using session storage:

1. When user clicks OAuth button, account type is stored in session
2. After OAuth callback, account type is retrieved from session
3. New users are created with the selected account type
4. Session data is cleaned up after use

## 5. Security Considerations

- OAuth credentials should be kept secure and not committed to version control
- Use HTTPS in production
- Regularly rotate OAuth secrets
- Monitor OAuth usage in provider dashboards

## 6. Troubleshooting

### Common Issues

1. **"Redirect URI mismatch"**: Ensure the redirect URI in your OAuth app matches exactly with your configured URI
2. **"Invalid client"**: Check that your client ID and secret are correct
3. **"Scope error"**: Ensure you're requesting appropriate scopes (email, profile)

### Debug Mode

The application includes error handling that will redirect users back to the registration page with error messages if OAuth fails.

## 7. Production Deployment

Before deploying to production:

1. Update OAuth app settings with production URLs
2. Update `.env` with production OAuth credentials
3. Ensure HTTPS is configured
4. Test OAuth flow on production environment

## Current Implementation Status

✅ Laravel Socialite installed
✅ OAuth routes configured
✅ OAuth controllers implemented
✅ Account type preservation
✅ Error handling
✅ User creation/login logic
✅ Registration form integration

## Next Steps

1. Obtain OAuth credentials from Google and Facebook
2. Update `.env` file with credentials
3. Test OAuth flow
4. Deploy to production with production OAuth credentials