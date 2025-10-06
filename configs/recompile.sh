#!/bin/bash
#set -e
#
## PHP-FPM başlat
#php-fpm -D
#
## Nginx başlat
#nginx -g "daemon off;"

# Crontab çalıştırılıyor
crond

cd /data/www
npm install -g npm@latest
npm install
npm run build

# MobileConnect
echo '# MobileConnect' >> /etc/hosts

# Run Laravel Command
/usr/bin/php /data/www/artisan cache:clear
/usr/bin/php /data/www/artisan config:clear
/usr/bin/php /data/www/artisan view:clear
/usr/bin/php /data/www/artisan route:clear


