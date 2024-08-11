<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function show()
    {
        $cart = Cart::where([
            'status' => Cart::IN_PROGRESS,
            'user_id' => auth()->user()->id
        ])->first();
        
        if ($cart) {
            return new CartResource($cart);
        }
        
        return emptyResponse();
    }

    public function add_product(Request $request) {
        $cart = Cart::where([
            'status' => Cart::IN_PROGRESS,
            'user_id' => auth()->user()->id
        ])->first();
        
        if (!$cart) {
            $cart = new Cart();
            $cart->status = Cart::IN_PROGRESS;
            $cart->user_id = auth()->user()->id;
            $cart->save();
        }
        
        if (!$cart->products->contains($request->get('product_id'))){
            $cart->products()->attach($request->get('product_id'),['amount' => $request->get('amount')]);
        }
        
        return new CartResource($cart->fresh());
    }
    
    public function remove_product(Request $request) {
        $cart = Cart::findorFail($request->get('cart_id'));
        
        if (!$cart->products->contains($request->get('product_id'))) {
            return notFoundResponse();
        }
    
        $cart->products()->detach($request->get('product_id'));
    
        return new CartResource($cart->fresh());
    }
}
