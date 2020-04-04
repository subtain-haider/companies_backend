<?php

use Illuminate\Database\Seeder;
use LaravelEnso\Companies\App\Models\Company;



class CompanySeeder extends Seeder
{

    public function run()
    {

        factory(Company::class)->create(
            ['code' => 'OX1', 'name' => 'D Ground Boys Campus', 'email' => 'ox1@oxley.com', 'phone' => '01111111'],
            )->people()->create(
            ['title' => 1, 'name' => 'Campus Head OX1', 'appellative' => 'Ahsan', 'email' => 'ox1ch@oxley.com', 'phone' => '0311111111'],
            );

        factory(Company::class)->create(
            ['code' => 'OX2', 'name' => 'D Ground Girls Campus', 'email' => 'ox2@oxley.com', 'phone' => '02222222'],
            )->people()->create(
            ['title' => 1, 'name' => 'Campus Head OX2', 'appellative' => 'Qasim', 'email' => 'ox2ch@oxley.com', 'phone' => '0322222222'],
            );

        factory(Company::class)->create(
            ['code' => 'OX3', 'name' => 'Academy Campus', 'email' => 'ox3@oxley.com', 'phone' => '033333333'],
            )->people()->create(
            ['title' => 3, 'name' => 'Campus Head OX3', 'appellative' => 'Sana', 'email' => 'ox3ch@oxley.com', 'phone' => '03444444444'],
            );



    }
}
