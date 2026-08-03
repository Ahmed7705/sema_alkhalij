Phase 1 — Foundation
الهدف

إنشاء الأساس الكامل للمشروع بحيث تكون جميع المراحل التالية مبنية عليه.

Deliverables
Project Initialization
إنشاء مشروع Laravel.
إعداد Git.
إعداد Composer.
إعداد البيئة (.env).
إعداد MySQL.
إنشاء قاعدة البيانات.
إعداد جميع Configurations.
Folder Structure

تنظيم المشروع بحيث يحتوي على:

app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
tests/
docs/
Documentation

إنشاء:

AI_CONTEXT.md
PROJECT_STATUS.md
ARCHITECTURE.md
DATABASE.md
ROUTES.md
CHANGELOG.md
TODO.md
DEPLOYMENT.md
SESSION_HANDOFF.md
Core Architecture

إنشاء المجلدات الأساسية مثل:

Services
Traits
Interfaces
Enums
Helpers
Policies
Events
Listeners
Middleware
Requests
UI Foundation
Blade Layout
Master Layout
Header
Footer
Navigation
Sidebar
Blade Components
Responsive Layout
Frontend Stack
Blade
Tailwind CSS
Livewire
Alpine.js
Chart.js
Core Services

إنشاء الخدمات الأساسية فقط:

SettingsService
MediaService
AnalyticsService
Shared Components

إنشاء مكونات قابلة لإعادة الاستخدام:

Button
Input
Select
Textarea
Modal
Card
Alert
Badge
Empty State
Loading State
Pagination
Breadcrumb
Page Header
Security Foundation
CSRF
XSS Protection
Validation
Sessions
HTTPS Ready
Secure Cookies
Error Pages
Acceptance Criteria

✓ المشروع يعمل.

✓ قاعدة البيانات متصلة.

✓ Layout يعمل.

✓ Components تعمل.

✓ Livewire يعمل.

✓ Tailwind يعمل.

✓ Alpine يعمل.

✓ Git جاهز.

✓ Documentation جاهزة.

Phase 2 — Authentication
الهدف

بناء نظام تسجيل الدخول بالكامل.

Deliverables
Authentication
Login
Register
Logout
Verification
Email Verification
OTP
Resend OTP
Password
Forgot Password
Reset Password
Change Password
Social Login
Apple Login

(تصميم يسمح بإضافة Google مستقبلاً)

Sessions
Remember Me
Session Timeout
Session Regeneration
Security
Rate Limiting
Login Attempts
Password Hashing
Email Verification Required
User Profile
Basic Profile
Avatar
Personal Information
Acceptance Criteria

✓ Register يعمل.

✓ Login يعمل.

✓ Logout يعمل.

✓ OTP يعمل.

✓ Email Verification تعمل.

✓ Password Reset يعمل.

✓ Apple Login يعمل.

Phase 3 — Users & Permissions
الهدف

بناء نظام المستخدمين والصلاحيات.

Deliverables
Users
User CRUD
User Status
Avatar
Profile
Roles
Admin
Manager
Staff
Customer
Permissions
Dynamic Permissions
Permission Groups
Authorization
Policies
Gates
Middleware
Activity Log

تسجيل العمليات مثل:

Login
Logout
Profile Update
Password Change
Audit Log

تسجيل:

تعديل الأسعار
حذف المنتجات
تغيير الصلاحيات
تعديل الإعدادات
Acceptance Criteria

✓ Roles تعمل.

✓ Permissions تعمل.

✓ Policies تعمل.

✓ Audit Log يعمل.

Phase 4 — CMS & Settings
الهدف

جعل الموقع بالكامل ديناميكي.

Deliverables
Site Settings
Company Name
Logo
Favicon
Address
Phones
Email
Working Hours
Homepage Sections

إدارة:

Hero
About
Why Us
Statistics
Testimonials
Partners
CTA
SEO
Meta Title
Meta Description
Keywords
OpenGraph
Languages
Arabic
English (Ready)
Payment Settings
Enable / Disable Gateways
Tax
VAT
Currency
VAT Number
Social Media
X
Instagram
LinkedIn
YouTube
Snapchat
Acceptance Criteria

✓ كل بيانات الموقع تتغير من لوحة التحكم.

✓ لا يوجد محتوى ثابت داخل Blade.

Phase 5 — Public Website
الهدف

بناء الموقع الذي يراه الزائر.

Deliverables
Pages
Home
About
Services
Products
Blog
FAQ
Contact
Dynamic Sections
Hero
Statistics
Testimonials
Partners
Blog
FAQ
Forms
Contact Form
Callback Request
Newsletter
Responsive
Mobile
Tablet
Desktop
UX
Skeleton Loading
Empty States
Smooth Animations
Acceptance Criteria

✓ جميع الصفحات تعمل.

✓ Responsive.

✓ جميع البيانات من قاعدة البيانات.

Phase 6 — Services
الهدف

بناء نظام الخدمات الطبية بالكامل.

