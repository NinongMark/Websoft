<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 's.gonzales.kianmark@cmu.edu.ph',
            'role' => 'admin',
            'password' => Hash::make('123'),
        ]);
        $admin->enableTwoFactor();

        // Create customer users
        $customers = User::factory(10)->create(['role' => 'customer']);

        // Create categories
        $categories = Category::factory(8)->create();

        // Create books for each category
        foreach ($categories as $category) {
            Book::factory(5)->create(['category_id' => $category->id]);
        }

        // Create reviews
        $books = Book::all();

        foreach ($customers as $customer) {
            // Each customer reviews 3-5 random books
            $randomBooks = $books->random(rand(3, 5));
            
            foreach ($randomBooks as $book) {
                Review::factory()->create([
                    'user_id' => $customer->id,
                    'book_id' => $book->id,
                ]);
            }
        }
    }
}

