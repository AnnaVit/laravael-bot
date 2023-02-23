<?php

namespace App\Http\Controllers;

use App\Helpers\UrlCreatedHelper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Validate\TelegramUserValidate;
use App\Jobs\UserCreateJob;
use App\Helpers\ResponseHelper;
use App\Services\SendMessageService;
use App\Services\UserService;

class UserCreatedController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private TelegramUserValidate $userValidate;
    private UserService $userService;
    public ResponseHelper $emptyResponse;
    private UrlCreatedHelper $urlCreated;
    private SendMessageService $sendMessageService;

    public function __construct(
        TelegramUserValidate $userValidate,
        UserService $userService,
        ResponseHelper $emptyResponse,
        UrlCreatedHelper $urlCreated,
        SendMessageService $sendMessageService,
    )
    {
        $this->userValidate = $userValidate;
        $this->userService = $userService;
        $this->emptyResponse = $emptyResponse;
        $this->urlCreated = $urlCreated;
        $this->sendMessageService = $sendMessageService;
    }
    /**
     * Сохранить нового пользователя.
     *
     * @param Request $request
     * @return JsonResponse $response
     */

    public function newUser(Request $request): JsonResponse
    {
        $data = $this->userValidate->telegramUserValidate($request);

        UserCreateJob::dispatch(
            $data,
            $this->urlCreated,
            $this->sendMessageService,
            $this->userService
        );

        return $this->emptyResponse->emptyResponse();
    }
}