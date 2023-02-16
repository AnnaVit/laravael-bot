<?php

namespace App\Helpers;

class UrlCreatedHelper
{

    private string $url;

    public function __construct()
    {
        $this->url=config('app.base_url');
    }
    /**
     * Сгенерировать URL для авторизации.
     * @param string $hash
     * @return string
     */

    public function newUrl(string $hash): string
    {
        return $this->url . '/auth/' . $hash;
    }
}