Deliverables
Categories
CRUD
ترتيب
تفعيل وإلغاء
Services
CRUD
Featured
Gallery
Images
SEO
Public
Services Listing
Service Details
Search
Filters
Admin
إدارة الخدمات
ترتيبها
الأسعار
الصور
Acceptance Criteria

✓ CRUD يعمل.

✓ البحث يعمل.

✓ الفلاتر تعمل.

✓ الصور تعمل.

Phase 7 — Booking
الهدف

بناء نظام الحجز.

Deliverables
Booking Wizard
اختيار الخدمة
التاريخ
الوقت
العنوان
الملاحظات
Booking
إنشاء الحجز
تعديل
إلغاء
Status
Pending
Confirmed
Assigned
Completed
Cancelled
Booking History
Timeline
Status History
Notifications
Email
Acceptance Criteria

✓ إنشاء الحجز.

✓ تغيير الحالة.

✓ سجل الحجز.

✓ جميع العمليات داخل Transaction.

Phase 8 — Products
الهدف

بناء المتجر.

Deliverables
Categories
CRUD
Products
CRUD
SKU
Stock
Images
Gallery
Featured
Inventory
Quantity
Low Stock
Out Of Stock
Public
Listing
Details
Search
Filters
Admin
إدارة المنتجات
الأسعار
المخزون
الصور
Acceptance Criteria

✓ CRUD يعمل.

✓ إدارة المخزون تعمل.

✓ البحث يعمل.

✓ الفلاتر تعمل.

✓ المنتجات تعرض بشكل ديناميكي.

هذا التقسيم يجعل كل مرحلة صغيرة نسبيًا، لها هدف واضح، ومعايير اكتمال (Acceptance Criteria)، ويمكن لأي AI إكمال مرحلة واحدة ثم تحديث ملفات /docs قبل الانتقال للمرحلة التالية. في الرسالة التالية يمكن بناء الجزء الثاني (Phase 9 إلى Phase 16) بنفس المستوى من التفصيل.


## Phase 9 — Cart & Wishlist

### الهدف

بناء نظام السلة والمفضلة بالكامل باستخدام Livewire مع تحديثات فورية دون إعادة تحميل الصفحة.

### Deliverables

### Shopping Cart

* Add To Cart
* Remove From Cart
* Update Quantity
* Clear Cart
* Save Cart
* Mini Cart
* Cart Summary

### Wishlist

* Add To Wishlist
* Remove From Wishlist
* Move To Cart
* Wishlist Counter

### Coupons

* Apply Coupon
* Remove Coupon
* Coupon Validation
* Expiration Check
* Usage Limits

### Pricing

* Subtotal
* Discount
* VAT (Dynamic)
* Delivery Fees
* Grand Total

### Livewire Components

* Cart Counter
* Mini Cart
* Cart Page
* Wishlist
* Coupon Form

### Acceptance Criteria

✓ السلة تعمل بدون Refresh.

✓ المفضلة تعمل.

✓ الكوبونات تعمل.

✓ جميع الأسعار تُحسب من السيرفر.

✓ لا يمكن التلاعب بالأسعار من المتصفح.

---

# Phase 10 — Checkout & Payments

## الهدف

تنفيذ عملية الشراء والدفع بشكل آمن.

### Deliverables

### Checkout

* Customer Information
* Delivery Address
* Order Summary
* Payment Selection

### Orders

* Order Creation
* Order Items
* Order Number
* UUID
* Order Status

### Payments

* PaymentService
* Payment Transactions
* Payment History
* Payment Status

### Payment Gateways

* Mada
* Visa / Mastercard
* Apple Pay
* Cash On Delivery

(قابل لإضافة Tabby وTamara مستقبلاً)

### Financial Rules

* Database Transactions
* Dynamic VAT
* Server-side Calculation
* Duplicate Payment Protection

### Notifications

* Email Confirmation
* Order Confirmation

### Acceptance Criteria

✓ Checkout يعمل.

✓ الطلب ينشأ بنجاح.

✓ الدفع يعمل.

✓ لا يوجد تكرار للطلبات.

✓ الأسعار صحيحة.

---

# Phase 11 — Customer Dashboard

## الهدف

بناء لوحة العميل.

### Deliverables

### Dashboard

* Welcome Screen
* Statistics
* Recent Activity

### Profile

* Personal Information
* Avatar
* Change Password

### Orders

* Current Orders
* Previous Orders
* Order Details

### Bookings

* Upcoming Bookings
* Booking History
* Booking Details

### Addresses

* Add Address
* Edit Address
* Delete Address
* Default Address

### Wishlist

* View Wishlist
* Remove Items

### Notifications

* Email Notifications
* In-System Notifications

### Acceptance Criteria

✓ جميع بيانات العميل تعمل.

✓ الطلبات والحجوزات تظهر.

✓ إدارة العناوين تعمل.

✓ الملف الشخصي يعمل.

---

# Phase 12 — Admin Dashboard

## الهدف

بناء لوحة الإدارة الكاملة.

### Deliverables

### Dashboard

* Statistics Cards
* Revenue Charts
* Bookings Overview
* Orders Overview
* Latest Activities

