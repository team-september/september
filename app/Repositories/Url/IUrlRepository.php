<?php

declare(strict_types=1);

namespace App\Repositories\Url;

interface IUrlRepository
{
    public function update($url, $request, $snsType);

    public function create($urlType);
}
