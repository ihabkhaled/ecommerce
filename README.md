//Modify .env file<br/>
//modify mysql data with database name "ecommerce"<br/>
DB_CONNECTION=mysql<br/>
DB_HOST=127.0.0.1<br/>
DB_PORT=3306<br/>
DB_DATABASE=ecommerce<br/>
DB_USERNAME=root<br/>
DB_PASSWORD=<br/>

//Install first time<br/>
composer install<br/>

//create db<br/>
php artisan ecommerce:createdb<br/>

//run migrations<br/>
php artisan migrate<br/>

//run seeder<br/>
php artisan db:seed --class=UsersSeeder<br/>
php artisan db:seed --class=StoresSeeder<br/>
php artisan db:seed --class=ProductsSeeder<br/>
php artisan db:seed --class=CartsSeeder<br/>

php artisan key:generate<br/>
php artisan config:cache<br/>
php artisan config:clear<br/>

//run server<br/>
php artisan serve<br/>

/////////////////////////////////////////////////////////////////////////<br>

API instructions<br/>

*You need to loging to generate the JWT Token* <br/>
Include JWT in the Header<br/>
Authorization: bearer *token*<br/>

Login for merchant: <br/>
http://127.0.0.1:8000/api/auth/login<br/>
Method: POST<br>
{
    "email": "xxxxxxx",
    "password": "xxxxxxx"
}

Register for merchant: (Store automatically registered with the merchant through this API) <br>
http://127.0.0.1:8000/api/auth/register<br/>
Method: POST<br>
{
    "email": "xxxxxxx",
    "password": "xxxxxxx",
    "password_confirmation": "xxxxxxx",
    "full_name": "xxxxxxx",
    "mobile": "xxxxxxx",
    "store_name": "xxxxxxx"
}

Users Adding: <br>
Endpoint: http://127.0.0.1:8000/user <br>
Method: POST<br>
{
    "email": "xxxxxxx",
    "password": "xxxxxxx",
    "full_name": "xxxxxxx",
    "mobile": "xxxxxxx"
}

Store Adding: <br>
Endpoint: http://127.0.0.1:8000/user <br>
Method: POST<br>
{
    "email": "xxxxxxx",
    "password": "xxxxxxx",
    "full_name": "xxxxxxx",
    "mobile": "xxxxxxx"
}

Login via web:<br>
Endpoint: http://127.0.0.1:8000/login <br>

Register via web:<br>
Endpoint: http://127.0.0.1:8000/register <br>

The following routes and methods are unprotected, to make sure guest can access them.<br>
Stores for guests<br>
Endpoint: http://127.0.0.1:8000/ <br>

Example of products of the store id 1:<br>
http://127.0.0.1:8000/store/1 <br>

Example of products of the store id 1:<br>
http://127.0.0.1:8000/store/1 <br>

Cart for guests<br>
Endpoint: http://127.0.0.1:8000/cart <br>
