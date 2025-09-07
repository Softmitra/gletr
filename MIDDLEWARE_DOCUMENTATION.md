# Gletr Jewellery Marketplace - Middleware Documentation

## Overview
This document outlines the role-based middleware system implemented for both web and API routes in the Gletr Jewellery Marketplace.

## Middleware Classes

### 1. AdminMiddleware
- **Purpose**: Restricts access to admin-only areas
- **Location**: `app/Http/Middleware/AdminMiddleware.php`
- **Requirements**: User must be authenticated and have 'admin' role
- **Usage**: `Route::middleware('admin')`

### 2. SellerMiddleware
- **Purpose**: Restricts access to seller areas
- **Location**: `app/Http/Middleware/SellerMiddleware.php`
- **Requirements**: User must be authenticated and have 'seller' or 'admin' role
- **Usage**: `Route::middleware('seller')`

### 3. CustomerMiddleware
- **Purpose**: Restricts access to customer areas
- **Location**: `app/Http/Middleware/CustomerMiddleware.php`
- **Requirements**: User must be authenticated and have 'customer', 'seller', or 'admin' role
- **Usage**: `Route::middleware('customer')`

### 4. RoleMiddleware (Flexible)
- **Purpose**: Flexible role checking with multiple roles support
- **Location**: `app/Http/Middleware/RoleMiddleware.php`
- **Requirements**: User must be authenticated and have any of the specified roles
- **Usage**: `Route::middleware('role:admin,seller')`

## Role Hierarchy

```
Admin (Highest Access)
├── Can access all admin areas
├── Can access all seller areas
└── Can access all customer areas

Seller (Medium Access)
├── Can access seller areas
└── Can access customer areas

Customer (Basic Access)
└── Can access customer areas only
```

## Response Handling

### Web Requests
- **Unauthorized (401)**: Redirects to login page
- **Forbidden (403)**: Shows 403 error page with role requirement message

### API Requests
- **Unauthorized (401)**: Returns JSON with authentication required message
- **Forbidden (403)**: Returns JSON with role requirement details

## Route Structure

### Web Routes

#### Admin Routes (`/admin/*`)
```php
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminDashboardController::class, 'users'])->name('users.index');
    Route::get('/sellers', [AdminDashboardController::class, 'sellers'])->name('sellers.index');
    Route::get('/products', [AdminDashboardController::class, 'products'])->name('products.index');
    // ... more admin routes
});
```

#### Seller Routes (`/seller/*`)
```php
Route::middleware(['auth', 'seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/', [SellerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/products', [SellerDashboardController::class, 'products'])->name('products.index');
    Route::get('/orders', [SellerDashboardController::class, 'orders'])->name('orders.index');
    // ... more seller routes
});
```

#### Customer Routes (`/customer/*`)
```php
Route::middleware(['auth', 'customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/', [CustomerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [CustomerDashboardController::class, 'orders'])->name('orders.index');
    Route::get('/reviews', [CustomerDashboardController::class, 'reviews'])->name('reviews.index');
    // ... more customer routes
});
```

### API Routes

#### Public API Routes
```php
// No middleware required
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
```

#### Authenticated API Routes
```php
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/categories', function () { /* ... */ });
    Route::get('/products', function () { /* ... */ });
});
```

#### Role-Specific API Routes
```php
// Customer API
Route::middleware(['auth:sanctum', 'customer'])->prefix('api/customer')->group(function () {
    Route::get('/orders', function () { /* ... */ });
    Route::get('/reviews', function () { /* ... */ });
});

// Seller API
Route::middleware(['auth:sanctum', 'seller'])->prefix('api/seller')->group(function () {
    Route::get('/products', function () { /* ... */ });
    Route::get('/orders', function () { /* ... */ });
});

// Admin API
Route::middleware(['auth:sanctum', 'admin'])->prefix('api/admin')->group(function () {
    Route::get('/users', function () { /* ... */ });
    Route::get('/sellers', function () { /* ... */ });
});
```

## Usage Examples

### Web Application

#### Protecting Admin Routes
```php
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
});
```

#### Protecting Seller Routes
```php
Route::middleware(['auth', 'seller'])->group(function () {
    Route::get('/seller/products', [SellerController::class, 'products']);
});
```

#### Using Flexible Role Middleware
```php
Route::middleware(['auth', 'role:admin,seller'])->group(function () {
    Route::get('/management/analytics', [AnalyticsController::class, 'index']);
});
```

### API Application

#### Protecting API Endpoints
```php
// Only admins can access
Route::middleware(['auth:sanctum', 'admin'])->get('/api/admin/stats', function () {
    return ['users' => User::count(), 'orders' => Order::count()];
});

// Sellers and admins can access
Route::middleware(['auth:sanctum', 'seller'])->get('/api/seller/dashboard', function () {
    return ['products' => Product::where('seller_id', auth()->user()->seller->id)->count()];
});
```

## Error Responses

### Web Error Responses

#### Unauthorized (Not Logged In)
- **Action**: Redirect to login page
- **URL**: `/login`
- **Message**: None (handled by redirect)

#### Forbidden (Wrong Role)
- **Action**: Show 403 error page
- **Message**: "Admin access required" / "Seller access required" / etc.

### API Error Responses

#### Unauthorized (401)
```json
{
    "message": "Authentication required",
    "error": "Unauthorized"
}
```

#### Forbidden (403)
```json
{
    "message": "Admin access required",
    "error": "Forbidden"
}
```

#### Flexible Role Forbidden (403)
```json
{
    "message": "Access denied. Required roles: admin, seller",
    "error": "Forbidden",
    "required_roles": ["admin", "seller"]
}
```

## Testing Middleware

### Testing Admin Access
```php
// Test with admin user
$admin = User::factory()->create();
$admin->assignRole('admin');
$this->actingAs($admin);

$response = $this->get('/admin/dashboard');
$response->assertStatus(200);
```

### Testing API with Sanctum
```php
// Test API with token
$user = User::factory()->create();
$user->assignRole('customer');
$token = $user->createToken('test-token')->plainTextToken;

$response = $this->withHeaders([
    'Authorization' => 'Bearer ' . $token,
])->get('/api/customer/orders');

$response->assertStatus(200);
```

## Security Considerations

1. **Role Hierarchy**: Admins can access all areas, sellers can access customer areas
2. **API Authentication**: Uses Sanctum tokens for API routes
3. **Web Authentication**: Uses session-based authentication for web routes
4. **Automatic Detection**: Middleware automatically detects API vs web requests
5. **Consistent Responses**: Same middleware works for both web and API

## Configuration

### Middleware Registration
Middleware is registered in `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'seller' => \App\Http\Middleware\SellerMiddleware::class,
        'customer' => \App\Http\Middleware\CustomerMiddleware::class,
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ]);
})
```

### Route Files
- `routes/web.php` - Public web routes
- `routes/admin.php` - Admin-specific routes
- `routes/seller.php` - Seller-specific routes  
- `routes/customer.php` - Customer-specific routes
- `routes/api.php` - API routes with role-based sections

## Best Practices

1. **Use Specific Middleware**: Use `admin`, `seller`, `customer` for clear role requirements
2. **Use Flexible Middleware**: Use `role:admin,seller` when multiple roles should have access
3. **Consistent Naming**: Follow naming conventions for route names and prefixes
4. **Group Related Routes**: Keep related functionality in the same route group
5. **Document Access Levels**: Clearly document which roles can access which features
