<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\OrderItemStoreRequest;
use App\Http\Requests\OrderItemUpdateRequest;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', OrderItem::class);

        $search = $request->get('search', '');

        $orderItems = OrderItem::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.order_items.index', compact('orderItems', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', OrderItem::class);

        $orders = Order::pluck('date', 'id');
        $products = Product::pluck('name', 'id');
        $productVariants = ProductVariant::pluck('color', 'id');

        return view(
            'app.order_items.create',
            compact('orders', 'products', 'productVariants')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderItemStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', OrderItem::class);

        $validated = $request->validated();

        $orderItem = OrderItem::create($validated);

        return redirect()
            ->route('order-items.edit', $orderItem)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, OrderItem $orderItem): View
    {
        $this->authorize('view', $orderItem);

        return view('app.order_items.show', compact('orderItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, OrderItem $orderItem): View
    {
        $this->authorize('update', $orderItem);

        $orders = Order::pluck('date', 'id');
        $products = Product::pluck('name', 'id');
        $productVariants = ProductVariant::pluck('color', 'id');

        return view(
            'app.order_items.edit',
            compact('orderItem', 'orders', 'products', 'productVariants')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        OrderItemUpdateRequest $request,
        OrderItem $orderItem
    ): RedirectResponse {
        $this->authorize('update', $orderItem);

        $validated = $request->validated();

        $orderItem->update($validated);

        return redirect()
            ->route('order-items.edit', $orderItem)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        OrderItem $orderItem
    ): RedirectResponse {
        $this->authorize('delete', $orderItem);

        $orderItem->delete();

        return redirect()
            ->route('order-items.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
