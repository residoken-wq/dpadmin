cd /home/dpadmin
ls -n
cd /home
ls -n
cd public_html
cd /public_html
ls -n
cd /home/dpadmin/public_html
ls -n
php artisan migrate
composer require doctrine/dbal
php artisan migrate
php artisan tinker --execute="echo 'Max ID: ' . DB::table('migrations')->max('id'); echo PHP_EOL; echo 'Auto increment: '; print_r(DB::select(\"SHOW TABLE STATUS WHERE Name = 'migrations'\")[0]->Auto_increment ?? 'NULL');"
php artisan tinker
# Tìm file php.ini
php -i | grep "php.ini"
# Tìm và comment dòng imagick
# Mở file php.ini và tìm dòng: extension=imagick.so
# Sửa thành: ;extension=imagick.so
# Hoặc nếu có file riêng:
sudo rm /etc/php.d/imagick.ini  # hoặc comment trong file này
exit
cd /home/dpadmin/public_html
php artisan tinker
php artisan migrate
