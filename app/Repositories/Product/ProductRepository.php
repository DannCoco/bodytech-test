<?php

namespace App\Repositories\Product;

interface ProductRepository
{
    public function paginate($page);

    public function create($data);

    public function getById($id);

    public function update($id, $data);

    public function insert($data);
}
