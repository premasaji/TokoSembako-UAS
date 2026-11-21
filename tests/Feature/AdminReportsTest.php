<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminReportsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_daily_and_monthly_sales_summaries(): void
    {
        $this->travelTo(now()->setDate(2026, 10, 21)->setTime(12, 0));
        $admin = User::factory()->create(['role' => 'admin']);

        $this->createOrder($admin, 'INV-001', 2, 100000, now());
        $this->createOrder($admin, 'INV-002', 3, 50000, now()->subDay());
        $this->createOrder($admin, 'INV-003', 1, 25000, now()->subMonth());

        $response = $this->actingAs($admin)->get(route('admin.reports'));

        $response->assertOk()
            ->assertSee('Laporan Harian')
            ->assertSee('Laporan Bulanan')
            ->assertSee('Rp 100,000')
            ->assertSee('Rp 150,000')
            ->assertSee('Cetak Laporan Harian')
            ->assertSee('Cetak Laporan Bulanan')
            ->assertSee("printReport('daily')", false)
            ->assertSee("printReport('monthly')", false);
    }

    private function createOrder(User $user, string $invoice, int $items, int $price, Carbon $createdAt): void
    {
        $order = Order::create([
            'user_id' => $user->id,
            'invoice_number' => $invoice,
            'payment_method' => 'Tunai',
            'total_items' => $items,
            'total_price' => $price,
            'money_received' => $price,
            'money_change' => 0,
        ]);

        $order->forceFill([
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ])->save();
    }
}
