FROM php:8.4-cli-trixie AS php-builder

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

RUN apt-get update && apt-get install -y --no-install-recommends \
    libxml2-dev \
    libcurl4-openssl-dev \
    libzip-dev \
    libonig-dev \
    git \
    && docker-php-ext-install \
    pdo_mysql \
    xml \
    curl \
    zip \
    bcmath \
    mbstring \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /app

COPY . .

RUN composer install --optimize-autoloader

FROM php:8.4-cli-trixie

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Instalar Node.js e npm
RUN apt-get update && apt-get install -y --no-install-recommends \
    libxml2-dev \
    libcurl4-openssl-dev \
    libzip-dev \
    libonig-dev \
    nodejs \
    npm \
    && docker-php-ext-install \
    pdo_mysql \
    xml \
    curl \
    zip \
    bcmath \
    mbstring \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /app

COPY --from=php-builder /app .

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0"]