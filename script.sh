#!/bin/bash

source .env

docker exec -w /var/www/html laravel_api_mv chown -R www-data:tecnologia .

docker exec -w /var/www/html  laravel_api_mv sed -i "s/ServerName \${VIRTUALHOST}/ServerName ${VIRTUALHOST}/" /etc/apache2/sites-available/virtualhost.conf

docker exec -w /var/www/html laravel_api_mv composer install -vvv

docker exec -w /var/www/html laravel_api_mv php artisan --version

docker exec -w /var/www/html  laravel_api_mv cp .env.example .env

docker exec -w /var/www/html  laravel_api_mv sed -i "s/APP_URL=http:\/\/localhost/APP_URL=http:\/\/$VIRTUALHOST/" .env

docker exec -w /var/www/html  laravel_api_mv sed -i "s/DB_CONNECTION=mysql/DB_CONNECTION=pgsql/" .env

docker exec -w /var/www/html  laravel_api_mv sed -i "s/DB_HOST=127.0.0.1/DB_HOST=postgresql_mv/" .env

docker exec -w /var/www/html  laravel_api_mv sed -i "s/DB_PORT=3306/DB_PORT=$POSTGRES_PORT/" .env

docker exec -w /var/www/html  laravel_api_mv sed -i "s/DB_DATABASE=laravel/DB_DATABASE=$POSTGRES_DB/" .env

docker exec -w /var/www/html  laravel_api_mv sed -i "s/DB_USERNAME=root/DB_USERNAME=$POSTGRES_USER/" .env

docker exec -w /var/www/html  laravel_api_mv sed -i "s/DB_PASSWORD=/DB_PASSWORD=$POSTGRES_PASSWORD/" .env

docker exec -w /var/www/html laravel_api_mv php artisan key:generate

docker exec -w /var/www/html laravel_api_mv rm -rf node_modules package-lock.json

docker exec -w /var/www/html laravel_api_mv npm install

docker exec -w /var/www/html laravel_api_mv php artisan migrate:fresh --seed

docker exec -w /var/www/html laravel_api_mv chmod 777 -R storage

docker exec -w /var/www/html laravel_api_mv php artisan storage:link

docker exec -w /var/www/html laravel_api_mv php artisan optimize

docker exec -w /var/www/html laravel_api_mv npm run dev

IP_ADDRESS=$(docker inspect --format='{{.NetworkSettings.Networks.net_web.IPAddress}}' laravel_api_mv)
echo
echo
echo "Script execution completed successfully!!!"
echo
echo "Please, add the following line to your /etc/hosts file:"
echo
echo "$IP_ADDRESS    $VIRTUALHOST"
echo
echo
echo "Finally, from your browser, visit the URL:" 
echo
echo "http://$VIRTUALHOST"
