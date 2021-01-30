<?php


namespace App\Services;


use App\Models\Profile;

class UrlService
{
    private $profile;

    /**
     * UrlService constructor.
     * @param $profile
     */
    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
    }

    public function findUrls()
    {
        $urls = [];
        $url_types = config('url.types');
        foreach ($this->profile->urls as $index => $url) {
            $urls[$url_types[$index]] = $url;
        }

        return $urls;
    }
}
