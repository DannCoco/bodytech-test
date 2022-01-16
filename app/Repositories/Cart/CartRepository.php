<?php

namespace App\Repositories\Cart;

interface CartRepository
{
    public function All($data);

    public function create($data);

    public function getById($id);

    public function update($id, $data);

    public function delete($id);

    public function getCartWithDetail($id);
}
