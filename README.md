"# product_demo" 

------------------------------------------------------------------------
Creating Auth Module in Laravel 7.X
------------------------------------------------------------------------
php artisan ui vue --auth
after running the above command run the following command
npm install
npm run dev
------------------------------------------------------------------------
Create an app passsword using following link
------------------------------------------------------------------------
https://security.google.com/settings/security/apppasswords
------------------------------------------------------------------------
and then enter the app email and password in .env file
------------------------------------------------------------------------
MAIL_DRIVER=sendmail
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=XXXXXXXXXX@gmail.com
MAIL_PASSWORD=XXXXXXXXXX
MAIL_ENCRYPTION=tls

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=demo.pre.telecom@gmail.com
MAIL_PASSWORD=uxhadivsoyjxkwew
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=demo.pre.telecom@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

------------------------------------------------------------------------
Databse Migrations
------------------------------------------------------------------------
php artisan make:migration create_categories_table
php artisan make:migration create_products_table
php artisan make:migration create_orders_table
php artisan make:migration create_cart_table
php artisan make:migration add_soft_deletes_to_cart
------------------------------------------------------------------------
Use following library in the Model for implementing softdelete
------------------------------------------------------------------------
Following should be the content of a model
------------------------------------------------------------------------
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Categories;
use App\Models\Products;
use Illuminate\Database\Eloquent\SoftDeletes;


class Orders extends Model
{
    use SoftDeletes;
    //
    protected $table = "orders";

    protected $fillable = [
        'id',
        'order_date',
        'category_id',
        'product_id',
        'ordered_by',
        'created_at',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'ordered_by','id');
    }
    public function category()
    {
        return $this->belongsTo(Categories::class,'category_id','id');
    }
    public function product()
    {
        return $this->belongsTo(Products::class,'product_id','id');
    }
}

?>

-----------------------------------------------------------------------
use Illuminate\Database\Eloquent\SoftDeletes;
------------------------------------------------------------------------
Commands Used to Create Models
------------------------------------------------------------------------
php artisan make:model Models\Products
php artisan make:model Models\Categories
php artisan make:model Models\Orders
php artisan make:model Models\Cart
------------------------------------------------------------------------
Commands Used to Create Controllers (WEB)
------------------------------------------------------------------------
php artisan make:controller UserController --resource
php artisan make:controller CategoryController --resource
php artisan make:controller ProductController --resource
php artisan make:controller OrderController --resource
php artisan make:controller CartController --resource

php artisan make:controller GuestUserController
------------------------------------------------------------------------
Commands Used to Create Controllers (API)
------------------------------------------------------------------------
php artisan make:controller API\UserController --resource
php artisan make:controller API\CategoryController --resource
php artisan make:controller API\ProductController --resource
php artisan make:controller API\OrderController --resource
php artisan make:controller API\CartController --resource

php artisan make:request RegisterAuthRequest
------------------------------------------------------------------------
Commands to create Notifications
------------------------------------------------------------------------
php artisan make:notification OrderNotifications\OrderPlaced
php artisan make:notification OrderNotifications\OrderUpdated
php artisan make:notification OrderNotifications\OrderCancelled
------------------------------------------------------------------------
Creating Factory Data for orders table
------------------------------------------------------------------------
php artisan make:factory OrdersFactory --model=App/Models/Orders
------------------------------------------------------------------------
Add the following code into OrdersFactory.php
------------------------------------------------------------------------

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Orders;
use Faker\Generator as Faker;

$factory->define(Orders::class, function (Faker $faker) {
    return [
        //
        'order_date' => now(),
        'category_id' => 2,
        'product_id' => 2,
        'ordered_by' => 1,
        'created_at' => now(),
    ];
});
?>

------------------------------------------------------------------------
Execute the following command to create 150 records in orders table.
------------------------------------------------------------------------
factory(App\Models\Orders::class, 150)->create();
------------------------------------------------------------------------
Creating new middleware
------------------------------------------------------------------------
php artisan make:middleware admin
------------------------------------------------------------------------
To Start Laravel Server
------------------------------------------------------------------------
php artisan cache:clear && php artisan view:cache && php artisan config:cache && php artisan route:cache && php artisan serve --port=8000
------------------------------------------------------------------------


