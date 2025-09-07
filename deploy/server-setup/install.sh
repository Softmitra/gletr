#!/bin/bash

# Gletr Marketplace VPS Setup Script for Ubuntu 22.04 LTS with Apache2
# This script sets up the complete server environment

set -e

echo "🚀 Starting Gletr Marketplace VPS setup..."

# Update system packages
echo "📦 Updating system packages..."
sudo apt update && sudo apt upgrade -y

# Install essential packages
echo "📦 Installing essential packages..."
sudo apt install -y curl wget git unzip software-properties-common apt-transport-https ca-certificates gnupg lsb-release

# Install Apache2
echo "🌐 Installing Apache2..."
sudo apt install -y apache2
sudo systemctl enable apache2
sudo systemctl start apache2

# Enable Apache2 modules
echo "🔧 Enabling Apache2 modules..."
sudo a2enmod rewrite
sudo a2enmod ssl
sudo a2enmod headers
sudo a2enmod deflate
sudo a2enmod expires
sudo a2enmod proxy
sudo a2enmod proxy_fcgi
sudo a2enmod setenvif

# Install PHP 8.2
echo "🐘 Installing PHP 8.2..."
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install -y php8.2 php8.2-fpm php8.2-mysql php8.2-xml php8.2-gd php8.2-curl php8.2-mbstring php8.2-zip php8.2-bcmath php8.2-intl php8.2-redis php8.2-imagick

# Configure PHP-FPM
echo "⚙️ Configuring PHP-FPM..."
sudo systemctl enable php8.2-fpm
sudo systemctl start php8.2-fpm

# Install MySQL 8.0
echo "🗄️ Installing MySQL 8.0..."
sudo apt install -y mysql-server mysql-client

# Secure MySQL installation
echo "🔐 Securing MySQL installation..."
sudo mysql_secure_installation

# Install Redis
echo "📊 Installing Redis..."
sudo apt install -y redis-server
sudo systemctl enable redis-server
sudo systemctl start redis-server

# Install Node.js 20 LTS
echo "📦 Installing Node.js 20 LTS..."
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs

# Install Composer
echo "🎼 Installing Composer..."
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

# Install Supervisor for queue management
echo "👥 Installing Supervisor..."
sudo apt install -y supervisor
sudo systemctl enable supervisor
sudo systemctl start supervisor

# Install Certbot for SSL certificates
echo "🔒 Installing Certbot..."
sudo apt install -y certbot python3-certbot-apache

# Create project directory
echo "📁 Creating project directory..."
sudo mkdir -p /var/www/gletr
sudo chown -R www-data:www-data /var/www/gletr

# Create database and user
echo "🗄️ Setting up database..."
sudo mysql -e "CREATE DATABASE gletr_production CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
sudo mysql -e "CREATE USER 'gletr_user'@'localhost' IDENTIFIED BY 'secure_password_here';"
sudo mysql -e "GRANT ALL PRIVILEGES ON gletr_production.* TO 'gletr_user'@'localhost';"
sudo mysql -e "FLUSH PRIVILEGES;"

# Configure firewall
echo "🔥 Configuring firewall..."
sudo ufw allow OpenSSH
sudo ufw allow 'Apache Full'
sudo ufw --force enable

# Create backup directories
echo "📦 Creating backup directories..."
sudo mkdir -p /var/backups/gletr
sudo chown -R www-data:www-data /var/backups/gletr

# Configure log rotation
echo "📝 Setting up log rotation..."
sudo tee /etc/logrotate.d/gletr << EOF
/var/www/gletr/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    create 0644 www-data www-data
    postrotate
        sudo systemctl reload php8.2-fpm
    endscript
}
EOF

# Set up cron job for Laravel scheduler
echo "⏰ Setting up Laravel scheduler..."
(sudo crontab -u www-data -l 2>/dev/null; echo "* * * * * cd /var/www/gletr && php artisan schedule:run >> /dev/null 2>&1") | sudo crontab -u www-data -

# Create supervisor configuration for queue workers
echo "👥 Setting up queue workers..."
sudo tee /etc/supervisor/conf.d/gletr-worker.conf << EOF
[program:gletr-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/gletr/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/gletr/storage/logs/worker.log
stopwaitsecs=3600
EOF

# Reload supervisor
sudo supervisorctl reread
sudo supervisorctl update

# Configure PHP settings for production
echo "🐘 Configuring PHP for production..."
sudo tee -a /etc/php/8.2/fpm/conf.d/99-gletr.ini << EOF
; Gletr Marketplace PHP Configuration
upload_max_filesize = 50M
post_max_size = 50M
memory_limit = 512M
max_execution_time = 300
max_input_vars = 3000

; Security
expose_php = Off
display_errors = Off
log_errors = On
error_log = /var/log/php_errors.log

; Session
session.cookie_httponly = 1
session.cookie_secure = 1
session.use_strict_mode = 1

; OPcache
opcache.enable = 1
opcache.memory_consumption = 256
opcache.interned_strings_buffer = 16
opcache.max_accelerated_files = 10000
opcache.revalidate_freq = 2
opcache.fast_shutdown = 1
opcache.enable_cli = 1
EOF

# Restart services
echo "🔄 Restarting services..."
sudo systemctl restart php8.2-fpm
sudo systemctl restart apache2
sudo systemctl restart redis-server

# Display completion message
echo "🎉 VPS setup completed successfully!"
echo ""
echo "📋 Next steps:"
echo "1. Clone your repository to /var/www/gletr"
echo "2. Copy the Apache configuration: sudo cp /var/www/gletr/deploy/apache2/gletr.conf /etc/apache2/sites-available/"
echo "3. Enable the site: sudo a2ensite gletr.conf"
echo "4. Disable default site: sudo a2dissite 000-default"
echo "5. Test Apache configuration: sudo apache2ctl configtest"
echo "6. Reload Apache: sudo systemctl reload apache2"
echo "7. Set up SSL certificate: sudo certbot --apache -d yourdomain.com"
echo "8. Run the deployment script: ./deploy/scripts/deploy.sh"
echo ""
echo "🔐 Security reminders:"
echo "- Change the MySQL password for gletr_user"
echo "- Configure your .env file with secure values"
echo "- Set up regular backups"
echo "- Monitor logs regularly"
echo ""
echo "📊 Service status:"
sudo systemctl status apache2 --no-pager -l
sudo systemctl status php8.2-fpm --no-pager -l
sudo systemctl status mysql --no-pager -l
sudo systemctl status redis-server --no-pager -l
