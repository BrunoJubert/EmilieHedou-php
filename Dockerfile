# Dockerfile
FROM php:8.1-apache

# Activer les modules Apache nécessaires
RUN a2enmod rewrite ssl

# Installer l'extension mysqli
RUN docker-php-ext-install mysqli

# Copier la configuration Apache personnalisée (ssl.conf)
COPY apache-config/ssl.conf /etc/apache2/sites-available/ssl.conf

# Activer le site SSL
RUN a2ensite ssl.conf

# Ajouter ServerName global pour éviter warning Apache
RUN echo "ServerName emiliehedou.fr" >> /etc/apache2/apache2.conf

WORKDIR /var/www/html

EXPOSE 80 443

CMD ["apache2-foreground"]
