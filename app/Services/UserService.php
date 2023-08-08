<?php

namespace App\Services;

use App\Helpers\HashCreatedHelper;
use App\Models\User;
use Carbon\Carbon;

class UserService
{
    private HashCreatedHelper $hash;

    public function __construct(HashCreatedHelper $hash)
    {
        $this->hash = $hash;
    }
    /**
     * Сохранить нового пользователя.
     *
     * @param array $data
     * @return User
     */

    public function createUserFromTelegram(array $data): User
    {
        $fields = [];
        foreach (array_keys($data) as $value) {
            $fields[$value] = $data[$value];
        }

        //todo перенести при открытии ссылки

        $fields['authorization_token'] = $this->hash->hashCreate($data['id']);
        $fields['authorization_token_expire'] = Carbon::now()->addMinutes(24);

        return User::create($fields);
    }
}