<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Order;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
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
    public function it_gets_orders_list(): void
    {
        $orders = Order::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.orders.index'));

        $response->assertOk()->assertSee($orders[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_order(): void
    {
        $data = Order::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.orders.store'), $data);

        $this->assertDatabaseHas('orders', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_order(): void
    {
        $order = Order::factory()->create();

        $user = User::factory()->create();

        $data = [
            'date' => $this->faker->date(),
            'subtotal_amount' => $this->faker->randomNumber(1),
            'shipping_amount' => $this->faker->randomNumber(1),
            'discount' => $this->faker->randomFloat(2, 0, 9999),
            'total_amount' => $this->faker->randomNumber(1),
            'user_id' => $user->id,
        ];

        $response = $this->putJson(route('api.orders.update', $order), $data);

        $data['id'] = $order->id;

        $this->assertDatabaseHas('orders', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_order(): void
    {
        $order = Order::factory()->create();

        $response = $this->deleteJson(route('api.orders.destroy', $order));

        $this->assertModelMissing($order);

        $response->assertNoContent();
    }
}
