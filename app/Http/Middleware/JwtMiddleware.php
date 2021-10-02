<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use App\Models\User_Token;
use Session;

class JwtMiddleware extends BaseMiddleware
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
        try {   
            if ($_COOKIE['auth'] != null) {
                $request->headers->set('Authorization', "bearer " . $_COOKIE['auth']);
                $user_id_session = '';
                $user_id_session = User_Token::where('token', $_COOKIE['auth'])->value('user_id');
                if ($user_id_session) {
                    Session::put('user_id_session', $user_id_session);
                }
            }
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            Session::put('logged_in', 0);
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['status' => 'Token is Invalid']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['status' => 'Token is Expired']);
            } else {
                return response()->json(['status' => 'Authorization Token not found']);
            }
        }
        Session::put('logged_in', 1);
        return $next($request);
    }
}
