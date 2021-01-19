<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SkillTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('skills')->insert([
            [
                'id' => 1,
                'skill_name' => 'html/css'],
            [
                'id' => 2,
                'skill_name' => 'Illustrator'],
            [
                'id' => 3,
                'skill_name' => 'PhotoShop'],
            [
                'id' => 4,
                'skill_name' => 'InDesign'],
            [
                'id' => 5,
                'skill_name' => 'Excel'],
            [
                'id' => 6,
                'skill_name' => 'Word']
        ]);

    }
}
