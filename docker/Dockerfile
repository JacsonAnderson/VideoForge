FROM php:8.2-apache

# Ativa o mod_rewrite (se necessário)
RUN a2enmod rewrite

# Instala a extensão PDO MySQL
RUN docker-php-ext-install pdo_mysql

# Copia os arquivos de templates e arquivos estáticos para o diretório do Apache
COPY app/templates/ /var/www/html/
COPY app/static/ /var/www/html/static/

# Copia toda a pasta "app" para /var/www/app (para os scripts de migração e conexão)
COPY app/ /var/www/app/

# Define o diretório de trabalho para executar scripts PHP (por exemplo, a migração)
WORKDIR /var/www/app

EXPOSE 80
