<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Advert;
use Faker\Generator as Faker;

$factory->define(Advert::class, function (Faker $faker) {
    return [
        'price_usd' => 1000,
        'price_uah' => 27000,
        'price_per_ms_usd' => 10,
        'price_per_ms_uah' => 270,
        'rooms' => 3,
        'floor' => 2,
        'storeys' => 5,
        'user_id' => 1,
        'street' => 'First',
        'building' => '25/7',
        'city' => 'Kiev',
        'district' => 'Bad',
        'microdistrict' => 'Even worse',
        'total_area' => 100,
        'living_area' => 45,
        'kitchen_area' => 15,
        'has_repair' => 1,
        'construction_type' => 'Poor',
        'construction_year' => 1995,
        'building_type' => 'shits',
        'wall_material' => 'Shit',
        'title' => 'The best thing you could find',
        'description' => 'Why is it even there?',
        'apartment_number' => '25/7',
        'entrance' => 1,
        'notes' => 'Nothing is here yet'
    ];
});
