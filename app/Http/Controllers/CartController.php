<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Store;
use Carbon\Carbon;
use Validator;
use Session;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $session_id = Session::getId();
        $cartData = Cart::where('guest_session', $session_id)
            ->select('products.product_name', 'products.product_price', 'stores.store_name')
            ->join('products', 'products.id', '=', 'carts.product_id')
            ->join('stores', 'stores.id', '=', 'products.store_id')
            ->get();

        $total = 0;
        foreach ($cartData as $row) {
            $total += $row->product_price;
            echo $row->store_name . " - " . $row->product_name . " <b> " . $row->product_price  . "</b>" . "<br>";
        }
        echo "<h2 align='right'>Total: $total</h2>";
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
        //Guest session will vanish after clearing session or closing browser
        $session_id = Session::getId();
        $created_at = Carbon::now();

        $validator = Validator::make($request->all(), [
            // 'guest_session' => 'required|string|between:2,500',
            'product_id' => 'required|exists:products,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $cartModel = new Cart;
        try {
            //Save the user
            $cartModel->guest_session = $session_id;
            $cartModel->product_id = $request->product_id;
            $cartModel->created_at = $created_at;
            $cartModel->save();
            return array('status' => 'success', 'msg' => 'Product added to cart');
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
