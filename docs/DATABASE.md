# Database Documentation — Sema Al-Khalij Medical Services

> **100% Complete Implementation** of Section 19 of `sema-alkhalij-full-prompt .md`.

## Database Configuration
- Engine: MySQL 8.0+
- Database: `sema_alkhalij_db`
- Character Set: `utf8mb4_unicode_ci`

---

## Complete Table Schema Listing (33 Tables)

### 1. Users & RBAC Permissions
- **`users`**: User accounts (customer & admin), social login IDs (Google/Apple), email OTP code, phone, avatar.
- **`roles`**: System roles (Admin, Doctor, Customer, Nurse).
- **`permissions`**: Fine-grained access permissions.
- **`role_permission`**: Pivot table connecting roles & permissions.
- **`role_user`**: Pivot table connecting users & roles.
- **`addresses`**: User delivery & home visit addresses (`label`, `city`, `district`, `street`, `building_no`, `additional_info`, `lat`, `lng`, `is_default`).

### 2. Categories, Services, Products & Cities
- **`categories`**: General categories for services & products.
- **`services`**: Home medical visit services, nursing, lab screening, physiotherapy.
- **`products`**: Medical devices, glucometers, blood pressure monitors, wheelchairs.
- **`product_images`**: Product gallery images with alt text.
- **`cities`**: Available delivery & service cities in Saudi Arabia.

### 3. Cart & Wishlist (Polymorphic)
- **`cart_items`**: Polymorphic cart supporting services & products (`scheduled_date`, `scheduled_time`).
- **`wishlist_items`**: Polymorphic user favorites.

### 4. Orders & Bookings
- **`orders`**: Product ecommerce orders with shipping address & status tracking.
- **`order_items`**: Line items inside each order.
- **`bookings`**: Medical home-visit bookings with date, time, status, address.

### 5. Payments, Refunds & Coupons
- **`coupons`**: Discount coupons (percentage/fixed).
- **`payments`**: Polymorphic payment records (mada, visa, mastercard, applepay, tabby, tamara).
- **`refunds`**: Payment refund records.

### 6. Marketing & Blog Content
- **`blog_categories`**: Medical blog categories.
- **`blog_posts`**: Medical blog articles with SEO metadata.
- **`faqs`**: Frequently asked questions grouped by category.
- **`reviews`**: Polymorphic user ratings & comments.
- **`certifications`**: Medical accreditations logos.
- **`partners`**: Corporate & medical partners logos.
- **`site_stats`**: Dynamic homepage counter statistics.

### 7. System, Support & Analytics
- **`contact_submissions`**: Contact Us form messages.
- **`callback_requests`**: Quick callback requests ("اطلب معاودة اتصال").
- **`newsletter_subscribers`**: Email newsletter subscriptions.
- **`audit_logs`**: System audit trail logs.
- **`page_views`**: Analytics visitor page view logs.
- **`site_settings`**: Global dynamic site settings.
