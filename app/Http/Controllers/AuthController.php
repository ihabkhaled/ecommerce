<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Store;
use App\Models\User_Token;
use Validator;
use JWTAuth;
use JWTFactory;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Session;
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'logout']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // $request->password = SHA1($request->password);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = JWTAuth::attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $created_at = Carbon::now();

        $validatorUser = Validator::make($request->all(), [
            'full_name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'mobile' => 'required|string|min:11|max:11|unique:users',
        ]);

        if ($validatorUser->fails()) {
            return response()->json($validatorUser->errors()->toJson(), 400);
        }

        //validations for store
        $validatorStore = Validator::make($request->all(), [
            'store_name' => 'required|string|between:2,100'
        ]);

        if ($validatorStore->fails()) {
            return response()->json($validatorStore->errors(), 422);
        }

        $storeModel = new Store;
        try {
            $user = User::create(array_merge(
                $validatorUser->validated(),
                ['password' => bcrypt($request->password), 'created_at' => $created_at],
            ));
            $user_id = $user->id;

            if ($user_id) {
                //Save the store
                $storeModel->store_name = $request->store_name;
                $storeModel->user_id = $user_id;
                $storeModel->created_at = $created_at;
                $storeModel->save();

                if ($storeModel->id) {
                    return response()->json([
                        'message' => 'User and Store are successfully registered',
                        'user' => $user,
                        'store' => $storeModel
                    ], 201);
                } else {
                    return response()->json([
                        'message' => 'User registered, Store rejected!'
                    ], 400);
                }
            } else {
                return response()->json([
                    'message' => 'User registeration error'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        // auth()->logout();
        Session::put('logged_in', 0);
        User_Token::where('token', $_COOKIE['auth'])->delete();
        cookie('auth', '', 10080);

        return redirect('/login')->withCookie(cookie('auth', '', 10080));
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        $user_id = auth()->user()->id;
        $user = new User_Token;
        try {
            //Save the user
            $user->user_id = $user_id;
            $user->token = $token;
            $user->save();
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }

        // $response = new Response(array(
        //     'access_token' => $token,
        //     'token_type' => 'bearer',
        //     'expires_in' => JWTFactory::getTTL() * 24 * 7,
        //     'user' => auth()->user()
        // ));
        return redirect('/cart')->withCookie(cookie('auth', $token, 10080));
    }
}
