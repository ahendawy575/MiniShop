<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'admin.username' => 'shop-admin',
            'admin.password' => 'secret-password',
        ]);

        $this->withBasicAuth('shop-admin', 'secret-password');
    }

    public function test_admin_can_create_update_and_delete_a_product(): void
    {
        Storage::fake('public');

        $category = Category::create([
            'name' => 'Lighting',
            'slug' => 'lighting',
        ]);

        $this->post(route('admin.products.store'), [
            'name' => 'Desk Lamp',
            'description' => 'A compact lamp.',
            'price' => 34.50,
            'stock' => 8,
            'category_id' => $category->id,
            'image' => $this->fakeProductImage(),
        ])->assertRedirect(route('admin.products.index'));

        $product = Product::query()->firstOrFail();
        $this->assertSame('desk-lamp', $product->slug);
        $this->assertStringStartsWith('products/', $product->image);
        Storage::disk('public')->assertExists($product->image);
        $originalImage = $product->image;
        $this->get(route('admin.products.edit', $product))->assertOk()->assertSee('Desk Lamp');

        $this->put(route('admin.products.update', $product), [
            'name' => 'Reading Lamp',
            'description' => 'An updated lamp.',
            'price' => 39.99,
            'stock' => 5,
            'category_id' => $category->id,
            'image' => $this->fakeProductImage(),
        ])->assertRedirect(route('admin.products.index'));

        $product->refresh();
        $this->assertNotSame($originalImage, $product->image);
        Storage::disk('public')->assertMissing($originalImage);
        Storage::disk('public')->assertExists($product->image);
        $replacementImage = $product->image;

        $this->put(route('admin.products.update', $product), [
            'name' => 'Reading Lamp',
            'description' => 'An updated lamp.',
            'price' => 39.99,
            'stock' => 5,
            'category_id' => $category->id,
        ])->assertRedirect(route('admin.products.index'));

        $product->refresh();
        $this->assertSame($replacementImage, $product->image);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Reading Lamp',
            'slug' => 'reading-lamp',
            'price' => 39.99,
            'stock' => 5,
        ]);

        $this->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_admin_must_upload_an_image_when_creating_a_product(): void
    {
        $category = Category::create([
            'name' => 'Lighting',
            'slug' => 'lighting',
        ]);

        $this->post(route('admin.products.store'), [
            'name' => 'Desk Lamp',
            'description' => 'A compact lamp.',
            'price' => 34.50,
            'stock' => 8,
            'category_id' => $category->id,
        ])->assertSessionHasErrors('image');
    }

    private function fakeProductImage(): UploadedFile
    {
        $image = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAADUlEQVR4nGP4z8AAAAMBAQDJ/pLvAAAAAElFTkSuQmCC');

        return UploadedFile::fake()->createWithContent('product.png', $image);
    }

    public function test_admin_can_manage_categories_and_cannot_delete_a_category_with_products(): void
    {
        $this->post(route('admin.categories.store'), ['name' => 'Lighting'])
            ->assertRedirect(route('admin.categories.index'));

        $category = Category::query()->firstOrFail();
        $this->assertSame('lighting', $category->slug);
        $this->get(route('admin.categories.edit', $category))->assertOk()->assertSee('Lighting');

        $this->put(route('admin.categories.update', $category), ['name' => 'Home lighting'])
            ->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Home lighting',
            'slug' => 'home-lighting',
        ]);

        Product::create([
            'category_id' => $category->id,
            'name' => 'Reading Lamp',
            'slug' => 'reading-lamp',
            'price' => 39.99,
            'stock' => 5,
        ]);

        $this->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('error');
        $this->assertDatabaseHas('categories', ['id' => $category->id]);

        $category->products()->delete();
        $this->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
