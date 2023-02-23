<?php

namespace App\Http\Validate;

use Illuminate\Routing\Controller as BaseController;

class TelegramUserValidate extends BaseController
{
    public function telegramUserValidate($data)
    {
        return $data->validate([
            'update_id' => ['required', 'integer'],
            'message' => [
                'message_id' => ['required', 'integer'],
                'from' => [
                    'id' => ['required', 'integer'],
                    'is_bot' => ['required', 'boolean'],
                    'first_name' => ['required', 'string'],
                    'last_name' => ['string'],
                    'username' => ['string'],
                    'language_code' => ['required', 'string'],
                ],
                'chat' => [
                    'id' => ['required', 'date'],
                    'first_name' => ['required', 'string'],
                    'username' => ['string'],
                    'type' => ['required', 'string'],
                ],
                'date' => ['required', 'date'],
                'text' => ['required', 'string'],
            ],
        ]);
    }
}
