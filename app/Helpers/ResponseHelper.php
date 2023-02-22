<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    /**
     * Вернуть пустой Json.
     * @return JsonResponse
     */
    public function emptyResponse(): JsonResponse
    {
        $data = (object) [];
        return response()->json($data, 200, [], JSON_FORCE_OBJECT);
    }
}