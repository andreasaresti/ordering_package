<?php

namespace Eshop\OrderBuilder\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use \App\Models\Order;

class OrderController extends Controller
{
    public function getOrder(Request $request, $id)
    {
        return Order::with([
            'items.product',
            'items.variant',
            'items.variant.options'
        ])->find($id);
    }

    public function getItems($id){
        return Order::with([
                'items.product',
                'items.variant',
                'items.variant.options'
            ])->find($id)->items;
    }

    public function addItem(Request $request, $id)
    {
        $order = Order::find($id);
        // if item already exists, update quantity
        
        $item = $order->items
            ->where('product_id', $request->product_id)
            ->where('variant_id', $request->variant_id)
            ->first();
        
        // if($item){
        //     $item->quantity = $item->quantity + $request->quantity;
        //     $item->save();
        // } else {
            $order->items()->create($request->all());
        // }
        $order->recalculateTotals();
        $order->save();
        
        return Order::with(['items.product','items.variant','items.variant.options'])->find($id);
    }

    public function updateItem(Request $request, $id, $item_id)
    {
        $order = Order::find($id);
        $item = $order->items->find($item_id);
        $item->update($request->all());
        $order->recalculateTotals();
        $order->save();
        return Order::with(['items.product','items.variant','items.variant.options'])->find($id);
    }
    
    public function deleteItem($id,$item_id)
    {
        $order = Order::find($id);
        $order->items()->find($item_id)->delete();
        $order->recalculateTotals();
        $order->save();
        return Order::with(
            [
                'items.product',
                'items.variant',
                'items.variant.options'
            ])
            ->find($id);
    }
}