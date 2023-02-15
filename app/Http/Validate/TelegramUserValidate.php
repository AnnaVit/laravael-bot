<?php

namespace App\Http\Validate;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class TelegramUserValidate extends BaseController
{
    public function telegramUserValidate($data)
    {
    //var_dump($data);
        $data->validate([
            'update_id' => 'required',
            'message' => [
                'message_id' => 'required',
                'from' => [
                    'id' => 'required',
                    'is_bot' => 'required',
                    'first_name' => 'required',
                    'username' => 'required',
                    'language_code' => 'required',
                ],
                'chat' => [
                    'id' => 'required',
                    'first_name' => 'required',
                    'username' => 'required',
                    'type' => 'required',
                ],
                'date' => 'required',
                'text' => 'required',
            ]
        ]);
    }
}
