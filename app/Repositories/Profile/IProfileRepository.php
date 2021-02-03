<?php


namespace App\Repositories\Profile;


interface IProfileRepository
{
    public function create($userId);

    public function update($profile, $request);
}
