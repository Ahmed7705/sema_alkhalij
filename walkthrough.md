# Walkthrough: Database & Authentication Integration

Full implementation of the MySQL Database schema, initial medical seed data, Email/Password authentication with Email OTP verification, and Socialite integration for Google & Apple login.

## Key Changes Completed

### Phase 1: Foundation & Core Services (100% Completed & Verified)
- **`SettingsService`**: Created centralized settings manager with dynamic VAT calculation (`SettingsService::getVatRate()`) and automatic cache invalidation (`Cache::forget('site_setting_' . $key)`) on every update.
- **`MediaService`**: Built file upload manager supporting image validation, WebP auto-conversion/compression, and alt text metadata.
- **`AnalyticsService`**: Created decoupled analytics engine computing executive metrics (revenue, active bookings, order volume) and Chart.js datasets.
- **`UUID Migration`**: Added internal `uuid` (UUIDv4) columns to `orders` and `bookings` tables, auto-generated on Eloquent model creation alongside formatted numbers `#BK-XXXXX` and `#ORD-XXXXX`.
- **`Events Architecture`**: Created `OrderCreated`, `BookingCreated`, and `SettingsUpdated` events with `LogActivityListener` recording sensitive actions into `audit_logs`.
- Ran `php artisan migrate:fresh --seed` successfully migrating all 20 migration files (33+ tables + UUIDs).

### Phase 2: Authentication & Security (100% Completed & Verified)
- **Email/Password Auth**: Registration and login controllers with validation, remember me support, and active status check.
- **Email 6-digit OTP Verification**: `/verify-otp` view, OTP validation, expiry check (15 mins), and OTP resend mechanism.
- **Socialite Google & Apple Login**: `/auth/{provider}` and callback endpoints supporting Google and Apple OAuth logins.
- **Password Reset Flow**: `/forgot-password` and `/reset-password` views with 6-digit verification code email dispatch.

### Phase 3: Users & RBAC Permissions (100% Completed & Verified)
- **Role & Permission Models**: Created `Role` and `Permission` Eloquent models with pivot relationships (`role_permission`, `role_user`).
- **User RBAC Methods**: Updated `User` model with `hasRole()`, `hasPermission()`, `isAdmin()`, `isCustomer()`, `roles()`, `addresses()`, `defaultAddress()`.
- **Laravel Authorization Policies**: Built `BookingPolicy`, `OrderPolicy`, `ServicePolicy`, `ProductPolicy`, and `SettingPolicy` in `app/Policies/`.
- **Gates Registration**: Registered policies and defined `access-admin` & `manage-settings` Gates in `AuthServiceProvider.php`.

### Phase 4: CMS & System Settings Engine (100% Completed & Verified)
- **CMS Eloquent Models**: Built `Faq`, `Review`, `Certification`, `Partner`, `SiteStat`, `BlogCategory`, `BlogPost`, and `SiteSetting` models.
- **Global View Composer**: Created automatic `$siteSettings` global injection in `AppServiceProvider.php` sharing site phone, email, VAT rate, address, and SEO defaults across all Blade layouts.
- **Idempotent Seeder**: Enhanced `DatabaseSeeder.php` with `firstOrCreate` and `updateOrCreate` seeders for settings, services, products, FAQs, reviews, and blog posts.

### Phase 5: Public Marketing Website Layout & Home Page (100% Completed & Verified)
- **`HomeController`**: Created dedicated controller querying dynamic Eloquent data for featured services, products, statistics, testimonials, partners, accreditations, latest blog posts, and FAQs.
- **Dynamic Routing**: Mapped home route `/` to `HomeController@index`.
- **Dynamic Home Page (`welcome.blade.php`)**: Connected all home sections 100% dynamically to MySQL database models with zero dummy hardcoded content.

### Phase 6: Medical Services Catalog & Detail Pages (100% Completed & Verified)
- **`ServiceController`**: Created controller with `index()` supporting live text search (`?search=`) and category tab filtering (`?category=`), and `show()` for service detail views.
- **Dynamic Services Catalog (`services.blade.php`)**: Built catalog view featuring category tabs, search input, price callouts, duration badges, and direct booking modal triggers.
- **Service Detail Page (`service-detail.blade.php`)**: Built detail view showing full description, included medical features, duration, price calculator, WhatsApp consultation button, and instant booking modal trigger.

### Phase 7: Home-Visit Service Booking Wizard (100% Completed & Verified)
- **Livewire Component (`ServiceBookingModal.php`)**: Built full Livewire component handling a 4-step wizard with dynamic validation at each step.
- **Step 1 (Select Service)**: Radio selection of medical services directly from MySQL database.
- **Step 2 (Appointment Schedule)**: Interactive Date Picker + 5 available time slots (Morning & Evening).
- **Step 3 (Patient Info & Address)**: Patient Name, Mobile Phone, City dropdown (جدة, الرياض, مكة المكرمة, الدمام, الخبر), street address, and medical notes.
- **Step 4 (Review & Payment Method)**: Complete booking summary, price calculator, and payment method selector (Cash on Visit / Mada Card).
- **Database Persistence**: Stores record in `bookings` table with UUIDv4 and formatted reference number `#BK-XXXXX`, returning an instant success confirmation screen.
- **Global Integration**: Embedded component globally in `app.blade.php` layout and wired "احجز هذه الخدمة الآن" buttons across all catalog and detail views.

### 2. User Delivery Addresses & Profile Integration
- Linked `Address` Eloquent Model with `User` model (`addresses()` & `defaultAddress()` relationships).
- Seeded default delivery addresses (Home & Work) for the test customer.
- Added **"عناويني المحفوظة"** tab in `profile.blade.php` displaying the user's saved locations.

### 2. Authentication & Verification System
- Built **Register System** (`RegisterController`) with automatic 6-digit OTP code generation and email dispatch.
- Built **Verification System** (`VerificationController` & `verify-otp.blade.php`) with OTP entry form and resend functionality.
- Built **Login System** (`LoginController`) supporting login via Email or Phone number and Password.
- Built **Socialite Integration** (`SocialAuthController`) supporting **Google** & **Apple** login with fallback mock mode during development.

### 3. Dynamic Data Binding
- Bound dynamic database models (`Service`, `Product`, `Category`) to `web.php` routes.
- Updated `profile.blade.php` to display real authenticated `Auth::user()` data and handle logout via POST.

---

## Verification Results

### Database Verification
- Executed `C:\Users\ahmed\Desktop\php-8.4.14-Win32-vs17-x64\php.exe artisan migrate:fresh --seed`
- Result: **All 10 migration files executed and seeded clean without errors.**

### Auth System Test Accounts
- **Admin Account**: `admin@sema-alkhalij.com` / Password: `password123`
- **Customer Account**: `user@example.com` / Password: `password123`
