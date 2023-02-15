<?php

namespace App\Jobs;

use App\Http\Controllers\SendMessageController;
use App\Http\Controllers\UrlGenerateController;
use App\Http\Controllers\UserAddDbController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserCrateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $data;
    private UserAddDbController $addUser;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        array $data,
        UserAddDbController $addUser,
    )
    {
        $this->data = $data;
        $this->addUser = $addUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $newUser = $this->addUser->addUserDb($this->data);

        $url = (new UrlGenerateController())->newUrl($newUser->getAttribute('authorization_token'));

        (new SendMessageController())->sendTelegramMessage(
            $newUser->getAttribute('id'),
            $url);
    }
}

