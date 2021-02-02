<?php


namespace App\Repositories\Purpose;

use App\Models\Purpose;

class PurposeEQRepository implements IPurposeRepository
{
    public function getAll()
    {
        return Purpose::all();
    }

}
