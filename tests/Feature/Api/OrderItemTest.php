<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\OrderItem;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderItemTest extends TestCase
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
    public function it_gets_order_items_list(): void
    {
        $orderItems = OrderItem::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.order-items.index'));

        $response->assertOk()->assertSee($orderItems[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_order_item(): void
    {
        $data = OrderItem::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.order-items.store'), $data);

        $this->assertDatabaseHas('order_items', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_order_item(): void
    {
        $orderItem = OrderItem::factory()->create();

        $order = Order::factory()->create();
        $product = Product::factory()->create();
        $productVariant = ProductVariant::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'quantity' => $this->faker->randomNumber(),
            'total_price' => $this->faker->randomNumber(1),
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_variant_id' => $productVariant->id,
        ];

        $response = $this->putJson(
            route('api.order-items.update', $orderItem),
            $data
        );

        $data['id'] = $orderItem->id;

        $this->assertDatabaseHas('order_items', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_order_item(): void
    {
        $orderItem = OrderItem::factory()->create();

        $response = $this->deleteJson(
            route('api.order-items.destroy', $orderItem)
        );

        $this->assertModelMissing($orderItem);

        $response->assertNoContent();
    }
}
