# Project Setup

## Prerequisites

Before you begin, ensure you have the following installed:

- **Node.js** version 18.x
- **PHP** version 8.1
- **Composer** (Dependency Manager for PHP)

## Setup Instructions

```bash
git clone https://your-repository-link.git
cd your-repository-name
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan passport:install
php artisan passport:client --personal
php artisan optimize
php artisan migrate
php artisan db:seed
php artisan serve
npm run dev
```

## Admin Credential
Email: admin@test.com
Password: 123123    

