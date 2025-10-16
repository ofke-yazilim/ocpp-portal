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

nohup /usr/bin/php /data/www/server/ocpp-server.php > /data/www/server/ocpp.log 2>&1 &

cd /data/www
rm -R node_modules
rm package-lock.json
composer require tightenco/ziggy #route süreçleri için kuruluyor.
npm install -g npm@latest
npm install
npm install ziggy-js #route süreçleri için kuruluyor.
npm install --save-dev @types/ziggy-js #route süreçleri için kuruluyor.
#npm install -D tailwindcss @tailwindcss/vite
npm run build

# MobileConnect
echo '# MobileConnect' >> /etc/hosts

# Run Laravel Command
/usr/bin/php /data/www/artisan cache:clear
/usr/bin/php /data/www/artisan config:clear
/usr/bin/php /data/www/artisan view:clear
/usr/bin/php /data/www/artisan route:clear
/usr/bin/php /data/www/artisan ziggy:generate


