#!/bin/bash
set -e

# Wait for database to be ready
echo "Waiting for database..."
for i in {1..30}; do
    if mysql -h"$FRIENDICA_DB_HOST" -u"$FRIENDICA_DB_USER" -p"$FRIENDICA_DB_PASSWORD" -e "SELECT 1" >/dev/null 2>&1; then
        echo "Database is ready!"
        break
    fi
    if [ $i -eq 30 ]; then
        echo "ERROR: Database connection timeout after 60 seconds"
        exit 1
    fi
    sleep 2
done

# Check if already installed
if [ ! -f /var/www/html/config/local.config.php ]; then
    echo "Running Friendica auto-installer..."
    cd /var/www/html
    
    if php bin/console.php autoinstall \
        -U https://aesop-social.uk \
        -H "$FRIENDICA_DB_HOST" \
        -d "$FRIENDICA_DB_NAME" \
        -u "$FRIENDICA_DB_USER" \
        -p "$FRIENDICA_DB_PASSWORD" \
        -A "$FRIENDICA_ADMIN_EMAIL" \
        -t UTC; then
        echo "Friendica installed successfully!"
    else
        echo "ERROR: Friendica installation failed!"
        exit 1
    fi
else
    echo "Friendica already installed, skipping auto-install."
fi
