<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Crypt;

class HachCreatedController extends BaseController
{
    /**
     * Сгенерировать hash для url.
     * @param int $id
     * @return string
     */
    public function hachCreate(int $id): string
    {
        return Crypt::encryptString($id);
    }
}