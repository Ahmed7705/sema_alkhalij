# Changelog — Sema Al-Khalij Medical Services & Operations

## [Phase 9 — Inventory, Pharmacy, Purchasing & Stock Operations] - 2026-08-08
### Added
- **Multi-Warehouse Management**: Added `warehouses` table, `Warehouse` model, and admin management for central warehouses, mobile fleet stores, and pharmacy locations.
- **Supplier & Procurement Lifecycle**: Added `suppliers`, `purchase_orders`, `purchase_order_items` tables, `Supplier` and `PurchaseOrder` models, `PurchasingService`, and `PurchasingManagerController` supporting purchase order creation, approval, receiving goods, and automated batch generation.
- **Batch Tracking & FEFO Pharmacy Dispensing**: Added `batches`, `stock_movements`, `medication_dispenses`, `medication_dispense_items` tables, `Batch`, `StockMovement`, `MedicationDispense` models, `InventoryService`, and `PharmacyDispensingController` supporting FEFO (First Expired, First Out) batch deduction linked to patient visits and prescriptions.
- **Admin Inventory Control Panel & Reports**: Created `InventoryManagerController`, `InventoryReportController`, and 9 Blade UI views for real-time inventory KPIs, stock batches, transfers, adjustments, low stock alerts, expiring batches within 60 days, and medication dispensing logs.
- **Automated Feature Test Suite**: Added `Phase9InventoryPharmacyPurchasingTest.php` with 8 automated feature tests.

### Verified
- **148 / 148 PHPUnit tests PASSED (100% pass rate)**.
- **168 Routes** registered (16 new Phase 9 routes).
- Zero git push.

---

## [Phase 8 — Payments, Invoicing, Financial Operations & ZATCA] - 2026-08-08

### Added
- **ZATCA E-Invoicing Engine**: Implemented `App\Services\ZatcaService` generating TLV Base64 QR Code (Tags 1-5), SHA-256 invoice hashing, UUID v4, and UBL 2.1 payload generation.
- **Payment Gateway Architecture**: Created `App\Services\PaymentGatewayService` supporting Mada, Apple Pay, Visa, MasterCard, STC Pay, Cash, and Bank Transfer with sequential `PAY-YYYY-NNNNNN` numbers.
- **Invoice Generator Service**: Created `App\Services\InvoiceGeneratorService` calculating 15% KSA VAT for Bookings, Store Orders, and Corporate Contracts with `INV-YYYY-NNNNNN` numbers.
- **Admin Financial Control Panel**: Created `FinanceManagerController` with Dashboard KPIs, Invoices Register, Payments Register, Refund Requests approval workflow, and ZATCA VAT 15% Tax Report.
- **PDF & Printable Templates**: Created printable Blade templates for ZATCA Tax Invoice with embedded QR code (`invoice.blade.php`), Official Payment Receipt (`receipt.blade.php`), and Corporate Statement of Account (`statement.blade.php`).
- **Customer & Corporate Portals**: Customer Billing & Refund Request tab in Profile, Corporate Billing & Statement download tab in Corporate Portal.
- **Automated Feature Test Suite**: Added `Phase8PaymentsInvoicingZatcaTest.php` with 12 automated feature tests.

### Verified
- **140 / 140 PHPUnit tests PASSED (100% pass rate)**.
- **152 Routes** registered (10 new Phase 8 routes).
- Zero git push.

---

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
