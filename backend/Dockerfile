FROM php:8.2-apache

# Обновление и установка зависимостей в одном слое
RUN apt-get update && apt-get upgrade -y && \
    apt-get install -y \
    libzip-dev \
    zip \
    curl && \
    rm -rf /var/lib/apt/lists/*  # Очистка кэша apt для уменьшения размера образа

# Включение mod_rewrite
RUN a2enmod rewrite

# Установка PHP расширений
RUN docker-php-ext-install pdo_mysql zip

# Установка документа корня Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Изменение конфигурации Apache для использования нового корня
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Копирование исходного кода приложения
COPY . /var/www/html

# Установка рабочей директории
WORKDIR /var/www/html

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Установка зависимостей проекта
RUN composer install --no-dev --optimize-autoloader

# Установка правильных прав на каталоги хранения
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Открытие порта 80
EXPOSE 80