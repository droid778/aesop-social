#!/bin/bash
set -e

echo "Stopping all services..."
docker-compose down

echo "Removing old images..."
docker-compose rm -f

echo "Building with no cache..."
docker-compose build --no-cache

echo "Starting services..."
docker-compose up -d

echo "Tailing logs (Ctrl+C to exit)..."
docker-compose logs -f aesop-social
