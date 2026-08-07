# Changelog — Sema Al-Khalij Medical Services & Operations

## [Phase 7 — Laboratory Operations, Medical Reports & Diagnostics] - 2026-08-08
### Added
- **9-Stage Lab Workflow State Machine**: Implemented `App\Services\LabWorkflowService` supporting `registered` → `assigned` → `sample_collected` → `sent_to_lab` → `received_by_lab` → `processing` → `result_ready` → `report_uploaded` → `delivered`.
- **Admin Laboratory Management**: Created `LabSampleManagerController` and views (`index`, `create`, `show`) for searching, filtering, staff assignment, stage transitions, and metrics analytics.
- **Medical PDF Report Management & Versioning**: Private storage in `private/medical_reports`, upload, version replacement (`medical_report_versions`), deletion, and streamed downloads.
- **Laboratory Staff Portal**: Dedicated Lab Tech workstation (`/staff/lab/dashboard` and `/staff/lab/samples/{id}`) with strict technician sample isolation.
- **Customer & Corporate Portals**: Real-time 9-stage sample tracking timeline and secure PDF downloads for patients and company clients.
- **Automated Feature Test Suite**: Added `Phase7LabOperationsMedicalReportsTest.php` with 14 automated feature tests.

### Verified
- **128 / 128 PHPUnit tests PASSED (100% pass rate, 46.05s)**.
- **142 Routes** registered (11 new Phase 7 routes).
- Zero git push.

---

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
