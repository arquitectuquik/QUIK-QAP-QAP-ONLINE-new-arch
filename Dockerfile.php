FROM php:5.6-apache

# Configurar repos archivados para Debian Stretch
RUN sed -i 's/http:\/\/deb.debian.org\/debian/http:\/\/archive.debian.org\/debian/g' /etc/apt/sources.list && \
    sed -i 's/http:\/\/security.debian.org\/debian-security/http:\/\/archive.debian.org\/debian-security/g' /etc/apt/sources.list && \
    sed -i '/stretch-updates/d' /etc/apt/sources.list && \
    echo 'Acquire::Check-Valid-Until "false";' > /etc/apt/apt.conf.d/10no-check-valid-until

# Instalar dependencias del sistema
RUN apt-get -o Acquire::Check-Valid-Until=false update --allow-unauthenticated && \
    apt-get install -y --allow-unauthenticated \
    libmcrypt-dev \
    libpng-dev \
    unzip \
    libbz2-dev \
    libcurl4-openssl-dev \
    libxml2-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libgmp-dev \
    libicu-dev \
    libc-client-dev \
    libkrb5-dev \
    libldap2-dev \
    libpq-dev \
    unixodbc-dev \
    libaspell-dev \
    libreadline-dev \
    libtidy-dev \
    libxslt-dev \
    zlib1g-dev \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP
RUN docker-php-ext-install \
    bcmath
RUN docker-php-ext-install bz2 
RUN docker-php-ext-install calendar 
RUN docker-php-ext-install curl 
RUN docker-php-ext-install dba 
RUN docker-php-ext-install dom 
#RUN docker-php-ext-install enchant 
RUN docker-php-ext-install exif 
RUN docker-php-ext-install fileinfo 
RUN docker-php-ext-install ftp 
RUN docker-php-ext-install gd 
RUN docker-php-ext-install gettext 
#RUN docker-php-ext-install gmp 
RUN docker-php-ext-install iconv 
#RUN docker-php-ext-install imap 
RUN docker-php-ext-install intl 
RUN docker-php-ext-install json 
#RUN docker-php-ext-install ldap 
RUN docker-php-ext-install mbstring 
RUN docker-php-ext-install mcrypt 
RUN docker-php-ext-install mysqli 
RUN docker-php-ext-install mysql 
#RUN docker-php-ext-install odbc 
RUN docker-php-ext-install pdo_mysql 
RUN docker-php-ext-install pdo_pgsql 
#RUN docker-php-ext-install pdo_sqlite 
RUN docker-php-ext-install pgsql 
RUN docker-php-ext-install posix 
#RUN docker-php-ext-install pspell 
#RUN docker-php-ext-install readline 
RUN docker-php-ext-install shmop 
RUN docker-php-ext-install simplexml 
#RUN docker-php-ext-install snmp 
RUN docker-php-ext-install soap 
RUN docker-php-ext-install sockets 
#RUN docker-php-ext-install sqlite3 
RUN docker-php-ext-install sysvmsg 
RUN docker-php-ext-install tidy 
RUN docker-php-ext-install tokenizer 
RUN docker-php-ext-install xmlreader 
RUN docker-php-ext-install xmlrpc 
RUN docker-php-ext-install xmlwriter 
RUN docker-php-ext-install  xsl
RUN docker-php-ext-install zip
RUN docker-php-ext-install xml



# Habilitar mod_rewrite
RUN a2enmod rewrite

# DIRECTORYINDEX - MODIFICAR ARCHIVO PRINCIPAL DE APACHE
RUN sed -i 's/DirectoryIndex index.html/DirectoryIndex login.php index_u.php index.php index.html/' /etc/apache2/mods-enabled/dir.conf

# CONFIGURAR APACHE PARA PROCESAR PHP CORRECTAMENTE
RUN echo "AddType application/x-httpd-php .php" >> /etc/apache2/apache2.conf && \
    echo "<FilesMatch \.php$>" >> /etc/apache2/apache2.conf && \
    echo "    SetHandler application/x-httpd-php" >> /etc/apache2/apache2.conf && \
    echo "</FilesMatch>" >> /etc/apache2/apache2.conf

# HABILITAR ALLOWOVERRIDE PARA .HTACCESS
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# CARGAR AUTOMÁTICAMENTE EL ARCHIVO DE COMPATIBILIDAD MYSQL
RUN echo "auto_prepend_file = /usr/local/lib/php/mysql_compatibility.php" >> /usr/local/etc/php/conf.d/mysql-compat.ini

# Configurar php.ini
COPY php.ini /usr/local/etc/php/conf.d/custom.ini

# Archivo de compatibilidad MySQL
COPY mysql_compatibility.php /usr/local/lib/php/mysql_compatibility.php

# Evitar warning de Apache sobre ServerName
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Zona horaria
ENV TZ=America/Bogota
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]