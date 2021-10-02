<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JWTAuth;
use Exception;
use App\Models\User_Token;
use Session;

class JwtMiddlewareLogout
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
        try {
            if ($_COOKIE['auth'] != null) {
                $request->headers->set('Authorization', "bearer " . $_COOKIE['auth']);
                $user_id_session = '';
                $user_id_session = User_Token::where('token', $_COOKIE['auth'])->first()->value('user_id');
                if ($user_id_session) {
                    Session::put('user_id_session', $user_id_session);
                }
                Session::put('logged_in', 1);
            } else {
                Session::put('user_id_session', NULL);
                Session::put('logged_in', 0);
            }
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            Session::put('user_id_session', NULL);
            Session::put('logged_in', 0);
        }
        return $next($request);
    }
}
