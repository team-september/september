<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CareerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('careers')->insert(
            [
                [
                    'id' => 1,
                    'year' => '半年未満'
                ],

                [
                    'id' => 2,
                    'year' => '1年'
                ],

                [
                    'id' => 3,
                    'year' => '1年半'
                ],

                [
                    'id' => 4,
                    'year' => '2年'
                ],

                [
                    'id' => 5,
                    'year' => '3年'
                ],

                [
                    'id' => 6,
                    'year' => 'それ以上'
                ]
            ]
        );
    }
}
