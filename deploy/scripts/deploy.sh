#!/bin/bash

# Gletr Marketplace Deployment Script for Apache2 VPS
# Usage: ./deploy.sh [environment]

set -e

ENVIRONMENT=${1:-production}
PROJECT_DIR="/var/www/gletr"
BACKUP_DIR="/var/backups/gletr"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)

echo "🚀 Starting deployment for environment: $ENVIRONMENT"

# Create backup directory if it doesn't exist
sudo mkdir -p $BACKUP_DIR

# Function to backup database
backup_database() {
    echo "📦 Creating database backup..."
    sudo mysqldump -u root -p gletr_$ENVIRONMENT > $BACKUP_DIR/database_backup_$TIMESTAMP.sql
    echo "✅ Database backup created: $BACKUP_DIR/database_backup_$TIMESTAMP.sql"
}

# Function to backup files
backup_files() {
    echo "📦 Creating files backup..."
    sudo tar -czf $BACKUP_DIR/files_backup_$TIMESTAMP.tar.gz -C $PROJECT_DIR storage/app/public
    echo "✅ Files backup created: $BACKUP_DIR/files_backup_$TIMESTAMP.tar.gz"
}

# Function to put application in maintenance mode
enable_maintenance() {
    echo "🔧 Enabling maintenance mode..."
    cd $PROJECT_DIR
    sudo -u www-data php artisan down --render="errors::503" --secret="gletr-maintenance-$TIMESTAMP"
    echo "✅ Maintenance mode enabled"
}

# Function to disable maintenance mode
disable_maintenance() {
    echo "🔧 Disabling maintenance mode..."
    cd $PROJECT_DIR
    sudo -u www-data php artisan up
    echo "✅ Maintenance mode disabled"
}

# Function to update code
update_code() {
    echo "📥 Updating code from repository..."
    cd $PROJECT_DIR
    
    # Pull latest changes
    sudo -u www-data git fetch origin
    sudo -u www-data git reset --hard origin/main
    
    # Install/update dependencies
    sudo -u www-data composer install --no-dev --optimize-autoloader --no-interaction
    
    # Install/update NPM dependencies and build assets
    sudo -u www-data npm ci --production
    sudo -u www-data npm run build
    
    echo "✅ Code updated successfully"
}

# Function to run database migrations
run_migrations() {
    echo "🗄️ Running database migrations..."
    cd $PROJECT_DIR
    sudo -u www-data php artisan migrate --force
    echo "✅ Database migrations completed"
}

# Function to clear and optimize caches
optimize_application() {
    echo "⚡ Optimizing application..."
    cd $PROJECT_DIR
    
    # Clear caches
    sudo -u www-data php artisan config:clear
    sudo -u www-data php artisan route:clear
    sudo -u www-data php artisan view:clear
    sudo -u www-data php artisan cache:clear
    
    # Optimize for production
    sudo -u www-data php artisan config:cache
    sudo -u www-data php artisan route:cache
    sudo -u www-data php artisan view:cache
    sudo -u www-data php artisan event:cache
    
    # Queue restart
    sudo -u www-data php artisan queue:restart
    
    echo "✅ Application optimized"
}

# Function to set proper permissions
set_permissions() {
    echo "🔐 Setting proper permissions..."
    
    # Set ownership
    sudo chown -R www-data:www-data $PROJECT_DIR
    
    # Set directory permissions
    sudo find $PROJECT_DIR -type d -exec chmod 755 {} \;
    
    # Set file permissions
    sudo find $PROJECT_DIR -type f -exec chmod 644 {} \;
    
    # Set executable permissions for artisan
    sudo chmod +x $PROJECT_DIR/artisan
    
    # Set writable permissions for storage and cache
    sudo chmod -R 775 $PROJECT_DIR/storage
    sudo chmod -R 775 $PROJECT_DIR/bootstrap/cache
    
    echo "✅ Permissions set correctly"
}

# Function to restart services
restart_services() {
    echo "🔄 Restarting services..."
    
    # Restart PHP-FPM
    sudo systemctl restart php8.2-fpm
    
    # Restart Apache2
    sudo systemctl restart apache2
    
    # Restart Redis (if using)
    sudo systemctl restart redis-server
    
    # Restart queue workers (if using supervisor)
    if systemctl is-active --quiet supervisor; then
        sudo supervisorctl restart all
    fi
    
    echo "✅ Services restarted"
}

# Function to run health checks
health_check() {
    echo "🏥 Running health checks..."
    
    # Check if application is responding
    if curl -f -s http://localhost > /dev/null; then
        echo "✅ Application is responding"
    else
        echo "❌ Application is not responding"
        exit 1
    fi
    
    # Check database connection
    cd $PROJECT_DIR
    if sudo -u www-data php artisan tinker --execute="DB::connection()->getPdo(); echo 'Database connected';" > /dev/null 2>&1; then
        echo "✅ Database connection successful"
    else
        echo "❌ Database connection failed"
        exit 1
    fi
    
    echo "✅ Health checks passed"
}

# Main deployment process
main() {
    echo "🎯 Starting deployment process..."
    
    # Create backups
    backup_database
    backup_files
    
    # Enable maintenance mode
    enable_maintenance
    
    # Update code and dependencies
    update_code
    
    # Run migrations
    run_migrations
    
    # Optimize application
    optimize_application
    
    # Set permissions
    set_permissions
    
    # Restart services
    restart_services
    
    # Disable maintenance mode
    disable_maintenance
    
    # Run health checks
    health_check
    
    echo "🎉 Deployment completed successfully!"
    echo "📝 Backup files created:"
    echo "   - Database: $BACKUP_DIR/database_backup_$TIMESTAMP.sql"
    echo "   - Files: $BACKUP_DIR/files_backup_$TIMESTAMP.tar.gz"
}

# Rollback function
rollback() {
    echo "🔄 Rolling back deployment..."
    
    # Enable maintenance mode
    enable_maintenance
    
    # Restore database from latest backup
    LATEST_DB_BACKUP=$(ls -t $BACKUP_DIR/database_backup_*.sql | head -n1)
    if [ -f "$LATEST_DB_BACKUP" ]; then
        echo "📥 Restoring database from $LATEST_DB_BACKUP"
        mysql -u root -p gletr_$ENVIRONMENT < $LATEST_DB_BACKUP
    fi
    
    # Restore files from latest backup
    LATEST_FILES_BACKUP=$(ls -t $BACKUP_DIR/files_backup_*.tar.gz | head -n1)
    if [ -f "$LATEST_FILES_BACKUP" ]; then
        echo "📥 Restoring files from $LATEST_FILES_BACKUP"
        sudo tar -xzf $LATEST_FILES_BACKUP -C $PROJECT_DIR
    fi
    
    # Restart services
    restart_services
    
    # Disable maintenance mode
    disable_maintenance
    
    echo "✅ Rollback completed"
}

# Check command line arguments
case "${1:-deploy}" in
    "deploy"|"production"|"staging")
        main
        ;;
    "rollback")
        rollback
        ;;
    *)
        echo "Usage: $0 [deploy|rollback|production|staging]"
        exit 1
        ;;
esac
