<?php

namespace App\Http\Middleware;

use App\Repositories\UserRepository;
use Closure;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $repository = new UserRepository();

        $user = $repository->findById(session()->get('userId'));

        if($user->isAdmin == 1) {
            return $next($request);
        } else {
            abort(401);
        }
    }
}
