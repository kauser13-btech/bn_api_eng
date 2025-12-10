https://abnpibnen.bgwebserver.com/ewmgl/login
https://abnpibnen.bgwebserver.com/api


-- after year unisharp/laravel-filemanager upload folder location change
-- if folder_location is empty ( goTo({edition}/year/month/date/{{crc32(user_id)}}) )
-- if folder_location is not empty goTo("/shares/{{Auth::user()->folder_location}}");
-- UniSharp/laravel-filemanager Directory Location
-- Public resources/views/vendor/laravel-filemanager/index.blade.php



----------Need TO run---------------

ImageStoreHelpers showImage default image change kora lagbe

-- news table status check


<!-- admin server -->
ssh bn24usr@103.16.72.106
B@n3$@$01&
cd /var/www/html/bn_api_eng_admin
git pull
exit

-- generate home api cache
cd scripts/
php instantcache.php

sudo php artisan telescope:clear
rm -f storage/framework/sessions/*

php artisan cache:clear
php artisan optimize:clear
exit

tail -f /var/log/instantsync.log

-- Queue server
sudo supervisorctl stop laravel-worker:*
sudo supervisorctl start laravel-worker:*

-- database
https://bnadbnminen.bgwebserver.com/dbssssssssss/?server=
root
b!a%M&52?aH


-- database lgoin
ssh bn24usr@103.16.72.103
B@n3$@$01&
mysql -u'nodeuser' -p'b!a%M&52?aH' -h'192.168.72.105'
use bn_eng;

-- create archive table
CREATE TABLE `news_2024` LIKE `news`; 
INSERT INTO `news_2024` SELECT * FROM `news` WHERE n_date BETWEEN '2024-01-01' AND '2024-12-31';
-- DELETE main table row
DELETE FROM `news` WHERE n_date BETWEEN '2024-01-01' AND '2024-12-31';



-- web 1 api account
ssh bn24usr@103.16.72.106
B@n3$@$01&

cd /var/www/html/bn_api_eng
git pull
exit


-- web 1 front Server
ssh bn24usr@103.16.72.106
B@n3$@$01&

cd /var/www/html/bnfront_eng
git pull
rm -rf .next
npm run build
pm2 stop server.sh
pm2 flush
pm2 start server.sh
exit


<!-- nginx --
sudo systemctl stop nginx
sudo systemctl start nginx
sudo service php8.1-fpm stop
sudo service php8.1-fpm start

composer audit
composer update --with-all-dependencies

npm outdated
npm update --save
-- Malware Scan
npm audit
npm audit fix
npx fix-react2shell-next
npx @nodesecure/cli scan
npx depcheck
npx eslint .
grep -R "eval(" -n .
grep -R "child_process" -n .
grep -R "exec(" -n .
