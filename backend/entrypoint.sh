#!/bin/bash

# Generar .env si no existe
if [ ! -f .env ]; then
  echo "Generando .env personalizado..."
  cat <<EOF > .env
APP_NAME=MantekManager
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=mantek
DB_USERNAME=root
DB_PASSWORD=root

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
EOF
fi

# Instalar dependencias si no existe la carpeta vendor
if [ ! -d "vendor" ]; then
  echo "Instalando dependencias con Composer..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Esperar a que MySQL esté disponible (sin depender de Laravel)
echo "Esperando a que MySQL esté disponible..."
until mysqladmin ping -h"$DB_HOST" --silent; do
  echo "MySQL aún no está disponible..."
  sleep 2
done

echo "MySQL está disponible. Continuando..."

# Generar clave si no existe
if ! grep -q "APP_KEY=base64" .env; then
  php artisan key:generate
fi

# Cachear configuración y correr migraciones con seed
php artisan config:cache
php artisan migrate --seed --force

# Iniciar servidor Laravel
php artisan serve --host=0.0.0.0 --port=8000
