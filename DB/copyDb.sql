https://bnadbnmin.bgwebserver.com/ewmgl/login
https://abnpibn.bgwebserver.com/api


-- after year unisharp/laravel-filemanager upload folder location change
-- if folder_location is empty ( goTo({edition}/year/month/date/{{crc32(user_id)}}) )
-- if folder_location is not empty goTo("/shares/{{Auth::user()->folder_location}}");
-- UniSharp/laravel-filemanager Directory Location
-- Public resources/views/vendor/laravel-filemanager/index.blade.php



----------Need TO run---------------

ImageStoreHelpers showImage default image change kora lagbe

-- news table status check
UPDATE `news` SET `n_status` = '3' WHERE `n_status` = 2;
ALTER TABLE `galleries` ADD `slide_video` tinyint NULL DEFAULT '0' AFTER `special_video`;


<!-- admin server -->
ssh bn24usr@103.16.72.103
B@n3$@$01&
cd /var/www/bnapi
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
https://bnadbnmin.bgwebserver.com/dbssssssss/?server=192.168.72.105&username=nodeuser&db=bn_prod
User: nodeuser
Host: 192.168.72.105
Password: 6e+PH*G2nG4


-- database lgoin
ssh bn24usr@103.16.72.103
B@n3$@$01&
mysql -u'nodeuser' -p'6e+PH*G2nG4' -h'192.168.72.105'
use bn_prod;

-- create archive table
CREATE TABLE `news_2024` LIKE `news`; 
INSERT INTO `news_2024` SELECT * FROM `news` WHERE n_date BETWEEN '2024-01-01' AND '2024-12-31';
-- DELETE main table row
DELETE FROM `news` WHERE n_date BETWEEN '2024-01-01' AND '2024-12-31';



-- web 1 api account
ssh bn24usr@103.16.72.104 
B@n3$@$01&

cd /var/www/bnapi
git pull
exit


-- web 1 front Server
ssh bn24usr@103.16.74.34
-- web 2 front Server
ssh bn24usr@103.16.74.35

B@n3$@$01&

cd /home/bn24usr/bnfront
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