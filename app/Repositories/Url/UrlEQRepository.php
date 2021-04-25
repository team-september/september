<?php

declare(strict_types=1);

namespace App\Repositories\Url;

use App\Models\Url;

class UrlEQRepository implements IUrlRepository
{
    public function update($url, $request, $snsType): void
    {
        $url->fill(['url' => $request->input($snsType)])->save();
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
