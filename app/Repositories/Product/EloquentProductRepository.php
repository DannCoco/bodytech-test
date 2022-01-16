<?php

namespace App\Repositories\Product;

use App\Models\Product\Product;

class EloquentProductRepository implements ProductRepository
{
    public function paginate($page)
    {
        return Product::paginate($page);
    }

    public function create($data)
    {
        return Product::create($data);
    }

    public function getById($id)
    {
        return Product::find($id);
    }

    public function update($id, $data)
    {
        $product = Product::find($id);

        if($product instanceof Product){
            return $product->update($data);
        }
    }

    public function delete($id)
    {
        return Product::find($id)->delete();
    }

    public function insert($data)
    {
        return Product::insert($data);
    }
}
