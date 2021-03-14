<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(
            [
                [
                    'sub' => 'abcdefghijklmn',
                    'is_mentor' => 't',
                    'nickname' => 'yutanakno_jp',
                    'name' => 'Yuta Nakano',
                    'picture' => 'https://pbs.twimg.com/profile_images/1302942354848923650/BH4TDvNq_400x400.jpg',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
            ]
        );

        User::factory()
            ->times(10)
            ->create();
    }
}
