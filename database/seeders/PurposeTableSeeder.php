<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PurposeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('purposes')->insert([
            [
                'id' => 1,
                'purpose' =>'1on1希望'
            ],

            [
                'id' =>2,
                'purpose' =>'チーム開発希望'
            ]
        ]);
    }
}
