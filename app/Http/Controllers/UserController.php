<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        dd($users);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $created_at = Carbon::now();

        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6',
            'full_name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'mobile' => 'required|string|min:11|max:11|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $email = $request->email;
        $full_name = $request->full_name;
        $mobile = $request->mobile;
        $password = bcrypt($request->password);

        //handle email duplication error
        /* $user = User::where('email', $email)->limit(1)->get();
        if (sizeof($user) == 1) {
            return array('status' => 'error', 'msg' => 'Email already exists');
        } */

        //handle mobile duplication error
        /* $user = User::where('mobile', $mobile)->limit(1)->get();
        if (sizeof($user) == 1) {
            return array('status' => 'error', 'msg' => 'Mobile number already exists');
        } */

        $userModel = new User;
        try {
            //Save the user
            $userModel->full_name = $full_name;
            $userModel->email = $email;
            $userModel->password = $password;
            $userModel->mobile = $mobile;
            $userModel->created_at = $created_at;
            $userModel->save();
            return array('status' => 'success', 'msg' => 'User saved');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
