<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderOrderItemsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_order_order_items(): void
    {
        $order = Order::factory()->create();
        $orderItems = OrderItem::factory()
            ->count(2)
            ->create([
                'order_id' => $order->id,
            ]);

        $response = $this->getJson(
            route('api.orders.order-items.index', $order)
        );

        $response->assertOk()->assertSee($orderItems[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_order_order_items(): void
    {
        $order = Order::factory()->create();
        $data = OrderItem::factory()
            ->make([
                'order_id' => $order->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.orders.order-items.store', $order),
            $data
        );

        $this->assertDatabaseHas('order_items', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $orderItem = OrderItem::latest('id')->first();

        $this->assertEquals($order->id, $orderItem->order_id);
    }
}
