<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $this->call(CareerTableSeeder::class);
        $this->call(PurposeTableSeeder::class);
        $this->call(SkillTableSeeder::class);
        $this->call(UserTableSeeder::class);
    }
}
