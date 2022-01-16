<?php

namespace App\Repositories\CartDetail;

interface CartDetailRepository
{
    public function All($data);

    public function create($data);

    public function getById($id);

    public function update($id, $data);

    public function delete($id);

    public function getCartDetailByProduct($cart, $product);
}
