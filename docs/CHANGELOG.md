# Changelog — Sema Al-Khalij Medical Services & Operations

All notable changes and phase releases are documented in this file.

## Phase 3 Release — Customer / Patient Portal [2026-08-04]

### Added:
- **`AddressController`**: Built complete address management controller (`store`, `update`, `destroy`, `setDefault`) with IDOR authorization (`user_id === Auth::id()`).
- **Customer Booking & Order Detail Controllers/Views**:
  - `ProfileController::showBooking()` & `resources/views/profile/booking-show.blade.php`: Visual 6-step workflow, lab sample tracking, and private medical report PDF download button.
  - `ProfileController::showOrder()` & `resources/views/profile/order-show.blade.php`: Item breakdown, dynamic VAT rate from `SettingsService`, and payment status.
- **Phase 3 Feature Test Suite** (`tests/Feature/Phase3CustomerPortalTest.php`): 11 feature tests for customer profile access, profile updates with identity fields, address CRUD IDOR protection, booking/order detail IDOR protection, and secure medical report PDF downloads.

### Updated:
- **`ProfileController`**: Expanded `index()` and `update()` methods to support tabbed dashboard views, identity type/number updates, lab sample tracking, and wishlist items.
- **`resources/views/profile.blade.php`**: Redesigned tabbed Customer Portal UI (Overview, Bookings, Orders, Medical Reports, Lab Samples, Addresses, Wishlist, Profile Edit).
- **`User` & `Booking` Models**: Added `$fillable` fields (`company_id`, `identification_type`, `identification_number`) and relationships (`assignedProvider`, `labSample`, `medicalReports`).

### Verified:
- `php artisan test`: **32 / 32 tests passed cleanly (18.49s)**.
- `php artisan route:list`: **84 active routes**.
- Git repository unpushed as instructed.
