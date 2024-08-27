<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ProductVariant;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductVariantControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_product_variants(): void
    {
        $productVariants = ProductVariant::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('product-variants.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.product_variants.index')
            ->assertViewHas('productVariants');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_product_variant(): void
    {
        $response = $this->get(route('product-variants.create'));

        $response->assertOk()->assertViewIs('app.product_variants.create');
    }

    /**
     * @test
     */
    public function it_stores_the_product_variant(): void
    {
        $data = ProductVariant::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('product-variants.store'), $data);

        $this->assertDatabaseHas('product_variants', $data);

        $productVariant = ProductVariant::latest('id')->first();

        $response->assertRedirect(
            route('product-variants.edit', $productVariant)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_product_variant(): void
    {
        $productVariant = ProductVariant::factory()->create();

        $response = $this->get(route('product-variants.show', $productVariant));

        $response
            ->assertOk()
            ->assertViewIs('app.product_variants.show')
            ->assertViewHas('productVariant');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_product_variant(): void
    {
        $productVariant = ProductVariant::factory()->create();

        $response = $this->get(route('product-variants.edit', $productVariant));

        $response
            ->assertOk()
            ->assertViewIs('app.product_variants.edit')
            ->assertViewHas('productVariant');
    }

    /**
     * @test
     */
    public function it_updates_the_product_variant(): void
    {
        $productVariant = ProductVariant::factory()->create();

        $data = [
            'color' => $this->faker->hexcolor(),
            'size' => $this->faker->randomFloat(2, 0, 9999),
            'price' => $this->faker->randomFloat(2, 0, 9999),
        ];

        $response = $this->put(
            route('product-variants.update', $productVariant),
            $data
        );

        $data['id'] = $productVariant->id;

        $this->assertDatabaseHas('product_variants', $data);

        $response->assertRedirect(
            route('product-variants.edit', $productVariant)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_product_variant(): void
    {
        $productVariant = ProductVariant::factory()->create();

        $response = $this->delete(
            route('product-variants.destroy', $productVariant)
        );

        $response->assertRedirect(route('product-variants.index'));

        $this->assertModelMissing($productVariant);
    }
}
