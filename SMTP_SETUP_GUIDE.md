# 📧 SMTP Setup Guide for Gletr Marketplace

## 🔧 Where to Configure SMTP Settings

### 1. **Environment File (.env) - Primary Configuration**

Create or edit your `.env` file in the project root with these SMTP settings:

```env
# ==========================================
# SMTP EMAIL CONFIGURATION
# ==========================================

# Choose your mail driver
MAIL_MAILER=smtp

# SMTP Server Settings
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls

# Email From Address
MAIL_FROM_ADDRESS=noreply@gletr.com
MAIL_FROM_NAME="Gletr Marketplace"

# Support Email (used in templates)
MAIL_SUPPORT_ADDRESS=support@gletr.com
```

---

## 📮 Popular SMTP Providers

### **1. Gmail SMTP**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```
**Note:** Use App Password, not regular password for Gmail

### **2. Outlook/Hotmail SMTP**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp-mail.outlook.com
MAIL_PORT=587
MAIL_USERNAME=your-email@outlook.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
```

### **3. Yahoo SMTP**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mail.yahoo.com
MAIL_PORT=587
MAIL_USERNAME=your-email@yahoo.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

### **4. Mailtrap (for Testing)**
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
```

### **5. SendGrid SMTP**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
```

---

## 🎯 Admin Panel Email Configuration

After setting up SMTP, configure emails in the admin panel:

### **Access Location:**
**Admin Panel → Business Settings → Email Configuration**

### **Available Controls:**
- ✅ **Enable/Disable** individual email types
- ✅ **Customize Subject Lines** with variables
- ✅ **Test Email Functionality** 
- ✅ **Customer Emails:** Registration, Orders, Password Reset
- ✅ **Seller Emails:** Registration, Verification, Orders, Payments

---

## ⚡ Quick Setup Steps

### **1. Configure SMTP in .env:**
```bash
# Copy .env.example to .env if it doesn't exist
cp .env.example .env

# Edit .env file with your SMTP settings
```

### **2. Initialize Email Configurations:**
```bash
# Run migration to create email_configurations table
php artisan migrate

# Seed default email configurations
php artisan db:seed --class=EmailConfigurationSeeder
```

### **3. Test Email Setup:**
1. Go to **Admin Panel → Business Settings → Email Configuration**
2. Click **"Initialize Default Configs"** if configurations are missing
3. Use **"Test Email"** button to verify SMTP is working
4. Enable/disable emails as needed

### **4. Clear Caches:**
```bash
php artisan config:clear
php artisan cache:clear
```

---

## 🔍 Troubleshooting

### **Common Issues:**

#### **1. Gmail "Less Secure Apps" Error:**
- Use **App Passwords** instead of regular password
- Enable 2-Factor Authentication
- Generate App Password in Google Account settings

#### **2. "Connection Refused" Error:**
- Check MAIL_HOST and MAIL_PORT
- Verify firewall/network settings
- Try different ports (25, 465, 587)

#### **3. "Authentication Failed" Error:**
- Double-check MAIL_USERNAME and MAIL_PASSWORD
- Ensure credentials are correct
- Check if account is locked/suspended

#### **4. Emails Not Sending:**
- Check `storage/logs/laravel.log` for errors
- Verify email configurations are enabled in admin panel
- Test with Mailtrap first before using production SMTP

---

## 📧 Email Templates Location

Email templates are stored in:
- `resources/views/emails/customer/` - Customer email templates
- `resources/views/emails/seller/` - Seller email templates

### **Available Variables in Templates:**
- `{{site_name}}` - Website name
- `{{customer_name}}` - Customer name
- `{{seller_name}}` - Seller name
- `{{business_name}}` - Business name
- `{{order_number}}` - Order number
- `{{verification_link}}` - Email verification URL
- `{{support_email}}` - Support email address

---

## ✅ Verification

After setup, emails will automatically be sent for:
- ✅ **Customer Registration** - Welcome email with verification
- ✅ **Seller Registration** - Registration confirmation
- ✅ **Order Events** - Order placed, shipped, delivered, etc.
- ✅ **Password Resets** - Secure password reset links

**Test the setup by registering a new customer or seller!**
