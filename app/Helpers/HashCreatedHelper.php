<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;

class HashCreatedHelper
{
    /**
     * Сгенерировать hash для url.
     * @param int $id
     * @return string
     */
    public function hashCreate(int $id): string
    {
        return Crypt::encryptString($id);
    }
}