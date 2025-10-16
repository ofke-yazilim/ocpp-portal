FROM rockylinux:8
# -------------------------------------------------
# Fix CentOS 8 mirror issues (vault.centos.org)
# -------------------------------------------------
RUN sed -i 's|mirror.centos.org|vault.centos.org|g' /etc/yum.repos.d/*.repo && \
    sed -i 's|^#baseurl=http|baseurl=http|g' /etc/yum.repos.d/*.repo && \
    sed -i 's|^mirrorlist=|#mirrorlist=|g' /etc/yum.repos.d/*.repo

# Locale ve temel araçlar
RUN dnf install -y epel-release dnf-utils curl nano git unzip tar

# -------------------------------------------------
# PHP 8.3 ve uzantılar (Remi repo üzerinden)
# -------------------------------------------------
RUN dnf install -y https://rpms.remirepo.net/enterprise/remi-release-8.rpm && \
    dnf module reset php -y && \
    dnf module enable php:remi-8.3 -y && \
    dnf install -y php-fpm \
                php-bcmath \
                php-gd \
                php-intl \
                php-json \
                php-ldap  \
                php-mbstring \
                php-mcrypt \
                php-opcache \
                php-pdo \
                #php-pecl-mongo \
                php-pecl-mongodb \
                php-pear  \
                php-pecl-apcu \
                php-pecl-imagick \
                php-pecl-redis \
                php-pecl-xdebug  \
                php-pgsql \
                php-mysqlnd \
                php-soap \
                php-tidy \
                php-xml \
                php-pecl-zip \
                php-xmlrpc && \
                dnf clean all

# -------------------------------------------------
# Nginx kurulumu
# -------------------------------------------------
RUN dnf install -y nginx

RUN mkdir -p /run/php-fpm && \
    chown nginx:nginx /run/php-fpm

RUN mkdir -p /var/lib/php/session && \
    chown nginx:nginx /var/lib/php/session

# PHP-FPM ayarlarını nginx kullanıcı/grubu ile eşle
RUN sed -i 's|^user = apache|user = nginx|' /etc/php-fpm.d/www.conf && \
    sed -i 's|^group = apache|group = nginx|' /etc/php-fpm.d/www.conf && \
    sed -i 's|^listen = 127.0.0.1:9000|listen = /run/php-fpm/www.sock|' /etc/php-fpm.d/www.conf && \
    sed -i 's|^;listen.owner = nobody|listen.owner = nginx|' /etc/php-fpm.d/www.conf && \
    sed -i 's|^;listen.group = nobody|listen.group = nginx|' /etc/php-fpm.d/www.conf && \
    sed -i 's|^;listen.mode = 0660|listen.mode = 0660|' /etc/php-fpm.d/www.conf

RUN dnf -y install gcc-c++ make python3 git
RUN dnf install -y bash curl
# -------------------------------------------------
# Node.js 20 (statik binary)
# -------------------------------------------------
RUN curl -fsSL https://rpm.nodesource.com/setup_24.x | bash - && \
    dnf install -y nodejs
# -------------------------------------------------
# Composer and cronie Install
# -------------------------------------------------
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
RUN dnf -y install cronie && dnf clean all

RUN rm -rf /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Istanbul /etc/localtime

# -------------------------------------------------
# Laravel veya proje dizini için nginx ayarları
# -------------------------------------------------
COPY ./configs/nginx/conf.d /etc/nginx/conf.d/
COPY ./configs/nginx/nginx.conf /etc/nginx/nginx.conf

# Projeyi kopyala (bu satırı kendi projen için özelleştir)
WORKDIR /data/www
COPY ./ocpp /data/www/
#RUN npm install && npm run build

# Put nginx config for Laravel
COPY configs/ssl/ssl.crt /etc/ssl/ssl.crt
COPY configs/ssl/ssl.key /etc/ssl/ssl.key

# Laravel permissions fix (isteğe bağlı)
RUN mkdir -p /data/www/storage /data/www/bootstrap/cache && \
    chown -R nginx:nginx /data/www && \
    chmod -R 775 storage /data/www/bootstrap/cache

# -------------------------------------------------
# Servisleri başlatmak için script
# -------------------------------------------------
COPY ./configs/recompile.sh /recompile.sh
RUN chmod +x /recompile.sh

EXPOSE 80
EXPOSE 8080
EXPOSE 8000
EXPOSE 6001
EXPOSE 443
CMD sh /recompile.sh; /usr/sbin/nginx -c /etc/nginx/nginx.conf; /usr/sbin/php-fpm --nodaemonize
