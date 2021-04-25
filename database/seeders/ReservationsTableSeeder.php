<?php

declare(strict_types=1);

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reservations')->insert([
            [
                'mentee_id' => 2,
                'mentor_id' => 1,
                'date' => new Carbon('2021-04-20'),
                'time' => '14:00:00',
                'status' => 1,
            ],
            [
                'mentee_id' => 3,
                'mentor_id' => 1,
                'date' => new Carbon('2021-04-21'),
                'time' => '14:00:00',
                'status' => 1,
            ],
            [
                'mentee_id' => 4,
                'mentor_id' => 1,
                'date' => new Carbon('2021-04-21'),
                'time' => '15:00:00',
                'status' => 1,
            ],
        ]);
    }
}
