<?php

declare(strict_types=1);

namespace App\Repositories\Skill;

use App\Models\Skill;

class SkillEQRepository implements ISkillRepository
{
    public function getAll()
    {
        return Skill::all();
    }
}
