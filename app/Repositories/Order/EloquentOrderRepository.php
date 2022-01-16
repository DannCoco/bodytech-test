<?php

namespace App\Repositories\Order;

use App\Models\Order\Order;

class EloquentOrderRepository implements OrderRepository
{
    public function create($data)
    {
        return Order::create($data);
    }

    public function getByDate($data)
    {
        $startDate = date('Y-m-d', strtotime($data['start_date']));
        $endDate = date('Y-m-d', strtotime($data['end_date']));

        return Order::select('full_name', 'identification_type', 'identification_number', 'phone', 'subtotal', 'total', 'state', 'created_at')->whereBetween('created_at', ["$startDate 00:00:00", "$endDate 23:59:59"])->get();
    }
}
