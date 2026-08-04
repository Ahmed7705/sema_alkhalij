# Changelog — Sema Al-Khalij Medical Services & Operations

All notable changes and phase releases are documented in this file.

## Phase 3 Final Release — Customer / Patient Portal [2026-08-04]

### Added:
- **`WishlistController`**: Implemented `index()`, `toggle()`, and `destroy()` methods with server-side IDOR authorization (`user_id === Auth::id()`).
- **Wishlist Routes**: Registered `GET /wishlist`, `POST /wishlist/toggle`, `DELETE /wishlist/{wishlistItem}` under `auth` middleware.
- **7-Stage Lab Sample Workflow Tracker**: Added `assigned` step to render all 7 approved lab sample states (`registered` → `assigned` → `sample_collected` → `sent_to_lab` → `received_by_lab` → `processing` → `result_ready`).
- **Password Security**: Validated current password with `Hash::check()` and updated hash via `Hash::make()`.
- **Phase 3 Feature Test Suite**: Added 5 new tests in `tests/Feature/Phase3CustomerPortalTest.php` covering Wishlist CRUD & IDOR, Lab Sample 7-stage workflow, Password updates & validation, and Header customer isolation.

### Updated:
- **`2026_08_03_000010_create_cart_and_wishlist_tables.php`**: Made `session_id` column nullable in `wishlist_items` migration table.
- **`profile.blade.php`**: Rendered all 7 lab sample workflow steps in visual progress tracker.

### Verified:
- `php artisan test`: **37 / 37 tests passed cleanly (9.87s)** with 0 failures.
- `php artisan route:list`: **87 active routes**.
- Git repository unpushed as instructed.
