<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $roles = array_slice(func_get_args(), 2);
        $user = auth()->user();
        $result = false;

        foreach ($roles as $role) {
            if ($role === 'user' && $user->role === 0)
                $result = true;
            if ($role === 'moderator' && $user->role === 1)
                $result = true;
            if ((int)$role === User::ROLE_ADMINISTRATOR && $user->role === User::ROLE_ADMINISTRATOR)
                $result = true;
        }

        if (!$result)
            return redirect()->route('home');

        return $next($request);
    }
}
