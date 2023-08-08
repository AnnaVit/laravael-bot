<?php

namespace App\Http\Validate;

use Illuminate\Routing\Controller as BaseController;

class TelegramUserValidate extends BaseController
{
    /**
     * Валидация сообщений отправленных пользователем в бот в виде текста
     * @param $data
     * @return mixed
     */

    public function telegramUserValidate($data): mixed
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

    /**
     * Валидация callback отправленных от бота
     * @param $data
     * @return mixed
     */

    public function callbackValidate($data): mixed
    {
        return $data->validate([
            'update_id' => ['required', 'integer'],
            'callback_query' => ['required'],
            ]);
    }
}
