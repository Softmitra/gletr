# Gletr Jewellery Marketplace - Deployment Guide

## Apache2 VPS Deployment

This guide covers deploying the Gletr Jewellery Marketplace on a VPS with Apache2.

### Prerequisites

- Ubuntu 22.04 LTS VPS
- Root or sudo access
- Domain name pointed to your VPS IP
- At least 2GB RAM and 20GB storage

### 1. Initial Server Setup

Run the automated setup script:

```bash
# Download and run the setup script
curl -o install.sh https://raw.githubusercontent.com/your-repo/gletr/main/deploy/server-setup/install.sh
chmod +x install.sh
sudo ./install.sh
```

This script will install:
- Apache2 with required modules
- PHP 8.2 with extensions
- MySQL 8.0
- Redis
- Node.js 20 LTS
- Composer
- Supervisor
- Certbot for SSL

### 2. Clone Repository

```bash
cd /var/www
sudo git clone https://github.com/your-repo/gletr.git
sudo chown -R www-data:www-data gletr
```

### 3. Configure Environment

```bash
cd /var/www/gletr
sudo -u www-data cp .env.production .env
sudo -u www-data nano .env
```

Update the following variables in `.env`:
```env
APP_NAME="Gletr Jewellery Marketplace"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gletr_production
DB_USERNAME=gletr_user
DB_PASSWORD=your_secure_password

# Update other settings as needed
```

### 4. Install Dependencies

```bash
cd /var/www/gletr
sudo -u www-data composer install --no-dev --optimize-autoloader
sudo -u www-data npm ci --production
sudo -u www-data npm run build
```

### 5. Generate Application Key

```bash
sudo -u www-data php artisan key:generate
```

### 6. Configure Database

```bash
# Create database and user
sudo mysql -e "CREATE DATABASE gletr_production CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
sudo mysql -e "CREATE USER 'gletr_user'@'localhost' IDENTIFIED BY 'your_secure_password';"
sudo mysql -e "GRANT ALL PRIVILEGES ON gletr_production.* TO 'gletr_user'@'localhost';"
sudo mysql -e "FLUSH PRIVILEGES;"

# Run migrations and seeders
sudo -u www-data php artisan migrate --force
sudo -u www-data php artisan db:seed --force
```

### 7. Configure Apache2

```bash
# Copy Apache configuration
sudo cp /var/www/gletr/deploy/apache2/gletr.conf /etc/apache2/sites-available/

# Enable the site
sudo a2ensite gletr.conf
sudo a2dissite 000-default

# Test configuration
sudo apache2ctl configtest

# Reload Apache
sudo systemctl reload apache2
```

### 8. Set Up SSL Certificate

```bash
# Install SSL certificate with Certbot
sudo certbot --apache -d yourdomain.com -d www.yourdomain.com

# Test automatic renewal
sudo certbot renew --dry-run
```

### 9. Configure Queue Workers

The supervisor configuration is already set up. Start the workers:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start gletr-worker:*
```

### 10. Set Proper Permissions

```bash
cd /var/www/gletr
sudo chown -R www-data:www-data .
sudo find . -type d -exec chmod 755 {} \;
sudo find . -type f -exec chmod 644 {} \;
sudo chmod +x artisan
sudo chmod -R 775 storage bootstrap/cache
```

### 11. Configure Cron Jobs

```bash
# Add Laravel scheduler to crontab
sudo crontab -u www-data -e

# Add this line:
* * * * * cd /var/www/gletr && php artisan schedule:run >> /dev/null 2>&1
```

### 12. Final Steps

```bash
# Clear and cache configurations
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache

# Restart services
sudo systemctl restart apache2
sudo systemctl restart php8.2-fpm
sudo systemctl restart redis-server
```

## Automated Deployment

For future deployments, use the deployment script:

```bash
cd /var/www/gletr
sudo chmod +x deploy/scripts/deploy.sh
sudo ./deploy/scripts/deploy.sh production
```

## Rollback

If something goes wrong, you can rollback:

```bash
sudo ./deploy/scripts/deploy.sh rollback
```

## Monitoring

### Log Files
- Application logs: `/var/www/gletr/storage/logs/`
- Apache logs: `/var/log/apache2/`
- PHP-FPM logs: `/var/log/php8.2-fpm.log`

### Service Status
```bash
# Check service status
sudo systemctl status apache2
sudo systemctl status php8.2-fpm
sudo systemctl status mysql
sudo systemctl status redis-server
sudo supervisorctl status
```

### Performance Monitoring
- Set up monitoring tools like New Relic, Datadog, or custom monitoring
- Monitor disk space, memory usage, and database performance
- Set up alerts for critical issues

## Security Checklist

- [ ] SSL certificate installed and auto-renewal configured
- [ ] Firewall configured (UFW)
- [ ] Database user has minimal required permissions
- [ ] File permissions set correctly
- [ ] Regular security updates scheduled
- [ ] Backup strategy implemented
- [ ] Monitoring and alerting configured

## Backup Strategy

### Database Backups
```bash
# Daily database backup (add to cron)
0 2 * * * mysqldump -u gletr_user -p'password' gletr_production > /var/backups/gletr/db_$(date +\%Y\%m\%d).sql
```

### File Backups
```bash
# Weekly file backup (add to cron)
0 3 * * 0 tar -czf /var/backups/gletr/files_$(date +\%Y\%m\%d).tar.gz /var/www/gletr/storage/app/public
```

## Troubleshooting

### Common Issues

1. **Permission Denied Errors**
   ```bash
   sudo chown -R www-data:www-data /var/www/gletr
   sudo chmod -R 775 /var/www/gletr/storage /var/www/gletr/bootstrap/cache
   ```

2. **Database Connection Issues**
   - Check database credentials in `.env`
   - Verify MySQL service is running
   - Check firewall rules

3. **Queue Jobs Not Processing**
   ```bash
   sudo supervisorctl restart gletr-worker:*
   sudo -u www-data php artisan queue:restart
   ```

4. **SSL Certificate Issues**
   ```bash
   sudo certbot certificates
   sudo certbot renew
   ```

For more help, check the application logs and Apache error logs.
