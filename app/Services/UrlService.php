<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Url\IUrlRepository;

class UrlService
{
    protected $urlRepository;

    /**
     * UrlService constructor.
     *
     * @param $urlRepository
     */
    public function __construct(IUrlRepository $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }

    public function findUrls($profile, $urlTypes)
    {
        $urls = [];

        foreach ($profile->urls as $index => $url) {
            $urls[$urlTypes[$index]] = $url;
        }

        return $urls;
    }

    public function update($url, $request, $snsType)
    {
        return $this->urlRepository->update($url, $request, $snsType);
    }
}
