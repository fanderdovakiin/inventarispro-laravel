<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_master_data_creation_pages(): void
    {
        $admin = $this->createTestUser('admin-test', 'admin');

        $this->actingAs($admin);

        $this->get(route('products.create'))->assertOk();
        $this->get(route('categories.create'))->assertOk();
        $this->get(route('suppliers.create'))->assertOk();
    }

    public function test_staff_cannot_open_master_data_creation_pages(): void
    {
        $staff = $this->createTestUser('staff-test', 'staff');

        $this->actingAs($staff);

        $this->get(route('products.create'))->assertForbidden();
        $this->get(route('categories.create'))->assertForbidden();
        $this->get(route('suppliers.create'))->assertForbidden();
    }

    public function test_staff_can_open_stock_operation_pages(): void
    {
        $staff = $this->createTestUser('staff-operations', 'staff');

        $this->actingAs($staff);

        $this->get(route('stock.in.create'))->assertOk();
        $this->get(route('stock.out.create'))->assertOk();
        $this->get(route('stock.history'))->assertOk();
    }

    private function createTestUser(string $username, string $role): User
    {
        return User::query()->create([
            'username' => $username,
            'password_hash' => 'password-test-123',
            'full_name' => ucfirst($username),
            'role' => $role,
        ]);
    }
}