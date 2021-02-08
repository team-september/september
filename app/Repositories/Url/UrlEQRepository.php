<?php

declare(strict_types=1);

namespace App\Repositories\Url;

use App\Models\Url;

class UrlEQRepository implements IUrlRepository
{
    public function update($url, $request, $urTypes, $index): void
    {
        $urTypes[$index];
        $url->fill(['url' => $request->input($urTypes[$index])])->save();
    }

    public function create($urlType)
    {
        return Url::create(
            [
                'url_type' => $urlType,
            ]
        );
    }
}
