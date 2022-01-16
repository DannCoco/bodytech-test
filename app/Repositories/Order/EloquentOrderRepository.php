<?php

namespace App\Repositories\Order;

use App\Models\Order\Order;

class EloquentOrderRepository implements OrderRepository
{
    public function create($data)
    {
        return Order::create($data);
    }
}
