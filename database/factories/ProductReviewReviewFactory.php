<?php

use Faker\Generator as Faker;
use App\Product\Product;

$factory->define(App\Product\Review\Review::class, function (Faker $faker) {
    return [
        'product_id'=>function(){
            return Product::all()->random();
        },
        'customer' => $faker->name,
        'review'=>$faker->paragraph,
        'star'=>$faker->numberBetween(0,5),
    ];
});
