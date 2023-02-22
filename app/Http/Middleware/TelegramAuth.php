<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TelegramAuth
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->has('user')) {

            $id = $request->session()->get('user');
            $user = $this->user->findUserById($id);

            if($user->isEmpty()) {
                return redirect('/no_access');
            }

            $tokenExpire = Carbon::create($user->value('authorization_token_expire'))->timestamp;

            if ($tokenExpire < Carbon::now()->timestamp) {
                return redirect('/no_access');
            }
            return $next($request);

        } else {
            return redirect('/no_access');
        }
    }
}
