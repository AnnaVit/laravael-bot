<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Validate\TelegramUserValidate;
use App\Jobs\UserCrateJob;

class UserCreatedController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private TelegramUserValidate $userValidate;
    private UserAddDbController $addUser;

    public function __construct(
        TelegramUserValidate $userValidate,
        UserAddDbController $addUser
    )
    {
        $this->userValidate = $userValidate;
        $this->addUser = $addUser;
    }
    /**
     * Сохранить нового пользователя.
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function newUser(Request $request): JsonResponse
    {
        $this->userValidate->telegramUserValidate($request);
        $data = $request->post();

        UserCrateJob::dispatch($data, $this->addUser);

        $data = (object) [];
        return response()->json($data, 200, [], JSON_FORCE_OBJECT);
    }
}