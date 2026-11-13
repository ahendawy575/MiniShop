# MiniShop - Full-Stack E-Commerce Platform

MiniShop is a complete Laravel-based e-commerce platform with a customer storefront and an admin panel. Customers can browse products, manage a session-based cart, and place orders, while administrators manage the store from a dedicated dashboard.

## Features

### Customer Storefront

- Browse products and explore product categories.
- Add products to a session-based shopping cart.
- Complete checkout with validated customer details.
- View an order confirmation after checkout.

### Admin Panel

- View dashboard analytics.
- Create, update, and delete products, including product image uploads.
- Create, update, and delete categories.
- Review orders and update their statuses.
- Protect admin routes with HTTP Basic Authentication.

### Security and Testing

- CSRF protection for state-changing requests.
- Server-side input validation for forms and checkout.
- PHPUnit automated tests covering key customer and admin flows.

## Tech Stack

- **Framework:** Laravel 13
- **Language:** PHP 8.5
- **Database:** SQLite
- **Styling:** Tailwind CSS

## Installation

### Requirements

- PHP 8.5
- Composer
- Node.js and npm

### Setup

1. Clone the repository and enter the project directory:

   ```bash
   git clone <repository-url>
   cd MiniShop
   ```

2. Install PHP dependencies and create your environment file:

   ```bash
   composer install
   cp .env.example .env
   ```

3. Configure the application in `.env`. Set `ADMIN_USERNAME` and `ADMIN_PASSWORD` to the credentials you want to use for the admin panel. The example environment is configured to use SQLite.

   If `database/database.sqlite` does not exist, create it before migrating:

   ```bash
   php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
   ```

4. Generate the application key, run migrations and seed the database, and create the public storage link:

   ```bash
   php artisan key:generate
   php artisan migrate --seed
   php artisan storage:link
   ```

5. Install frontend dependencies and build the assets:

   ```bash
   npm install
   npm run build
   ```

6. Start the development server:

   ```bash
   php artisan serve
   ```

   Open the local URL shown in the terminal to use the storefront. Admin pages require the Basic Auth credentials configured in `.env`.

## Running Tests

Run the PHPUnit test suite with:

```bash
php artisan test
```

## Screenshots

Add project screenshots to this section when available.

### Customer Storefront

> Screenshot placeholder - add the storefront image here.

### Admin Dashboard

> Screenshot placeholder - add the admin dashboard image here.

### Shopping Cart and Checkout

> Screenshot placeholder - add the cart or checkout image here.

## License

This project is licensed under the MIT License.
