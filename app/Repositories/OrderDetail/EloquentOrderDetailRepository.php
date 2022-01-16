<?php

namespace App\Repositories\OrderDetail;

use App\Models\Order\OrderDetail;

class EloquentOrderDetailRepository implements OrderDetailRepository
{
    public function create($data)
    {
        return OrderDetail::insert($data);
    }
}
