# Changelog — Sema Al-Khalij Medical Services & Operations

## [Phase 6 — Final Phase Audit & Hardening] - 2026-08-08
### Fixed & Hardened
- **Security & Audit Logging**: Added full `AuditLog::log` tracking for user role updates, account activation/deactivation, and user deletion in `UserManagerController`. Added `AuditLog::log` for order status updates in `OrderManagerController`. Added `AuditLog::log` for catalog operations in `ServiceManagerController` and `ProductManagerController`.
- **Order Status Validation**: Replaced open `'status' => 'required|string'` in `OrderManagerController::updateStatus()` with strict `'status' => 'required|in:pending,processing,shipped,delivered,cancelled'`.
- **Policy Registration**: Registered `CompanyPolicy::class` in `AuthServiceProvider::$policies`.
- **VAT Number Fallback**: Removed dummy `'300000000000003'` fallback from `AppServiceProvider.php` global view composer.
- **Admin Self-Protection**: Added guards in `UserManagerController` preventing Admin users from removing their own admin role or deactivating their own active account, and protecting `super_admin` accounts from non-super_admin users.
- **Database Transactions**: Wrapped multi-step file upload and database mutation operations in `ServiceManagerController` and `ProductManagerController` with `DB::transaction()`.

### Verified
- **114 / 114 PHPUnit tests PASSED (100% pass rate, 39.00s)**.
- **35 / 35 Phase 6 tests PASSED**.
- **131 Routes** registered (100% verified).
- Zero git push.

---

## [Phase 6] - 2026-08-07
### Added
- Created `ContractManagerController` with index, create, store, edit, update, toggleStatus, addService, removeService, and updatePrice methods.
- Created `BeneficiaryManagerController` with index, create, store, edit, update, toggleStatus methods, and auto patient linking logic.
- Created `resources/views/admin/contracts/index.blade.php`, `create.blade.php`, `edit.blade.php`, `show.blade.php`.
- Created `resources/views/admin/beneficiaries/index.blade.php`, `create.blade.php`, `edit.blade.php`.
- Created `resources/views/company/print-request.blade.php` for printable corporate service request vouchers.
- Created `database/migrations/2026_08_07_000002_add_phase6_contract_and_beneficiary_columns.php`.
- Created `tests/Feature/Phase6ContractsPricingBeneficiariesTest.php` with 29 feature tests.
- Added `docs/Implementation Plan/Phase-06-Final-Handoff.md` as single copy-paste review document.

### Changed
- Updated `CompanyPortalController.php` with server-side price calculation, eligibility checks, printable requests, and beneficiary management.
- Updated `resources/views/company/portal.blade.php` with Contracts tab, Beneficiaries tab, print action, and beneficiary selection modal.
- Updated `resources/views/layouts/admin.blade.php` with Contracts and Beneficiaries links under Corporate menu.
- Updated status badges across admin views from "نشط وساري" to "نشط".
- Updated `routes/web.php` with 11 new admin and company portal routes (Total routes: 131).

### Verified
- 108 out of 108 PHPUnit tests passing (100% pass rate).
