# Gmail SMTP Setup for PageTurner Bookstore

This guide explains how to configure Gmail SMTP for Laravel authentication and notifications.

## A.1 Important Security Note

Google no longer allows "Less Secure Apps." To use Gmail SMTP in Laravel, you must:
1. Enable 2-Step Verification in your Google Account
2. Generate an App Password
3. Use the App Password inside the `.env` file

**Never use your actual Gmail password in the .env file.**

---

## A.2 Step 1 — Enable 2-Step Verification

1. Log in to your Google account
2. Go to Google Account Settings
3. Navigate to: Security → "Signing in to Google"
4. Enable 2-Step Verification
5. Complete phone verification setup

*Without 2-Step Verification enabled, App Passwords cannot be created.*

---

## A.3 Step 2 — Generate an App Password

1. In Google Account → Security
2. Click "App passwords"
3. Select:
   - App: Mail
   - Device: Windows Computer (or Other)
4. Click "Generate"
5. Google will provide a 16-character password

Example: `abcd efgh ijkl mnop`

Copy this password — it will be used in Laravel.

---

## A.4 Step 3 — Configure Laravel .env for Gmail SMTP

Open your `.env` file and update the following:

```env
# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=yourgmail@gmail.com
MAIL_PASSWORD=your_generated_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=yourgmail@gmail.com
MAIL_FROM_NAME="PageTurner Bookstore"
```

**Example:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=pageturnerbookstore@gmail.com
MAIL_PASSWORD=abcd efgh ijkl mnop
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=pageturnerbookstore@gmail.com
MAIL_FROM_NAME="PageTurner Bookstore"
```

> **Note:** Remove spaces from the generated password if needed.

---

## A.5 Clear Configuration Cache

After updating `.env`, run:

```bash
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

---

## A.6 Testing Gmail SMTP

Run:
```bash
php artisan tinker
```

Then:
```php
Mail::raw('Gmail SMTP Test Successful', function ($message) {
    $message->to('yourpersonalemail@example.com')
            ->subject('Laravel Gmail SMTP Test');
});
```

If you receive the email, your Gmail SMTP setup is successful.

---

## A.7 Common Gmail SMTP Errors & Fixes

### ❌ Error: Authentication Failed
- Ensure 2-Step Verification is enabled
- Ensure you are using App Password, NOT Gmail password

### ❌ Error: Could not connect to host
- Check:
  - MAIL_PORT=587
  - MAIL_ENCRYPTION=tls
- Ensure internet connection is active

### ❌ Error: SSL certificate issue (Localhost)
The `config/mail.php` file has been updated with:
```php
'stream' => [
    'ssl' => [
        'allow_self_signed' => true,
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
],
```
*(Use only for local development)*

---

## A.8 Best Practices for Students

- ✅ Use a dedicated Gmail account for development
- ✅ Never upload `.env` to GitHub
- ✅ Never expose App Password publicly
- ✅ Use Mailtrap in classroom environment if needed
- ✅ For production systems, use professional email services

---

## A.9 Where Gmail SMTP Is Used in This Laboratory

Once configured, Gmail SMTP will power:
- Email Verification
- Password Reset Emails
- 2FA OTP emails
- Order Notifications
- Review Notifications
- Admin Alerts

---

## Final Student Checklist (Gmail SMTP)

- [ ] 2-Step Verification enabled
- [ ] App Password generated
- [ ] `.env` configured correctly
- [ ] Config cache cleared
- [ ] Test email received successfully

