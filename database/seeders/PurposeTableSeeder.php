<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurposeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('purposes')->insert(
            [
                [
                    'id' => 1,
                    'purpose_name' => '1on1希望'
                ],

                [
                    'id' => 2,
                    'purpose_name' => 'チーム開発希望'
                ]
            ]
        );
    }
}
