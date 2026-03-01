https://abnpibnen.bgwebserver.com/ewmgl/login
https://abnpibnen.bgwebserver.com/api


-- after year unisharp/laravel-filemanager upload folder location change
-- if folder_location is empty ( goTo({edition}/year/month/date/{{crc32(user_id)}}) )
-- if folder_location is not empty goTo("/shares/{{Auth::user()->folder_location}}");
-- UniSharp/laravel-filemanager Directory Location
-- Public resources/views/vendor/laravel-filemanager/index.blade.php



----------Need TO run---------------




<!-- admin server -->
ssh -i bp-sig-public.pem ubuntu@18.136.60.22
cd /var/www/html/enadmin
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

tail -f /var/log/instantcache/instantcache_eng.log

-- Queue server
sudo supervisorctl stop enadmin-worker:*
sudo supervisorctl start enadmin-worker:*

-- database
https://bnadbnmin.bgwebserver.com/dbssssssss/?server=192.168.72.105&username=root&db=bn_prod
User: root
Host: 192.168.72.105
Password: cZY>>6*BBj>WZ?j]rcm4


-- database lgoin
ssh -i bp-sig-public.pem ubuntu@18.136.60.22
mysql -u'root' -p'cZY>>6*BBj>WZ?j]rcm4'
use bn_prod;

-- create archive table
CREATE TABLE `news_2024` LIKE `news`; 
INSERT INTO `news_2024` SELECT * FROM `news` WHERE n_date BETWEEN '2024-01-01' AND '2024-12-31';
-- DELETE main table row
DELETE FROM `news` WHERE n_date BETWEEN '2024-01-01' AND '2024-12-31';



-- web api account
ssh -i bp-sig-public.pem ubuntu@18.136.60.22
cd /var/www/html/bn_api_eng
git pull
exit


-- web front server
ssh -i bp-sig-public.pem ubuntu@18.136.60.22
cd key
-- web 1 front Server
ssh -i bp-sig-private.pem ubuntu@192.170.1.208
-- web 2 front account
ssh -i bp-sig-private.pem ubuntu@192.170.1.194


cd bnfront_eng
git pull
rm -rf .next
npm run build
pm2 stop server.sh --name "server_en"
pm2 flush
pm2 start server.sh --name "server_en"
exit


<!-- nginx --
sudo systemctl stop nginx
sudo systemctl start nginx
sudo service php8.1-fpm stop
sudo service php8.1-fpm start

composer audit
composer audit fix
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
