<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Create roles
        $this->createUsers();
        $this->createCategories();
        $this->createProducts();
    }

    private function createUsers(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@ecommerce.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
            'approved_at' => now(),
        ]);

        // Vendors
        $vendors = [
            ['Tech Store', 'vendor1@ecommerce.test'],
            ['Fashion Hub', 'vendor2@ecommerce.test'],
            ['Home Goods', 'vendor3@ecommerce.test'],
        ];

        foreach ($vendors as [$name, $email]) {
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'vendor',
                'is_active' => true,
                'approved_at' => now(),
            ]);
        }

        // Customers
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "Customer {$i}",
                'email' => "customer{$i}@ecommerce.test",
                'password' => Hash::make('password'),
                'role' => 'customer',
                'is_active' => true,
            ]);
        }
    }

    private function createCategories(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Latest electronic devices and gadgets',
                'meta_title' => 'Electronics - Best Prices',
                'meta_description' => 'Find the latest electronics at great prices',
                'image' => 'categories/electronics.jpg',
                'sort_order' => 1,
            ],
            [
                'name' => 'Fashion',
                'slug' => 'fashion',
                'description' => 'Trendy clothing and accessories',
                'meta_title' => 'Fashion - Latest Styles',
                'meta_description' => 'Discover the latest fashion trends',
                'image' => 'categories/fashion.jpg',
                'sort_order' => 2,
            ],
            [
                'name' => 'Home & Garden',
                'slug' => 'home-garden',
                'description' => 'Everything for your home and garden',
                'meta_title' => 'Home & Garden Supplies',
                'meta_description' => 'Quality products for your home and garden',
                'image' => 'categories/home.jpg',
                'sort_order' => 3,
            ],
            [
                'name' => 'Sports',
                'slug' => 'sports',
                'description' => 'Sports equipment and gear',
                'meta_title' => 'Sports Equipment',
                'meta_description' => 'Get the best sports gear and equipment',
                'image' => 'categories/sports.jpg',
                'sort_order' => 4,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Subcategories
        $electronics = Category::where('slug', 'electronics')->first();
        if ($electronics) {
            $subcategories = [
                ['Laptops', 'laptops', 'Computers and laptops for work and gaming'],
                ['Smartphones', 'smartphones', 'Latest mobile phones and smartphones'],
                ['Tablets', 'tablets', 'Tablets for work and entertainment'],
            ];

            foreach ($subcategories as [$name, $slug, $description]) {
                Category::create([
                    'name' => $name,
                    'slug' => $slug,
                    'description' => $description,
                    'parent_id' => $electronics->id,
                    'is_active' => true,
                ]);
            }
        }
    }

    private function createProducts(): void
    {
        $vendors = User::where('role', 'vendor')->get();
        $categories = Category::whereNull('parent_id')->get();

        foreach ($vendors as $vendor) {
            foreach ($categories as $category) {
                for ($i = 1; $i <= 3; $i++) {
                    $product = Product::create([
                        'name' => "{$category->name} Product {$i} by {$vendor->name}",
                        'slug' => Str::slug("{$category->name}-product-{$i}-by-" . Str::slug($vendor->name)),
                        'description' => "High-quality {$category->name} product from {$vendor->name}. Perfect for everyday use with premium features.",
                        'price' => rand(1999, 19999) / 100, // $19.99 - $199.99
                        'discount_price' => rand(0, 3) ? rand(1000, 15000) / 100 : null, // Random discount
                        'stock' => rand(10, 100),
                        'rating' => rand(30, 50) / 10, // 3.0 - 5.0 rating
                        'rating_count' => rand(5, 100),
                        'sales' => rand(0, 50),
                        'views' => rand(10, 500),
                        'category_id' => $category->id,
                        'vendor_id' => $vendor->id,
                        'is_active' => true,
                        'is_approved' => true,
                    ]);

                    // Add mock images
                    $images = [];
                    for ($j = 1; $j <= 3; $j++) {
                        $images[] = "products/product-{$product->id}-{$j}.jpg";
                    }
                    $product->images = $images;
                    $product->save();
                }
            }
        }
    }
}