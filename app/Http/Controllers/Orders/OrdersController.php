<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

use App\Http\Requests\Order\OrderRequest;

use App\Traits\Cart\CartTrait;

use App\Repositories\Order\OrderRepository, App\Repositories\OrderDetail\OrderDetailRepository,  App\Repositories\Cart\CartRepository;

class OrdersController extends Controller
{
    use CartTrait;

    public function __construct(OrderRepository $order, OrderDetailRepository $orderDetail, CartRepository $cart)
    {
        $this->cart = $cart;
        $this->order = $order;
        $this->orderDetail = $orderDetail;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\OrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        DB::beginTransaction();
        try {
            $cart = $this->cart->getCartWithDetail($request->cart_id);

            if(!is_null($cart)){
                $dataOrder = $this->mapDataByOrder($cart);
                $order = $this->order->create($dataOrder->toArray());

                $dataOrderDetail = $this->mapDataByOrderDetail($order->id, $cart['detail']);
                $this->orderDetail->create($dataOrderDetail->toArray());

                $this->cart->update($cart->id, ['state' => 'FINISHED']);
            }


            DB::commit();
            return response()->json(['success' => true, 'message' => 'Se ha creado la orden'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
