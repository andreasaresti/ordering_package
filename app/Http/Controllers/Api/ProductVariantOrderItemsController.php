<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderItemResource;
use App\Http\Resources\OrderItemCollection;

class ProductVariantOrderItemsController extends Controller
{
    public function index(
        Request $request,
        ProductVariant $productVariant
    ): OrderItemCollection {
        $this->authorize('view', $productVariant);

        $search = $request->get('search', '');

        $orderItems = $productVariant
            ->orderItems()
            ->search($search)
            ->latest()
            ->paginate();

        return new OrderItemCollection($orderItems);
    }

    public function store(
        Request $request,
        ProductVariant $productVariant
    ): OrderItemResource {
        $this->authorize('create', OrderItem::class);

        $validated = $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
            'product_id' => ['required', 'exists:products,id'],
            'name' => ['required', 'max:255', 'string'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'total_price' => ['required', 'numeric'],
        ]);

        $orderItem = $productVariant->orderItems()->create($validated);

        return new OrderItemResource($orderItem);
    }
}
