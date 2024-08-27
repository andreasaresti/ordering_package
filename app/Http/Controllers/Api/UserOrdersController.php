<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderCollection;

class UserOrdersController extends Controller
{
    public function index(Request $request, User $user): OrderCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $orders = $user
            ->orders()
            ->search($search)
            ->latest()
            ->paginate();

        return new OrderCollection($orders);
    }

    public function store(Request $request, User $user): OrderResource
    {
        $this->authorize('create', Order::class);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'subtotal_amount' => ['required', 'numeric'],
            'shipping_amount' => ['required', 'numeric'],
            'discount' => ['required', 'numeric'],
            'total_amount' => ['required', 'numeric'],
        ]);

        $order = $user->orders()->create($validated);

        return new OrderResource($order);
    }
}
