<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Repositories\Availability\IAvailabilityRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AvailabilityApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed('UserTableSeeder');
        $this->seed('AvailabilitiesTableSeeder');
    }

    public function test特定日の空き時間を取得する(): void
    {
        // 当日の日付を文字列で取得
        $today = Carbon::now()->format('Y-m-d');

        // 設定された空き日を取得
        $availabilities = app(IAvailabilityRepository::class)->findAvailabilitiesByDates(collect($today), 1);

        // 日付をキーにした配列でその日の空いてる時間を返す
        $result = [];

        foreach ($availabilities as $availability) {
            $date = $availability->available_date->format('Y-m-d');
            $result[$date] = $availability->availableTimes->map(function ($availableTime) {
                return $availableTime->time;
            });
        }
        // Seederで最初に作成しているのは当日の予約
        $this->assertSame(array_key_first($result), $today);

        // 日付に紐づいた可能な時間は３つ
        $collection = $result[$today];
        $this->assertSame($collection->count(), 3);
    }
}
