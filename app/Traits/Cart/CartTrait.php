<?php

namespace App\Traits\Cart;

use Auth;

trait CartTrait
{
    public function mapData($stock, $cart, $product)
    {
        $total = 0;
        $price = ($product->discount > 0) ? $product->final_price : $product->price;

        if(!is_null($cart)){
            $total = $cart->total;
        }

        if($stock > 0){
            $price = $total + ($price * $stock);
        } else {
            $price = $total - ($price * $product->stock);
        }

        $values = collect(['subtotal' => $price, 'total' => $price, 'state' => 'PARTIAL']);
        return $values->merge(collect(['user_id' => Auth::user()->id]));
    }

    public function mapDataByOrder($data)
    {
        unset($data['detail']);
        $data['state'] = 'FINISHED';

        return collect($data)->merge(
            collect([
                'full_name' => Auth::user()->first_name. ' '.Auth::user()->first_name,
                'identification_type' => Auth::user()->identification_type,
                'identification_number' => Auth::user()->identification_number,
                'phone' => Auth::user()->phone
            ])
        );
    }

    public function mapDataByOrderDetail($orderId, $data)
    {
        return collect($data)->map(function($detail) use($orderId){
            $detail->order_id = $orderId;

            unset($detail->id);
            unset($detail->cart_id);
            unset($detail->product_id);
            unset($detail->deleted_at);
            unset($detail->created_at);
            unset($detail->updated_at);
            return $detail;
        });
    }

    public function csv($file)
    {
        header('Content-type: text/plain; charset=utf-8');

        $path = $file->getRealPath();
        $getFile = fopen('C:/xampp/tmp/products.csv', 'w');
        $fileNew = fopen($path, 'r');

        $count = 0;
        $mapData = [];
        $newData = [];

        while (!feof($fileNew)) {
            $line = fgetcsv($fileNew, 0, ',');
            if(!empty($line[0])){
                if ($count != 0 && $line) {
                    $mapData['name'] = $line[0];
                    $mapData['description'] = $line[1];
                    $mapData['price'] = $line[2];
                    $mapData['discount'] = $line[3];
                    $mapData['image'] = $line[4];
                    $mapData['stock'] = $line[5];

                    array_push($newData, $mapData);
                }
            }

            $count++;
        }

        return $newData;
    }
}
