#!/bin/bash

# Wait for database to be ready
echo "Waiting for database (Host: ${FRIENDICA_DB_HOST}, User: ${FRIENDICA_DB_USER}, DB: ${FRIENDICA_DB_NAME})..."
for i in {1..30}; do
    if mysql -h"${FRIENDICA_DB_HOST}" -u"${FRIENDICA_DB_USER}" -p"${FRIENDICA_DB_PASSWORD}" -e "SELECT 1" >/dev/null 2>&1; then
        echo "Database is ready!"
        break
    fi
    if [ $i -eq 30 ]; then
        echo "WARNING: Database connection timeout, continuing anyway..."
        break
    fi
    sleep 2
done

# Check if already installed
if [ ! -f /var/www/html/config/local.config.php ]; then
    echo "Running Friendica auto-installer..."
    cd /var/www/html
    
    php bin/console.php autoinstall \
        -U https://aesop-social.uk \
        -H "${FRIENDICA_DB_HOST}" \
        -d "${FRIENDICA_DB_NAME}" \
        -u "${FRIENDICA_DB_USER}" \
        -p "${FRIENDICA_DB_PASSWORD}" \
        -A "${FRIENDICA_ADMIN_EMAIL}" \
        -t UTC || echo "WARNING: Installer encountered errors, but continuing..."
    
    echo "Friendica installer finished!"
else
    echo "Friendica already installed, skipping auto-install."
fi
