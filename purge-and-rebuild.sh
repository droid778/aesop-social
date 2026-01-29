#!/bin/bash
set -e

echo "Stopping all services..."
docker-compose down

echo "Removing any leftover Friendica config files..."
docker-compose exec -T aesop-social rm -f /var/www/html/config/local.config.php || true
docker-compose exec -T aesop-social rm -f /var/www/html/.htaccess || true

echo "Removing old database and data volumes..."
docker volume rm aesop-social_aesop_social_db || true
docker volume rm aesop-social_aesop_social_data || true

echo "Removing old images..."
docker-compose rm -f

echo "Building with no cache..."
docker-compose build --no-cache

echo "Starting services..."
docker-compose up -d

echo "Waiting for services to stabilize..."
sleep 5

echo "Clean rebuild complete! Tailing logs (Ctrl+C to exit)..."
docker-compose logs -f aesop-social
