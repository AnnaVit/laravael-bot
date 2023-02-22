<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Collection;

class User extends BaseModel
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'username',
        'authorization_token',
        'authorization_token_expire',
    ];

    public function findUserByAuthorizationToken(string $authorizationToken): Collection|array
    {
        $where = 'authorization_token';
        return $this->findBy($where, $authorizationToken);
    }

    public function findUserById(string $id): Collection|array
    {
        $where = 'id';
        return $this->findBy($where, $id);
    }
}
