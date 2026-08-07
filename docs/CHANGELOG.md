# Changelog — Sema Al-Khalij Medical Services & Operations

## [Phase 6] - 2026-08-07
### Added
- Created `ContractManagerController` with index, create, store, edit, update, toggleStatus, addService, removeService, and updatePrice methods.
- Created `BeneficiaryManagerController` with index, create, store, edit, update, toggleStatus methods, and auto patient linking logic.
- Created `resources/views/admin/contracts/index.blade.php`, `create.blade.php`, `edit.blade.php`, `show.blade.php`.
- Created `resources/views/admin/beneficiaries/index.blade.php`, `create.blade.php`, `edit.blade.php`.
- Created `resources/views/company/print-request.blade.php` for printable corporate service request vouchers.
- Created `database/migrations/2026_08_07_000002_add_phase6_contract_and_beneficiary_columns.php`.
- Created `tests/Feature/Phase6ContractsPricingBeneficiariesTest.php` with 24 feature tests.
- Added `docs/Implementation Plan/Phase-06-Final-Handoff.md` as single copy-paste review document.

### Changed
- Updated `CompanyPortalController.php` with server-side price calculation, eligibility checks, printable requests, and beneficiary management.
- Updated `resources/views/company/portal.blade.php` with Contracts tab, Beneficiaries tab, print action, and beneficiary selection modal.
- Updated `resources/views/layouts/admin.blade.php` with Contracts and Beneficiaries links under Corporate menu.
- Updated status badges across admin views from "نشط وساري" to "نشط".
- Updated `routes/web.php` with 11 new admin and company portal routes (Total routes: 131).

### Verified
- 103 out of 103 PHPUnit tests passing (100% pass rate).
