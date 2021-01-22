<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('skills')->insert(
            [
                [
                    'id' => 1,
                    'skill_name' => 'html/css',
                    'skill_type' => 1
                ],

                [
                    'id' => 2,
                    'skill_name' => 'Illustrator',
                    'skill_type' => 3
                ],

                [
                    'id' => 3,
                    'skill_name' => 'PhotoShop',
                    'skill_type' => 3
                ],

                [
                    'id' => 4,
                    'skill_name' => 'InDesign',
                    'skill_type' => 3
                ],

                [
                    'id' => 5,
                    'skill_name' => 'Excel',
                    'skill_type' => 3
                ],

                [
                    'id' => 6,
                    'skill_name' => 'Word',
                    'skill_type' => 3
                ],

                [
                    'id' => 7,
                    'skill_name' => 'CentOS',
                    'skill_type' => 2
                ],

                [
                    'id' => 8,
                    'skill_name' => 'windows',
                    'skill_type' => 2
                ]
            ]
        );
    }
}
