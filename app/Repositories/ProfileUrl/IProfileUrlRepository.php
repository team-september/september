<?php


namespace App\Repositories\ProfileUrl;


interface IProfileUrlRepository
{
    public function create($profileId, $urlId);

}
