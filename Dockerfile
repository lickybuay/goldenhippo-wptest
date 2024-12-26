FROM wordpress:6-php8.2-apache

# Install additional PHP extensions
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    nano \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip

# Install and enable APCu
RUN pecl install apcu && docker-php-ext-enable apcu
# Enable Apache modules
RUN a2enmod expires headers deflate rewrite
# Copy custom PHP configuration
COPY ./config/custom-php.ini /usr/local/etc/php/conf.d/custom-php.ini
# Copy and enable custom Apache configuration
COPY ./config/custom-apache.conf /etc/apache2/conf-available/custom-apache.conf
RUN a2enconf custom-apache

# Configure PHP to use OPcache
RUN { \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.interned_strings_buffer=8'; \
    echo 'opcache.max_accelerated_files=4000'; \
    echo 'opcache.revalidate_freq=60'; \
    echo 'opcache.fast_shutdown=1'; \
    echo 'opcache.enable_cli=1'; \
} > /usr/local/etc/php/conf.d/opcache-recommended.ini

# Configure PHP to use APCu
RUN { \
    echo 'extension=apcu.so'; \
    echo 'apc.enable_cli=1'; \
} > /usr/local/etc/php/conf.d/docker-php-ext-apcu.ini

# Clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/*