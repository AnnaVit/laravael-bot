<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    /*protected $hidden = [
        'hash'
    ];*/

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    /*э
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];*/

    public function findUserByHash(string $authorization_token)
    {
        return $this::query()
            ->where('authorization_token', '=', $authorization_token)
            ->limit(1)
            ->get();

        //todo проставить лимит, переделать запрос
        //return $this::where('authorization_token', '=', $authorization_token)->get();
    }

    public function findUserById(string $id)
    {
        return $this::query()
            ->where('id', '=', $id)
            ->limit(1)
            ->get();

        //todo проставить лимит, переделать запрос
        //return $this::where('authorization_token', '=', $authorization_token)->get();
    }
}
