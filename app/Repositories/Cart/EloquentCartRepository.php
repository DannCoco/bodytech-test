<?php

namespace App\Repositories\Cart;

use App\Models\Cart\Cart;

class EloquentCartRepository implements CartRepository
{
    public function All($data)
    {
        return Cart::all($data);
    }

    public function create($data)
    {
        return Cart::create($data);
    }

    public function getById($id)
    {
        return Cart::find($id);
    }

    public function update($id, $data)
    {
        $cart = Cart::find($id);

        if($cart instanceof Cart){
            return $cart->update($data);
        }
    }

    public function delete($id)
    {
        return Cart::find($id)->delete();
    }

    public function getCartWithDetail($id)
    {
        return Cart::where('id', $id)->where('state', 'PARTIAL')->with('detail')->first();
    }
}
