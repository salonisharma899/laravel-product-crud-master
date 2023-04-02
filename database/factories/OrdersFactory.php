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
