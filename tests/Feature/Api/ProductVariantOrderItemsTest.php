<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\OrderItem;
use App\Models\ProductVariant;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductVariantOrderItemsTest extends TestCase
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
    public function it_gets_product_variant_order_items(): void
    {
        $productVariant = ProductVariant::factory()->create();
        $orderItems = OrderItem::factory()
            ->count(2)
            ->create([
                'product_variant_id' => $productVariant->id,
            ]);

        $response = $this->getJson(
            route('api.product-variants.order-items.index', $productVariant)
        );

        $response->assertOk()->assertSee($orderItems[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_product_variant_order_items(): void
    {
        $productVariant = ProductVariant::factory()->create();
        $data = OrderItem::factory()
            ->make([
                'product_variant_id' => $productVariant->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.product-variants.order-items.store', $productVariant),
            $data
        );

        $this->assertDatabaseHas('order_items', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $orderItem = OrderItem::latest('id')->first();

        $this->assertEquals(
            $productVariant->id,
            $orderItem->product_variant_id
        );
    }
}
