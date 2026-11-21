<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CashierCheckoutReceiptTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_checkout_opens_printable_receipt_and_clears_cart(): void
    {
        $cashier = User::factory()->create(['role' => 'user']);
        $product = Product::factory()->create([
            'name' => 'Beras Premium',
            'price_sell' => 20000,
            'stock' => 5,
        ]);

        $response = $this->actingAs($cashier)
            ->withSession([
                'cart' => [
                    $product->id => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => 20000,
                        'qty' => 2,
                    ],
                ],
            ])
            ->post(route('checkout'), [
                'payment_method' => 'Tunai',
                'money_paid' => 50000,
            ]);

        $order = Order::firstOrFail();
        $response->assertRedirect(route('receipt', $order));
        $this->assertFalse(session()->has('cart'));
        $this->assertSame(3, $product->fresh()->stock);

        $this->get(route('receipt', $order))
            ->assertOk()
            ->assertSee('Pembayaran berhasil')
            ->assertSee('Beras Premium')
            ->assertSee('Rp 40,000')
            ->assertSee('Rp 50,000')
            ->assertSee('Rp 10,000')
            ->assertSee('Cetak ulang struk')
            ->assertSee('window.print()', false);
    }

    public function test_cashier_cannot_view_another_cashiers_receipt(): void
    {
        $owner = User::factory()->create(['role' => 'user']);
        $otherCashier = User::factory()->create(['role' => 'user']);
        $order = Order::create([
            'user_id' => $owner->id,
            'invoice_number' => 'INV-RECEIPT-001',
            'payment_method' => 'Tunai',
            'total_items' => 1,
            'total_price' => 10000,
            'money_received' => 10000,
            'money_change' => 0,
        ]);

        $this->actingAs($otherCashier)
            ->get(route('receipt', $order))
            ->assertForbidden();
    }
}
