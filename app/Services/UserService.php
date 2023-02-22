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
        $fields = [
            'id' => $data['id'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'authorization_token' => $this->hash->hachCreate($data['id']),
            'authorization_token_expire' => Carbon::now()->addMinutes(24),
        ];

        return User::create($fields);
    }
}