<?php


namespace App\Repositories\Url;


interface IUrlRepository
{
    public function update($url, $request, $urTypes, $index);

    public function create($urlType);

}
