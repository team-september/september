<?php


namespace App\Repositories\Career;

use App\Models\Career;

class CareerEQRepository implements ICareerRepository
{
    public function getAll()
    {
        return Career::all();
    }
}
