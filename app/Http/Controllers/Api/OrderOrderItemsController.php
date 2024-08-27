<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderItemResource;
use App\Http\Resources\OrderItemCollection;

class OrderOrderItemsController extends Controller
{
    public function index(Request $request, Order $order): OrderItemCollection
    {
        $this->authorize('view', $order);

        $search = $request->get('search', '');

        $orderItems = $order
            ->orderItems()
            ->search($search)
            ->latest()
            ->paginate();

        return new OrderItemCollection($orderItems);
    }

    public function store(Request $request, Order $order): OrderItemResource
    {
        $this->authorize('create', OrderItem::class);

        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'product_variant_id' => ['required', 'exists:product_variants,id'],
            'name' => ['required', 'max:255', 'string'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'total_price' => ['required', 'numeric'],
        ]);

        $orderItem = $order->orderItems()->create($validated);

        return new OrderItemResource($orderItem);
    }
}