### Global Search

البحث داخل:

* Users
* Orders
* Bookings
* Products
* Services
* Articles

### User Management

* CRUD
* Roles
* Permissions

### CMS

* Services
* Products
* Articles
* FAQ
* Testimonials
* Homepage
* Contact Requests

### Settings

* Company
* SEO
* Languages
* Tax
* Payment
* Security

### Audit

* Activity Log
* Audit Log

### Acceptance Criteria

✓ لوحة الإدارة كاملة.

✓ البحث يعمل.

✓ جميع CRUD تعمل.

✓ الصلاحيات مطبقة.

---

# Phase 13 — Analytics

## الهدف

بناء نظام التحليلات.

### Deliverables

### Dashboard Metrics

* Visitors
* Unique Visitors
* New Users
* Returning Users

### Sales

* Revenue
* Orders
* Average Order Value
* Refunds

### Bookings

* Pending
* Confirmed
* Completed
* Cancelled

### Products

* Best Selling
* Most Viewed
* Low Stock

### Services

* Most Booked
* Most Viewed

### Charts

* Revenue
* Orders
* Bookings
* Visitors
* Products
* Services

### Reports

* Daily
* Weekly
* Monthly
* Yearly
* Custom Date Range

### Acceptance Criteria

✓ جميع الإحصائيات صحيحة.

✓ الرسوم البيانية تعمل.

✓ التقارير قابلة للتصفية.

---

# Phase 14 — SEO & Localization

## الهدف

تحسين ظهور الموقع ودعم تعدد اللغات.

### Deliverables

### SEO

* Meta Title
* Meta Description
* Meta Keywords
* Canonical URLs
* Robots.txt
* Sitemap.xml
* OpenGraph
* Twitter Cards
* Structured Data (Schema.org)

### Performance

* Lazy Loading
* Image Optimization
* WebP
* Clean URLs
* Breadcrumbs

### Localization

* Arabic (RTL)
* English (LTR)

### Translation

* Static Text
* Dynamic Content
* Validation Messages
* Emails

### Acceptance Criteria

✓ جميع الصفحات متوافقة مع SEO.

✓ اللغة العربية تعمل.

✓ المشروع جاهز لإضافة الإنجليزية.

---

# Phase 15 — Testing

## الهدف

التأكد من جودة واستقرار المشروع.

### Deliverables

### Feature Tests

* Authentication
* Bookings
* Orders
* Products
* Services
* Cart
* Checkout

### Unit Tests

* Services
* Helpers
* Calculations

### Security Tests

* CSRF
* XSS
* Validation
* Authorization
* File Upload

### Performance

* Query Optimization
* N+1 Check
* Load Testing

### UI Testing

* Responsive
* Browser Compatibility
* Error Pages

### Acceptance Criteria

✓ جميع الاختبارات الأساسية ناجحة.

✓ لا توجد أخطاء حرجة.

✓ الأداء مقبول.

---

# Phase 16 — Deployment

## الهدف

تجهيز المشروع للإطلاق على بيئة الإنتاج.

### Deliverables

### Production Configuration

* APP_ENV=production
* APP_DEBUG=false
* HTTPS
* Secure Cookies
* Optimized Config

### Database

* Production Migration
* Seed Essential Data
* Backup Plan

### Optimization

* Route Cache
* Config Cache
* View Cache
* Autoload Optimization

### Security

* Remove Debug Files
* Remove Test Routes
* Secure File Permissions
* Verify Upload Directories

### Final Verification

* Public Website
* Customer Dashboard
* Admin Dashboard
* Checkout
* Booking
* SEO
* Email
* Analytics

### Documentation

تحديث جميع ملفات `/docs`:

* AI_CONTEXT.md
* PROJECT_STATUS.md
* DATABASE.md
* ROUTES.md
* ARCHITECTURE.md
* CHANGELOG.md
* TODO.md
* DEPLOYMENT.md
* SESSION_HANDOFF.md

### Acceptance Criteria

✓ الموقع يعمل على الاستضافة.

✓ جميع الصفحات تعمل.

✓ جميع الخدمات تعمل.

✓ لا توجد أخطاء في الإنتاج.

✓ التوثيق محدث بالكامل.

---

# القواعد العامة (تنطبق على جميع المراحل)

* العمل على **Phase واحدة فقط** في كل مرة.
* لا تبدأ المرحلة التالية حتى تكتمل الحالية بالكامل.
* قبل الانتقال لأي Phase جديدة يجب:

  * تنفيذ جميع المتطلبات.
  * اختبار جميع الوظائف.
  * تحديث ملفات `/docs`.
  * تحديث `PROJECT_STATUS.md`.
  * تحديث `TODO.md`.
  * تحديث `SESSION_HANDOFF.md`.
  * تحديد **Exact Next Task** بوضوح.
* إذا اقتربت الجلسة من حد الـTokens، **يُمنع بدء ميزة جديدة**؛ يجب إيقاف العمل، تحديث التوثيق، وكتابة حالة المشروع لتسليمها إلى AI التالي.
