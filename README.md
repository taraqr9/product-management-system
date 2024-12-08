## Product Purchase System API

This project provides a RESTful API for user authentication, product management, order management, and payment
processing using Laravel. The system integrates with Stripe for handling payments.

## Prerequisites

- **PHP**: 8.x or higher
- **Composer**
- **MySQL** (or any compatible database)
- **Stripe account** (for secret keys)

## Installation Steps

- git clone <repository-url>
- composer install
- cp .env.example .env
- Configure the DB and STRIPE_SECRET
- php artisan migrate --seed

After running the migrations, the following user will be generated automatically:

```json

"email": "admin@admin.com",
"password": "123456"

  ```

## API Endpoints

### Authentication

#### Register

- **Endpoint**: `/register`
- **Method**: POST
- **Request Body**:

```json
  {
    "name": "string",
    "email": "string",
    "password": "string",
    "password_confirmation": "string"
}
  ```

### Authentication

#### Login

- **Endpoint**: `/login`
- **Method**: POST
- **Request Body**:

  ```json
  {
      "email": "string",
      "password": "string"
  }
  ```

## User Management (Requires Authentication)

### Create User

- **Endpoint**: `/user/store`
- **Method**: POST
- **Request Body**:

  ```json
  {
      "name": "string",
      "email": "string",
      "password": "string",
      "role": "string (e.g., admin or viewer)"
  }
  ```

## User Management (Requires Authentication)

### Delete User

- **Endpoint**: `/user/delete/{id}`
- **Method**: DELETE
- **Response**:
    - **200 OK**: User deleted successfully.
- ## Product Management (Requires Authentication)

### List Products

- **Endpoint**: `/products`
- **Method**: GET
- **Response**:
    - **200 OK**: Returns a list of all products.

### Create Product

- **Endpoint**: `/products`
- **Method**: POST
- **Request Body**:

  ```json
  {
      "name": "string",
      "price": "numeric",
      "stock": "integer"
  }
    ```

### Update Product

- **Endpoint**: `/products/{id}`
- **Method**: PUT
- **Request Body**:

  ```json
  {
      "name": "string",
      "price": "numeric",
      "stock": "integer"
  }
    ```

### Delete Product

- **Endpoint**: `/products/{id}`
- **Method**: DELETE
- **Response**:
    - **200 OK**: Product deleted successfully.

## Order Management (Requires Authentication)

### Place an Order

- **Endpoint**: `/orders`
- **Method**: POST
- **Request Body**:

  ```json
  {
      "product_id": "integer",
      "quantity": "integer"
  }
  ```

## Payment Processing (Requires Authentication)

### Process a Payment

- **Endpoint**: `/payments`
- **Method**: POST
- **Request Body**:

  ```json
  {
      "token": "string (Stripe payment token)",
      "product_name": "string",
      "amount": "numeric"
  }
  ```

## Logout (Requires Authentication)

### Logout User

- **Endpoint**: `/logout`
- **Method**: POST
- **Response**:
    - **200 OK**: Logout successful.

## Journey (Example Flow)

1. **User Registration**:  
   Hit `/register` to register a user.

2. **Login**:  
   Authenticate with `/login` to get a token.

3. **Manage Users (Admin Role Only)**:  
   Use `/user/store` to create users or `/user/delete/{id}` to delete.

4. **Manage Products (Admin Role Only)**:  
   List, create, update, and delete products using `/products` endpoints.

5. **Place Orders**:  
   Place an order via `/orders`.

6. **Process Payments**:  
   Make a payment using `/payments`.

7. **Logout**:  
   Log out of the system with `/logout`.

## Notes

### Roles:

- **Admin**: Full access to create, update, delete, and view products and users.
- **Viewer**: Can only view products and cannot place orders or manage users.

### Payment:

Ensure you configure your Stripe secret in `.env` for payment processing.

