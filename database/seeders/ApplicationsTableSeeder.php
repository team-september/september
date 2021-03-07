<?php

declare(strict_types=1);

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dummyData = [
            [
                'mentee_id' => 2,
                'mentor_id' => 1,
                'status' => 2,
                'approved_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'mentee_id' => 3,
                'mentor_id' => 1,
                'status' => 3,
                'approved_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'mentee_id' => 4,
                'mentor_id' => 1,
                'status' => 4,
                'approved_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'mentee_id' => 5,
                'mentor_id' => 1,
                'status' => 1,
                'approved_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('applications')->insert($dummyData);
    }
}
