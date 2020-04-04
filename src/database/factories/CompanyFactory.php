<?php

use Faker\Generator as Faker;
use LaravelEnso\Companies\App\Enums\CompanyStatuses;
use LaravelEnso\Companies\App\Models\Company;
use LaravelEnso\People\App\Models\Person;


$factory->define(Company::class, fn (Faker $faker) => [
    'code' => $faker->unique()->countryCode,
    'name' => $faker->unique()->company,
    'email' => $faker->email,
    'phone' => $faker->phoneNumber,
    'is_tenant' => true,
    'status' => CompanyStatuses::Active,
]);
//$factory->afterCreating(Company::class, function ($company) {
//    $company->people()->save(factory(Person::class, 30)->make());
//});
