# Qoutiverse

Qoutiverse is a cozy quote journal built with Laravel 12, Blade, Bootstrap 5, and Eloquent. It lets you collect quotes, organize them into categories, mark favorites, and find them with search and category filters. No account or authentication setup is required.

## Requirements

- PHP 8.2 or newer with the PDO MySQL extension (for MySQL) or PDO SQLite (for SQLite)
- Composer
- MySQL 8+ (or MariaDB) for the recommended setup

Bootstrap is loaded from jsDelivr; the app's custom styles are in `public/css/quotiverse.css`.

## Set up the project

1. Install PHP dependencies and create your environment file:

   ```powershell
   composer install
   Copy-Item .env.example .env
   php artisan key:generate
   ```

2. Create a database in MySQL, for example:

   ```sql
   CREATE DATABASE quotiverse CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

3. Edit `.env` and set your database connection details:

   ```dotenv
   APP_NAME=Qoutiverse
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=quotiverse
   DB_USERNAME=root
   DB_PASSWORD=your_mysql_password
   ```

   Replace the username and password with the credentials for your local MySQL installation. Alternatively, keep `DB_CONNECTION=sqlite` to use the included `database/database.sqlite` file.

4. Create the tables and start Laravel:

   ```powershell
   php artisan migrate
   php artisan serve
   ```

5. Visit <http://127.0.0.1:8000>.

## Using Qoutiverse

- The **Dashboard** welcomes you to Qoutiverse, shows quote, favorite, and category totals, and lists the five most recently added quotes.
- **All quotes** lists quote cards. Search matches quote text and author; the category selector narrows the results.
- Use the heart on a quote card or detail page to add or remove a favorite. The dashboard favorite total links to the favorites filter.
- Use **Add a quote** to save text and an author. Category is optional, so quotes can be saved before any categories exist.
- The **Categories** page lets you add, rename, and delete categories. Deleting a category keeps its quotes and makes them uncategorized.
- Delete buttons ask for confirmation before submitting.

## Project files

- `routes/web.php` maps the dashboard and the quote/category resource routes.
- `app/Http/Controllers/DashboardController.php` provides dashboard totals and recent quotes.
- `app/Http/Controllers/QuoteController.php` validates and handles quote CRUD, search, and category filtering.
- `app/Http/Controllers/CategoryController.php` validates and handles category CRUD.
- `app/Models/Quote.php` and `app/Models/Category.php` define the fillable fields and Eloquent relationship.
- `database/migrations/*_create_categories_table.php` and `*_create_quotes_table.php` create the tables and one-to-many foreign key.
- `resources/views/layouts/app.blade.php` provides the shared sidebar, navigation, alerts, and Bootstrap includes.
- `resources/views/dashboard.blade.php`, `resources/views/quotes/`, and `resources/views/categories/` contain the pages and shared form partials.
- `public/css/quotiverse.css` defines the responsive layout and Qoutiverse color palette.
- `tests/Feature/QuotiverseTest.php` covers the primary CRUD, filtering, validation, favorites, and relationship behavior.

## Tests

Run the feature tests with:

```powershell
php artisan test
```

The test environment uses an in-memory SQLite database and does not change your local MySQL data.
