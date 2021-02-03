<?php


namespace App\Repositories\Skill;

use App\Models\Skill;

class SkillEQRepository implements ISkillRepository
{
    public function getAll()
    {
        return Skill::all();
    }
}
