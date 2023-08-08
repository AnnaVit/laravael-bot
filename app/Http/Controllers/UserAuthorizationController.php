<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class UserAuthorizationController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Авторизация пользователя на сайте
     * @param Request $request
     * @param string $authorizationToken
     * @return Application|RedirectResponse|Redirector|void
     */
    public function authorizeUser(Request $request, string $authorizationToken)
    {
        $user = $this->user->findUserByAuthorizationToken($authorizationToken);

        if($user->isEmpty()) {
            return;
        }

        $request->session()->put('user', $user->value('id'));
        return redirect('/');
    }
}
