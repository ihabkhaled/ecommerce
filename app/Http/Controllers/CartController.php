<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Store;
use Carbon\Carbon;
use Validator;
use Session;
use Illuminate\Support\Facades\Route;

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
        $msg = '';
        if (Session::get('deleted') == 1) {
            $msg = "Product removed from your cart!";
        } else if (Session::get('deleted') == 2) {
            $msg = "Error removing product!";
        }

        $session_id = Session::getId();
        $cartData = Cart::where('guest_session', $session_id)
            ->select('products.product_name', 'products.product_price', 'stores.store_name', 'carts.id')
            ->join('products', 'products.id', '=', 'carts.product_id')
            ->join('stores', 'stores.id', '=', 'products.store_id')
            ->get();

        return view('cart', ['total' => 0, 'cartData' => $cartData, 'msg' => $msg]);
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
            'product_id' => 'required|exists:products,id',
            'store_id' => 'required|exists:stores,id'
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

            return redirect('/cart')->with('added', 1);
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
        echo "show";
        dd($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        echo "edit";
        dd($id);
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
        if (Cart::where('id', $id)->delete()) {
            return redirect('/cart')->with('deleted', 1);
        } else {
            return redirect('/cart')->with('deleted', 2);
        }
    }
}
