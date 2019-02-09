<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Customer::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'website' => $faker->url,
        'private_notes' => $faker->text(200),
        'balance' => $faker->numberBetween(0,1000),
        'paid_to_date' => $faker->numberBetween(0,10000),
        'vat_number' => $faker->text(25),
        'id_number' => $faker->text(20),
        'custom_value1' => $faker->text(20),
        'custom_value2' => $faker->text(20),
        'payment_terms' => $faker->text(40),
        'address1' => $faker->buildingNumber,
        'address2' => $faker->streetAddress,
        'city' => $faker->city,
        'state' => $faker->state,
        'postal_code' => $faker->postcode,
        'country_id' => 4,
        'shipping_address1' => $faker->buildingNumber,
        'shipping_address2' => $faker->streetAddress,
        'shipping_city' => $faker->city,
        'shipping_state' => $faker->state,
        'shipping_postal_code' => $faker->postcode,
        'shipping_country_id' => 4,
    ];
});
