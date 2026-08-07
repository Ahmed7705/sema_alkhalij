# Changelog — Sema Al-Khalij Medical Services & Operations

## [Phase 6 — Final Bug Fix] - 2026-08-08
### Fixed (Production Fake Data Elimination)
- **REMOVED** `Company::create()` auto-generation with hardcoded Aramco fake data from `CompanyPortalController::dashboard()`.
- **REMOVED** `Contract::create()` with `rand(100,999)` auto-generation from `CompanyPortalController::dashboard()`.
- **REMOVED** `'CP-' . strtoupper(Str::random(6))` booking number from `CompanyPortalController::storeServiceRequest()` — now uses unified `Booking::boot()` sequential system.
- **REMOVED** `'BK-' . strtoupper(Str::random(6))` from `ServiceBookingModal::store()` — now uses unified `Booking::boot()` sequential system.
- **FIXED** `identification_type` validation in `CompanyPortalController::storeServiceRequest()` from open `required|string` to strict `required|in:saudi_id,iqama,border_number,gcc_id`.
- **FIXED** `border_no` → `border_number` in `ProfileController::update()` validation rule.
- **FIXED** `border_no` → `border_number` in `resources/views/profile.blade.php` option value.

### Added
- Created `resources/views/company/portal-no-company.blade.php` — real empty state view for admin when no companies exist, with link to `/admin/companies/create`.
- Updated `resources/views/company/portal.blade.php` — no-contract warning banner and disabled request button when `$activeContract` is null.
- Added 6 new automated security/integrity tests to `Phase6ContractsPricingBeneficiariesTest.php`:
  - `empty_database_does_not_auto_create_company`
  - `company_without_active_contract_does_not_auto_create_contract`
  - `company_without_active_contract_cannot_submit_corporate_request`
  - `booking_reference_follows_bk_year_sequential_architecture`
  - `invalid_identification_type_is_rejected_in_corporate_request`
  - `valid_identification_types_are_accepted`

### Verified
- **114 / 114 PHPUnit tests PASSED (100% pass rate, 60.31s)**.
- **35 / 35 Phase6 tests PASSED** (29 original + 6 new).
- **131 Routes** registered (unchanged).
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
