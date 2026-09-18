# Noliktava API

## Setup

1. cp .env.example .env
2. php artisan key:generate
3. php artisan migrate
4. php artisan db:seed --class=ProductSeeder
5. php artisan serve

## Testing

### 1. Register user

POST /api/register

Example body:

{
  "name": "Test User",
  "email": "test@example.com",
  "password": "Password123!",
  "password_confirmation": "Password123!"
}

Copy token.

### 2. Get products

GET /api/products

### 3. Create an order

POST /api/orders

Use token in header.

Example body:

{
  "products": [
    {
      "product_id": 1,
      "quantity": 2
    },
    {
      "product_id": 2,
      "quantity": 1
    }
  ]
}

### 4. Check the result

GET /api/products

or

GET /api/orders
