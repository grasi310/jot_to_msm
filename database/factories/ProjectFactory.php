<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
use Faker\Generator as Faker;
use App\User;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'name' => $faker->name,
        'company' => $faker->company,
        'location' => $faker->paragraph,
        'description' => $faker->paragraph,
    ];
});
