# 🔹 Usa la imagen oficial de PHP 8.2 con Apache
# Esto significa: "Empieza con PHP 8.2 y Apache preinstalado"
FROM php:8.2-apache

# 🔹 Instala extensiones de PHP que tu aplicación necesita
# mysqli: Para conectar con MySQL
# pdo y pdo_mysql: Para usar PDO con MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# 🔹 Copia TODO tu código PHP al contenedor
# . (directorio actual) → /var/www/html/ (en el contenedor)
COPY . /var/www/html/

# 🔹 Cambia el propietario de los archivos a www-data
# www-data es el usuario que usa Apache por defecto
RUN chown -R www-data:www-data /var/www/html

# 🔹 Habilita el módulo rewrite de Apache
# Necesario para URLs amigables
RUN a2enmod rewrite

# 🔹 Informa que el contenedor escucha en el puerto 80
# Esto es solo documentación, no abre el puerto
EXPOSE 8080

# 🔹 Verifica automáticamente si la aplicación está sana
# --interval=30s: Verifica cada 30 segundos
# --timeout=3s: Si no responde en 3 segundos, falla
# --start-period=5s: Espera 5 segundos al iniciar
# --retries=3: Reintenta 3 veces antes de marcar como no sana
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
  CMD curl -f http://localhost/ || exit 1

