<?php

namespace App\Repositories\Order;

interface OrderRepository
{
    public function create($data);

    public function getByDate($data);
}
