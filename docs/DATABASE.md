# Database Schema & Models Documentation — Sema Al-Khalij Medical Services

This document details the database tables, relationships, and model schemas implemented in MySQL.

## Phase 3 Core Tables & Eloquent Models

### 1. `users` Table (`App\Models\User`)
- `id`, `name`, `email`, `phone`, `password`, `role`, `company_id`
- `identification_type` (`saudi_id`, `iqama`, `border_no`, `gcc_id`)
- `identification_number`
- `avatar`, `is_active`

### 2. `addresses` Table (`App\Models\Address`)
- `id`, `user_id` (foreign key to `users`), `label`, `city`, `district`, `street`, `building_no`, `additional_info`, `is_default`, `lat`, `lng`

### 3. `bookings` Table (`App\Models\Booking`)
- `id`, `uuid`, `booking_number`, `user_id`, `service_id`, `booking_date`, `booking_time`, `city`, `address`, `phone`, `total_price`, `status`, `payment_status`, `payment_method`, `assigned_provider_id`, `assigned_by`, `assigned_at`, `accepted_at`, `started_at`, `completed_at`, `verified_at`
- Relationships: `belongsTo(User)`, `belongsTo(Service)`, `belongsTo(User, 'assigned_provider_id')`, `hasOne(LabSample)`, `hasMany(MedicalReport)`

### 4. `orders` Table (`App\Models\Order`)
- `id`, `uuid`, `order_number`, `user_id`, `subtotal`, `total_price`, `total_amount`, `shipping_address`, `phone`, `status`, `payment_status`, `payment_method`
- Relationships: `belongsTo(User)`, `hasMany(OrderItem)`

### 5. `lab_samples` Table (`App\Models\LabSample`)
- `id`, `visit_code` (Unique `VIS-2026-XXXXXX`), `booking_id`, `patient_id`, `company_id`, `sample_status` (`registered`, `assigned`, `sample_collected`, `sent_to_lab`, `received_by_lab`, `processing`, `result_ready`)

### 6. `medical_reports` Table (`App\Models\MedicalReport`)
- `id`, `lab_sample_id`, `patient_id`, `booking_id`, `company_id`, `visit_code`, `file_path`, `file_name`, `file_size`, `mime_type`, `uploaded_by`

### 7. `wishlist_items` Table (`App\Models\WishlistItem`)
- `id`, `user_id`, `product_id`
- Relationships: `belongsTo(User)`, `belongsTo(Product)`
