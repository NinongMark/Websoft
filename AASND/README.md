# PageTurner Online Bookstore

A Laravel-based online bookstore management system built for Laboratory Activity 3 of ITSD 82 Web Software Tools.

## Features

- **User Authentication** - Registration, login, and profile management via Laravel Breeze
- **Role-based Access Control** - Admin and Customer roles
- **Category Management** - CRUD operations for book categories
- **Book Management** - Full CRUD for books with category assignment
- **Order Management** - Customers can place orders, Admins can view and manage orders
- **Review System** - Authenticated customers can write reviews for books

## Installation

1. **Clone the repository**
   ```bash
   cd pageturner-bookstore
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Configure environment**
   - Copy `.env.example` to `.env`
   - Update database credentials in `.env`
   - Generate application key:
   ```bash
   php artisan key:generate
   ```

4. **Run migrations and seed**
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Install Laravel Breeze (if not already installed)**
   ```bash
   composer require laravel/breeze --dev
   php artisan breeze:install blade
   npm install && npm run build
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

## Test Accounts

After seeding, the following accounts are available:

- **Admin Account**
  - Email: admin@pageturner.com
  - Password: password

- **Customer Accounts**
  - Email: customer1@example.com (and similar pattern up to customer10)
  - Password: password

## Routes

| Method | URI | Description |
|--------|-----|-------------|
| GET | / | Homepage with featured books |
| GET | /books | Browse all books |
| GET | /books/{book} | View book details |
| GET | /categories | Browse categories |
| GET | /categories/{category} | View category with books |
| POST | /books/{book}/reviews | Submit a review |
| POST | /orders | Place an order |
| GET | /orders | View user's orders |

### Admin Routes (prefix: /admin)

| Method | URI | Description |
|--------|-----|-------------|
| GET | /books/create | Create new book |
| POST | /books | Store new book |
| GET | /books/{book}/edit | Edit book |
| PUT | /books/{book} | Update book |
| DELETE | /books/{book} | Delete book |
| GET | /categories/create | Create category |
| POST | /categories | Store category |
| GET | /categories/{category}/edit | Edit category |
| PUT | /categories/{category} | Update category |
| DELETE | /categories/{category} | Delete category |
| PATCH | /orders/{order}/status | Update order status |

## Database Schema

- **users** - User accounts (id, name, email, password, role)
- **categories** - Book categories (id, name, description)
- **books** - Book inventory (id, category_id, title, author, isbn, price, stock_quantity, description, cover_image)
- **orders** - Customer orders (id, user_id, total_amount, status)
- **order_items** - Individual items in orders (id, order_id, book_id, quantity, unit_price)
- **reviews** - Customer book reviews (id, user_id, book_id, rating, comment)

## Tech Stack

- Laravel 12.x
- PHP 8.2+
- MySQL/SQLite
- Blade Templates
- Laravel Breeze for Authentication

## License

This project is for educational purposes.

