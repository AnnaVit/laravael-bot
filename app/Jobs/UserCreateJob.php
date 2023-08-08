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

    private array $data;
    private UrlCreatedHelper $urlCreated;
    private SendMessageService $sendMessageService;
    private UserService $userService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        array $data,
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
     * @return string
     */
    public function handle(): string
    {
        if (array_key_exists('message', $this->data) &&
            $this->data['message']['text'] === '/start'
        ) {
            $data =$this->data['message']['from'];
        } elseif (array_key_exists('callback_query', $this->data) &&
            $this->data['callback_query']['data'] === '/start'
        ) {
            $data = $this->data['callback_query']['message']['chat'];
        } else {
            $this->sendMessageService->sendMessageWithButton($this->data['message']['chat']['id']);
            return;
        }

        $newUser = $this->userService->createUserFromTelegram($data);

        $url = $this->urlCreated->newUrl($newUser->getAttribute('authorization_token'));

        $this->sendMessageService->sendAuthorizationMessage(
            $newUser->getAttribute('id'),
            $url
        );
    }
}
