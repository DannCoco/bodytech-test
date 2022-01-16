<?php

namespace App\Http\Controllers\Carts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

use App\Http\Requests\Cart\CartRequest;

use App\Traits\Cart\CartTrait;

use App\Repositories\Cart\CartRepository, App\Repositories\CartDetail\CartDetailRepository, App\Repositories\Product\ProductRepository;

class CartsController extends Controller
{
    use CartTrait;

    public function __construct(CartRepository $cart, CartDetailRepository $cartDetail, ProductRepository $product)
    {
        $this->cart = $cart;
        $this->product = $product;
        $this->cartDetail = $cartDetail;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CartRequest $request)
    {
        DB::beginTransaction();
        try {
            $product = $this->product->getById($request->product_id);
            $this->product->update($request->product_id, ['stock' => ($product->stock - $request->stock)]);
            $cartCreated = $this->cart->create( $this->mapData($request->stock, null, $product)->toArray() );

            $product['stock'] = $request->stock;
            $this->cartDetail->create( collect($product)->merge( collect(['cart_id' => $cartCreated->id, 'product_id' => $product->id]) )->toArray() );

            DB::commit();
            return response()->json(['success' => true, 'cart_id' => $cartCreated->id], 200);
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
        return $this->cart->getCartWithDetail($id);
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
        DB::beginTransaction();
        try {
            $product = $this->product->getById($request->product_id);

            $stockInit = $request->stock;
            $stock = $product->stock - $stockInit;
            $productExist = $this->cartDetail->getCartDetailByProduct($id, $product->id);
            if($productExist){
                $product['stock'] = $stockInit + $productExist->stock;

                if($stockInit == 0){
                    $this->cartDetail->delete($productExist->id);
                    $product = $productExist;
                    $stock = $product->stock + $stockInit;
                }

                $this->cartDetail->update( $productExist->id, collect($product)->merge( collect(['carts_id' => $id]) )->toArray() );
            } else {
                $product['stock'] = $stockInit;
                $this->cartDetail->create( collect($product)->merge( collect(['cart_id' => $id, 'product_id' => $product->id]) )->toArray() );
            }

            $cart = $this->cart->getById($id);
            $this->cart->update( $cart->id, $this->mapData( $stockInit, $cart, $product )->toArray() );

            $this->product->update($request->product_id, ['stock' => $stock]);

            DB::commit();
            return response()->json(['success' => true, 'cart_id' => $id], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
    }
}
