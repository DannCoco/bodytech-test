<?php

namespace App\Repositories\CartDetail;

use App\Models\Cart\CartDetail;

class EloquentCartDetailRepository implements CartDetailRepository
{
    public function All($data)
    {
        return CartDetail::all($data);
    }

    public function create($data)
    {
        return CartDetail::create($data);
    }

    public function getById($id)
    {
        return CartDetail::find($id);
    }

    public function update($id, $data)
    {
        $dartDetail = CartDetail::find($id);

        if($dartDetail instanceof CartDetail){
            return $dartDetail->update($data);
        }
    }

    public function delete($id)
    {
        return CartDetail::find($id)->delete();
    }

    public function getCartDetailByProduct($cart, $product)
    {
        return CartDetail::where('cart_id', $cart)->where('product_id', $product)->first();
    }
}
