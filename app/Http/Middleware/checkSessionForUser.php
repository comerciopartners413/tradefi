<?php

namespace TradefiUBA\Http\Middleware;

use Closure;

class checkSessionForUser
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
        $user_session_count = count(\DB::table('sessions')->where('user_id', 1)->get());

        if ($user_session_count >= 1) {
            $logged_in_user         = \TradefiUBA\User::find(1)->id;
            $rejected_user_username = $request->username;
            $rejected_password      = $request->password;
            return response()->json(['auth_exist' => $user_session_count, 'logged_in_user' => $logged_in_user, 'rejected_user_username' => $rejected_user_username, 'rejected_password' => \Hash::make($rejected_password)])
                ->setStatusCode(403, 'Multiple Login');
            // dd("aye");
        } else {
            return $next($request);
        }

    }
}
