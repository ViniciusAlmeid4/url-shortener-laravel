# Laravel URL Shortener
A simple URL shortening app built with Laravel as a learning project to understand how the framework works.
# What it does

- Shortens long URLs into random 10-character codes
- Users can create accounts and manage their links
- Optional password protection for URLs
- Basic click tracking
- Delete your own shortened URLs

## What I learned
This project helped me understand Laravel's main features:

- **Models & Relationships**: Created User and ShortUrl models with a one-to-many relationship
- **Controllers**: Built RESTful controllers with validation and authentication
- **Database**: Used migrations and Eloquent ORM for database interactions
- **Blade Templates**: Created views for forms and displaying data
- **Authentication**: Laravel's built-in auth system for login/register
- **API Responses**: JSON responses for frontend interactions
- **Routing**: Web and API routes with proper HTTP methods

## Things I tried differently

- **Password protection**: Added optional passwords for sensitive links (with bcrypt hashing)
- **Owner bypass**: If you're logged in and own the URL, you skip the password prompt
- **Expiration ready**: Database structure supports URL expiration (not fully implemented yet)
- **Custom accessor**: Used Laravel accessors to automatically generate the full shortened URL
- **Smart queries**: URLs check if they're active and not expired before redirecting

## Setup

```
composer install
cp .env.example .env
# Configure your database in .env
php artisan key:generate
php artisan migrate
php artisan serve
```

## What I'd add next

- Actually implement the expiration functionality
- Better analytics beyond just click counts
- Custom short codes instead of just random ones
- Bulk URL management