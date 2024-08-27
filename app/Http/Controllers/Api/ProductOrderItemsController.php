<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderItemResource;
use App\Http\Resources\OrderItemCollection;

class ProductOrderItemsController extends Controller
{
    public function index(
        Request $request,
        Product $product
    ): OrderItemCollection {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $orderItems = $product
            ->orderItems()
            ->search($search)
            ->latest()
            ->paginate();

        return new OrderItemCollection($orderItems);
    }

    public function store(Request $request, Product $product): OrderItemResource
    {
        $this->authorize('create', OrderItem::class);

        $validated = $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
            'product_variant_id' => ['required', 'exists:product_variants,id'],
            'name' => ['required', 'max:255', 'string'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'total_price' => ['required', 'numeric'],
        ]);

        $orderItem = $product->orderItems()->create($validated);

        return new OrderItemResource($orderItem);
    }
}
