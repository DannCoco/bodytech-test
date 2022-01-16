<?php

namespace App\Traits\Cart;

use Auth;

trait CartTrait
{
    public function mapData($stock, $cart, $product)
    {
        $total = 0;
        $price = ($product->discount > 0) ? $product->final_price : $product->price;

        if(!is_null($cart)){
            $total = $cart->total;
        }

        if($stock > 0){
            $price = $total + ($price * $stock);
        } else {
            $price = $total - ($price * $product->stock);
        }

        $values = collect(['subtotal' => $price, 'total' => $price, 'state' => 'PARTIAL']);
        return $values->merge(collect(['user_id' => Auth::user()->id]));
    }
}
