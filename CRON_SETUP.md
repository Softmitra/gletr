# 🕐 Cron Job Setup for Automatic Log Cleanup

## **📋 Overview**
This setup ensures that log files older than 14 days are automatically deleted every day at 2:00 AM.

## **🔧 Setup Instructions**

### **For Linux/Ubuntu Server:**

1. **Open crontab:**
```bash
crontab -e
```

2. **Add this line:**
```bash
0 2 * * * cd /path/to/your/gletr && php artisan schedule:run >> /dev/null 2>&1
```

3. **Replace `/path/to/your/gletr`** with your actual project path.

### **For Windows Server (Task Scheduler):**

1. **Open Task Scheduler**
2. **Create Basic Task**
3. **Set Trigger:** Daily at 2:00 AM
4. **Set Action:** Start a program
5. **Program:** `php`
6. **Arguments:** `artisan schedule:run`
7. **Start in:** `C:\xampp\htdocs\gletr` (your project path)

### **For XAMPP Local Development:**

1. **Manual cleanup (when needed):**
```bash
php artisan logs:cleanup
```

2. **Custom days:**
```bash
php artisan logs:cleanup --days=7
```

## **📊 What This Does:**

### **✅ Daily Log Files:**
- Creates new log file each day: `laravel-2025-01-03.log`
- Keeps logs organized by date
- Easy to find specific day's logs

### **🗑️ Automatic Cleanup:**
- Runs every day at 2:00 AM
- Deletes logs older than 14 days
- Frees up disk space automatically
- Logs cleanup activity for audit

### **📁 Log File Examples:**
```
storage/logs/
├── laravel-2025-01-03.log    (today)
├── laravel-2025-01-02.log    (yesterday)
├── laravel-2025-01-01.log    (2 days ago)
├── laravel-2024-12-31.log    (3 days ago)
└── ... (up to 14 days)
```

## **🧪 Testing:**

### **Test Cleanup Command:**
```bash
# Test with different retention periods
php artisan logs:cleanup --days=30
php artisan logs:cleanup --days=7
php artisan logs:cleanup --days=1
```

### **Check Scheduled Tasks:**
```bash
php artisan schedule:list
```

### **Run Scheduler Manually:**
```bash
php artisan schedule:run
```

## **📈 Benefits:**

1. **📅 Daily Files:** Easy to find logs by date
2. **🔄 Auto Cleanup:** No manual maintenance needed  
3. **💾 Disk Space:** Prevents log files from growing indefinitely
4. **📊 Audit Trail:** Cleanup activities are logged
5. **⚙️ Configurable:** Can adjust retention period as needed

## **🚨 Important Notes:**

- **Backup Important Logs:** Before enabling, backup any important logs
- **Test First:** Run manual cleanup to see what gets deleted
- **Monitor Disk Space:** Ensure adequate space for 14 days of logs
- **Adjust Retention:** Change `--days=14` if you need longer/shorter retention

## **🔍 Monitoring:**

Check cleanup logs in your daily log files:
```bash
tail -f storage/logs/laravel-$(date +%Y-%m-%d).log | grep "Log cleanup"
```
