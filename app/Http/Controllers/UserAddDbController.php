<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Routing\Controller as BaseController;

class UserAddDbController extends BaseController
{
    private HachCreatedController $hash;

    public function __construct(HachCreatedController $hash)
    {
        $this->hash = $hash;
    }
    /**
     * Сохранить нового пользователя.
     *
     * @param array $data
     * @return User
     */

    public function addUserDb(array $data)
    {
        $fields = $data['message']['from'];

        $buildFields = [
            'id' => $fields['id'],
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'username' => $fields['username'],
            'authorization_token' => $this->hash->hachCreate($fields['id']),
            'authorization_token_expire' => Carbon::now()->addMinutes(24),
        ];

        return User::create($buildFields);
    }
}