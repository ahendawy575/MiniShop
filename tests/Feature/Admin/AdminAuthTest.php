<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_products_requires_basic_authentication(): void
    {
        config([
            'admin.username' => 'shop-admin',
            'admin.password' => 'secret-password',
        ]);

        $this->get('/admin/products')
            ->assertUnauthorized()
            ->assertHeader('WWW-Authenticate', 'Basic realm="Admin Area"');
    }

    public function test_admin_products_is_available_with_valid_basic_credentials(): void
    {
        config([
            'admin.username' => 'shop-admin',
            'admin.password' => 'secret-password',
        ]);

        $this->withBasicAuth('shop-admin', 'secret-password')
            ->get('/admin/products')
            ->assertOk()
            ->assertSee('Products');
    }
}
