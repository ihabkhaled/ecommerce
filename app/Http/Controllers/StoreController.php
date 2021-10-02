<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Product;
use Carbon\Carbon;
use Validator;
use JWTAuth;
use Session;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $stores = Store::select('*')->get();

        return view('stores', ['stores' => $stores]);
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
        //
        $created_at = Carbon::now();
        $request->user_id = Session::get('user_id_session');

        $validator = Validator::make($request->all(), [
            'store_name' => 'required|string|between:2,100',
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $storeModel = new Store;
        try {
            //Save the user
            $storeModel->store_name = $request->store_name;
            $storeModel->user_id = $request->user_id;
            $storeModel->created_at = $created_at;
            $storeModel->save();

            return response()->json([
                'message' => 'Store successfully added',
                'user' => $storeModel
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
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
        $products = Product::where('store_id', $id)->select('*')->get();
        $store = Store::where('id', $id)->select('store_name')->limit(1)->first()->value('store_name');

        return view('storeProducts', ['products' => $products, 'store_id' => $id, 'store_name' => $store]);
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
