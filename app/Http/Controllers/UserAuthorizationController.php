<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class UserAuthorizationController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function authorizeUser(Request $request, string $authorization_token)
    {
        $user = $this->user->findUserByAuthorizationToken($authorization_token);

        if($user->isEmpty()) {
            return;
        }

        $request->session()->put('user', $user->value('id'));
        return redirect('/');
    }
}
