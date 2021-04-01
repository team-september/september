<?php

namespace Database\Seeders;

use App\Models\Availability;
use App\Models\AvailableTime;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class AvailabilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 親の空き日を作成
        for($i = 0; $i <= 10; $i += 2) {
            $availability = Availability::firstOrNew([
                'mentor_id' => 1,
                'available_date' => Carbon::now()->addDay($i)->format('Y-m-d'),
            ]);
            $availability->save();
        }
        
        // 続いて子の時間帯をセット
        $availabilities = Availability::all();
        foreach($availabilities as $availability) {
            $times = AvailableTime::factory()
                ->count(3)
                ->state(new Sequence(['time' => '17:00'], ['time' => '19:00'],['time' => '21:00']))
                ->make(['availability_id' => $availability->id]);
            
            $times->map(function($time){
                AvailableTime::firstOrNew($time->toArray())->save();
            });
        }
    }
}
