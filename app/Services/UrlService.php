<?php

declare(strict_types=1);

namespace App\Services;

class UrlService
{
    public function findUrls($profile, $urlTypes)
    {
        $urls = [];

        foreach ($profile->urls as $index => $url) {
            $urls[$urlTypes[$index]] = $url;
        }

        return $urls;
    }
}
