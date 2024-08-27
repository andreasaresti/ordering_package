<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\OrderItem;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductOrderItemsTest extends TestCase
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
    public function it_gets_product_order_items(): void
    {
        $product = Product::factory()->create();
        $orderItems = OrderItem::factory()
            ->count(2)
            ->create([
                'product_id' => $product->id,
            ]);

        $response = $this->getJson(
            route('api.products.order-items.index', $product)
        );

        $response->assertOk()->assertSee($orderItems[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_product_order_items(): void
    {
        $product = Product::factory()->create();
        $data = OrderItem::factory()
            ->make([
                'product_id' => $product->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.products.order-items.store', $product),
            $data
        );

        $this->assertDatabaseHas('order_items', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $orderItem = OrderItem::latest('id')->first();

        $this->assertEquals($product->id, $orderItem->product_id);
    }
}
