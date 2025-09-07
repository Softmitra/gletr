# Gletr Jewellery Marketplace - Database Design

## Overview
This document outlines the database design for the Gletr Jewellery Marketplace, a multi-vendor platform for selling jewellery and precious items.

## Core Tables

### Users Table
- **Purpose**: Store user accounts (customers, sellers, admins)
- **Key Fields**: id, name, email, password, email_verified_at
- **Relationships**: 
  - Has many orders
  - Has many reviews
  - Has many cart items
  - Has roles (via Spatie Permission)

### Sellers Table
- **Purpose**: Store seller/vendor information
- **Key Fields**: id, name, email, phone, business_name, description, status, is_verified, commission_rate
- **Relationships**:
  - Has many products
  - Belongs to user (future implementation)

### Categories Table
- **Purpose**: Hierarchical product categorization
- **Key Fields**: id, name, slug, description, parent_id, is_active, sort_order
- **Relationships**:
  - Has many products
  - Has many children (subcategories)
  - Belongs to parent category

### Products Table
- **Purpose**: Store product information
- **Key Fields**: id, name, description, sku, seller_id, category_id, status, is_featured, metal_type, purity, weight
- **Relationships**:
  - Belongs to seller
  - Belongs to category
  - Has many variants
  - Has many reviews
  - Has many order items
  - Has media (images)

### Product Variants Table
- **Purpose**: Store product variations (size, color, etc.)
- **Key Fields**: id, product_id, sku, price, stock, attributes
- **Relationships**:
  - Belongs to product
  - Has many order items

### Orders Table
- **Purpose**: Store customer orders
- **Key Fields**: id, user_id, order_number, status, total_amount, shipping_address, billing_address
- **Relationships**:
  - Belongs to user
  - Has many order items
  - Has many payments

### Order Items Table
- **Purpose**: Store individual items within an order
- **Key Fields**: id, order_id, product_id, variant_id, quantity, unit_price, total_price
- **Relationships**:
  - Belongs to order
  - Belongs to product
  - Belongs to variant

### Carts Table
- **Purpose**: Store shopping cart sessions
- **Key Fields**: id, user_id, session_id, expires_at
- **Relationships**:
  - Belongs to user
  - Has many cart items

### Cart Items Table
- **Purpose**: Store items in shopping cart
- **Key Fields**: id, cart_id, product_id, variant_id, quantity
- **Relationships**:
  - Belongs to cart
  - Belongs to product
  - Belongs to variant

### Payments Table
- **Purpose**: Store payment transactions
- **Key Fields**: id, order_id, payment_method, transaction_id, amount, status, gateway_response
- **Relationships**:
  - Belongs to order

### Reviews Table
- **Purpose**: Store product reviews and ratings
- **Key Fields**: id, product_id, user_id, rating, title, comment, is_verified
- **Relationships**:
  - Belongs to product
  - Belongs to user

### Settings Table
- **Purpose**: Store application configuration
- **Key Fields**: id, key, value, type, group, description
- **No direct relationships**

## Permission System (Spatie Laravel Permission)

### Roles
- **admin**: Full system access
- **seller**: Can manage own products and orders
- **customer**: Can browse, purchase, and review

### Permissions
- manage users
- manage products
- manage orders
- manage categories
- manage sellers
- manage settings
- view analytics
- manage reviews

## Media System (Spatie Laravel MediaLibrary)

### Media Collections
- **Products**:
  - `images`: Main product image (single file)
  - `gallery`: Additional product images (multiple files)
- **Categories**:
  - `image`: Category banner/icon (single file)

### Media Conversions
- **thumb**: 300x300px for thumbnails
- **preview**: 800x600px for product previews
- **banner**: 1200x400px for category banners

## API Authentication (Laravel Sanctum)

### Personal Access Tokens Table
- **Purpose**: Store API tokens for mobile/SPA authentication
- **Key Fields**: id, tokenable_type, tokenable_id, name, token, abilities, expires_at
- **Relationships**: Polymorphic to User model

## Indexes and Performance

### Recommended Indexes
```sql
-- Products
CREATE INDEX idx_products_seller_category ON products(seller_id, category_id);
CREATE INDEX idx_products_status_featured ON products(status, is_featured);
CREATE INDEX idx_products_sku ON products(sku);

-- Categories
CREATE INDEX idx_categories_parent_active ON categories(parent_id, is_active);
CREATE INDEX idx_categories_slug ON categories(slug);

-- Orders
CREATE INDEX idx_orders_user_status ON orders(user_id, status);
CREATE INDEX idx_orders_created_at ON orders(created_at);

-- Reviews
CREATE INDEX idx_reviews_product_verified ON reviews(product_id, is_verified);
```

## Data Relationships Diagram

```
Users (1) -----> (M) Orders
Users (1) -----> (M) Reviews  
Users (1) -----> (M) Carts

Sellers (1) ----> (M) Products
Categories (1) -> (M) Products
Products (1) ---> (M) Product_Variants
Products (1) ---> (M) Reviews
Products (1) ---> (M) Order_Items

Orders (1) -----> (M) Order_Items
Orders (1) -----> (M) Payments

Carts (1) ------> (M) Cart_Items
```

## Future Enhancements

1. **Wishlist System**: Add wishlist table for saved products
2. **Inventory Tracking**: Enhanced stock management
3. **Shipping Methods**: Flexible shipping options
4. **Coupons/Discounts**: Promotional system
5. **Product Attributes**: Dynamic product specifications
6. **Seller Analytics**: Performance metrics for sellers
7. **Multi-currency**: Support for different currencies
8. **Geolocation**: Location-based features

## Migration Status

All core tables have been created and migrated:
- ✅ Users, Roles, Permissions
- ✅ Sellers, Categories, Products, Product Variants
- ✅ Orders, Order Items, Carts, Cart Items
- ✅ Payments, Reviews, Settings
- ✅ Media Library tables
- ✅ Sanctum personal access tokens

## Seeded Data

- **Users**: 63 total (admin, seller, customer + test users)
- **Categories**: 30 total (6 main + 24 subcategories)  
- **Sellers**: 5 demo sellers
- **Roles & Permissions**: Complete RBAC setup
