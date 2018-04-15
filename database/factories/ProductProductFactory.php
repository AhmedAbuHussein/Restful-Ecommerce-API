<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(App\Product\Product::class, function (Faker $faker) {
    return [
        'name'=>$faker->word,
        'detail'=>$faker->paragraph,
        'stock'=>$faker->randomDigit,
        'price'=>$faker->numberBetween(100,1000),
        'discount'=>$faker->numberBetween(5,30),
        'user_id'=>function(){
            return User::all()->random();
        },
        'img'=>$faker->word,
    ];
});
