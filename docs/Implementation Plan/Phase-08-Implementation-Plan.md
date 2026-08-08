# Phase 8 — Payments, Invoicing, Financial Operations & ZATCA — Implementation Plan

## Goal
Build an enterprise-grade financial management, invoicing, payment gateway architecture, ZATCA e-invoicing preparedness (Phase 1 & 2), refund operations, and reporting system for Sema Al-Khalij Medical Services.

---

## Proposed Changes

### Database & Migrations
#### [NEW] `database/migrations/2026_08_08_000002_create_phase8_financial_tables.php`
- `invoices`: `id`, `invoice_number` (unique `INV-YYYY-NNNNNN`), `uuid` (ZATCA UUID v4), `booking_id`, `order_id`, `contract_id`, `user_id`, `company_id`, `issue_date`, `due_date`, `subtotal`, `discount_amount`, `vat_rate` (15%), `vat_amount`, `total_amount`, `payment_status` (`unpaid`, `partially_paid`, `paid`, `refunded`, `cancelled`), `zatca_status` (`draft`, `generated`, `submitted`, `cleared`), `qr_code_tlv`, `invoice_hash`, `notes`, `timestamps`.
- `invoice_items`: `id`, `invoice_id`, `description`, `quantity`, `unit_price`, `subtotal`, `vat_amount`, `total_amount`.
- `payments`: `id`, `payment_number` (unique `PAY-YYYY-NNNNNN`), `invoice_id`, `booking_id`, `order_id`, `contract_id`, `user_id`, `company_id`, `amount`, `payment_method` (`mada`, `apple_pay`, `visa`, `mastercard`, `stc_pay`, `cash`, `bank_transfer`), `status` (`pending`, `completed`, `failed`, `refunded`), `transaction_reference`, `gateway_response` (json), `paid_at`, `timestamps`.
- `refund_requests`: `id`, `refund_number` (unique `REF-YYYY-NNNNNN`), `payment_id`, `invoice_id`, `user_id`, `amount`, `reason`, `status` (`pending`, `approved`, `rejected`), `approved_by`, `processed_at`, `notes`, `timestamps`.

---

### Models & Services
#### [NEW] `app/Models/Invoice.php`, `InvoiceItem.php`, `Payment.php`, `RefundRequest.php`
- Model definitions, relationships, and helper methods.

#### [NEW] `app/Services/InvoiceGeneratorService.php`
- Sequential, collision-safe invoice number generator (`INV-YYYY-NNNNNN`).
- Automatic line item calculation, 15% VAT breakdown, and ZATCA metadata generation.

#### [NEW] `app/Services/ZatcaService.php`
- ZATCA Phase 1 & Phase 2 Compliant E-Invoicing Engine:
  - Generate TLV Base64 QR Code (Seller Name, VAT Registration #, Timestamp, Total with VAT, VAT Amount).
  - Calculate SHA-256 Invoice Hash.
  - Prepare XML Structure for ZATCA Submission.

#### [NEW] `app/Services/PaymentGatewayService.php`
- Decoupled Payment Gateway Architecture supporting `MadaDriver`, `ApplePayDriver`, `VisaMasterCardDriver`, `StcPayDriver`, `CashBankDriver`.

---

### Controllers & Middleware
#### [NEW] `app/Http/Controllers/Admin/FinanceManagerController.php`
- Admin Financial Panel: Financial Dashboard metrics, Invoices register, Payments register, Refunds approval workflow, ZATCA status monitoring, VAT Reports, and PDF exports.

#### [NEW] `app/Http/Controllers/InvoiceController.php`
- Secure streamed PDF Invoice / Printable View, Receipt View, and Corporate Account Statement with IDOR protection.

#### [NEW] `app/Http/Controllers/RefundRequestController.php`
- Customer refund request submission.

---

### Views & UI Components
#### [NEW] `resources/views/admin/finance/dashboard.blade.php`
- Real MySQL Financial Metrics: Total Revenue, Paid, Pending, Failed, Refunded, VAT Collected, Corporate vs Individual breakdown, Revenue charts.

#### [NEW] `resources/views/admin/finance/invoices/index.blade.php` & `show.blade.php`
- Filterable Invoices Register with ZATCA QR Code, line items, and PDF download buttons.

#### [NEW] `resources/views/admin/finance/payments/index.blade.php` & `show.blade.php`
- Payments history and transaction details.

#### [NEW] `resources/views/admin/finance/refunds/index.blade.php`
- Refund requests approval / rejection management.

#### [NEW] `resources/views/finance/pdf/invoice.blade.php` & `statement.blade.php` & `receipt.blade.php`
- Professional printable / PDF financial document templates.

#### [MODIFY] `resources/views/profile.blade.php`
- Customer Portal Billing & Invoices section with refund request form.

#### [MODIFY] `resources/views/company/portal.blade.php`
- Corporate Portal Financial Billing, Invoices & Account Statement (كشف حساب) tab.

---

### Routes
#### [MODIFY] `routes/web.php`
- Admin Finance Panel routes (`admin.finance.*`).
- PDF Download & Printable routes (`invoices.download`, `invoices.print`, `statements.print`).
- Customer & Corporate Billing routes.

---

### Testing & Verification Plan
#### [NEW] `tests/Feature/Phase8PaymentsInvoicingZatcaTest.php`
- 20+ feature tests covering:
  - Sequential invoice number generation & line item calculation.
  - ZATCA TLV QR Code generation & SHA-256 hashing.
  - Payment Gateway architecture execution.
  - Admin Financial Dashboard metrics & filters.
  - Refund request approval/rejection workflow & audit logging.
  - Customer & Corporate billing isolation & PDF download IDOR protection.
