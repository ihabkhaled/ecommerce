//Install first time<br/>
composer install<br/>

//create db if not exists<br/>
php artisan dayra:createdb<br/>

//run migrations<br/>
php artisan migrate<br/>

//run seeder<br/>
php artisan db:seed --class=UsersSeeder<br/>

//Modify .env file<br/>
//modify mysql data with database name "ecommerce"<br/>
DB_CONNECTION=mysql<br/>
DB_HOST=127.0.0.1<br/>
DB_PORT=3306<br/>
DB_DATABASE=ecommerce<br/>
DB_USERNAME=root<br/>
DB_PASSWORD=<br/>

//run server<br/>
php artisan serve<br/>

php artisan key:generate<br/>
php artisan config:cache<br/>
php artisan config:clear<br/>

/////////////////////////////////////////////////////////////////////////<br/>

API instructions<br/>