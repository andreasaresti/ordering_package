<?php

namespace App\Http\Controllers\Api;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderItemResource;
use App\Http\Resources\OrderItemCollection;
use App\Http\Requests\OrderItemStoreRequest;
use App\Http\Requests\OrderItemUpdateRequest;

class OrderItemController extends Controller
{
    public function index(Request $request): OrderItemCollection
    {
        $this->authorize('view-any', OrderItem::class);

        $search = $request->get('search', '');

        $orderItems = OrderItem::search($search)
            ->latest()
            ->paginate();

        return new OrderItemCollection($orderItems);
    }

    public function store(OrderItemStoreRequest $request): OrderItemResource
    {
        $this->authorize('create', OrderItem::class);

        $validated = $request->validated();

        $orderItem = OrderItem::create($validated);

        return new OrderItemResource($orderItem);
    }

    public function show(
        Request $request,
        OrderItem $orderItem
    ): OrderItemResource {
        $this->authorize('view', $orderItem);

        return new OrderItemResource($orderItem);
    }

    public function update(
        OrderItemUpdateRequest $request,
        OrderItem $orderItem
    ): OrderItemResource {
        $this->authorize('update', $orderItem);

        $validated = $request->validated();

        $orderItem->update($validated);

        return new OrderItemResource($orderItem);
    }

    public function destroy(Request $request, OrderItem $orderItem): Response
    {
        $this->authorize('delete', $orderItem);

        $orderItem->delete();

        return response()->noContent();
    }
}
