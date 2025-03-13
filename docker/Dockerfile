FROM php:8.2-apache

# Ativa o mod_rewrite, se necessário
RUN a2enmod rewrite

# Copia os templates e arquivos estáticos para o diretório do Apache
COPY app/templates/ /var/www/html/
COPY app/static/ /var/www/html/static/

EXPOSE 80
