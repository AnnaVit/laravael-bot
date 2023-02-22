<?php

namespace App\Jobs;

use App\Helpers\UrlCreatedHelper;
use App\Services\SendMessageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\UserService;

class UserCreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;
    private UrlCreatedHelper $urlCreated;
    private SendMessageService $sendMessageService;
    private UserService $userService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        $data,
        UrlCreatedHelper $urlCreated,
        SendMessageService $sendMessageService,
        UserService $userService,
    )
    {
        $this->data = $data;
        $this->urlCreated = $urlCreated;
        $this->sendMessageService = $sendMessageService;
        $this->userService = $userService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (array_key_exists('message', $this->data)) {
            $newUser = $this->userService->createUserFromTelegram($this->data['message']['from']);

            $url = $this->urlCreated->newUrl($newUser->getAttribute('authorization_token'));

            $this->sendMessageService->sendTelegramMessage(
                $newUser->getAttribute('id'),
                $url
            );
        }
    }
}

