<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ProductVariant;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductVariantTest extends TestCase
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
    public function it_gets_product_variants_list(): void
    {
        $productVariants = ProductVariant::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.product-variants.index'));

        $response->assertOk()->assertSee($productVariants[0]->colour);
    }

    /**
     * @test
     */
    public function it_stores_the_product_variant(): void
    {
        $data = ProductVariant::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.product-variants.store'), $data);

        $this->assertDatabaseHas('product_variants', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_product_variant(): void
    {
        $productVariant = ProductVariant::factory()->create();

        $data = [
            'colour' => $this->faker->hexcolor(),
            'size' => $this->faker->randomFloat(2, 0, 9999),
            'price' => $this->faker->randomFloat(2, 0, 9999),
        ];

        $response = $this->putJson(
            route('api.product-variants.update', $productVariant),
            $data
        );

        $data['id'] = $productVariant->id;

        $this->assertDatabaseHas('product_variants', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_product_variant(): void
    {
        $productVariant = ProductVariant::factory()->create();

        $response = $this->deleteJson(
            route('api.product-variants.destroy', $productVariant)
        );

        $this->assertModelMissing($productVariant);

        $response->assertNoContent();
    }
}
