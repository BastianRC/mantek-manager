FROM php:8.2-cli

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    zip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    default-mysql-client \
    && docker-php-ext-install pdo_mysql zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www

# Copiar todos los archivos del proyecto
COPY . .

# Copiar y dar permisos al script de arranque
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
