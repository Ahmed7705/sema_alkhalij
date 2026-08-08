# Database Schema — Sema Al-Khalij Medical Services & Operations

## Phase 9 Inventory, Pharmacy & Purchasing Schema Extensions:

### 1. `warehouses` Table Structure:
- `id` (`bigint unsigned`, PK)
- `name_ar` (`string`), `name_en` (`string`, nullable), `code` (`string`, unique)
- `city` (`string`), `address` (`string`, nullable), `is_main` (`boolean`, default false), `is_active` (`boolean`, default true)

### 2. `suppliers` Table Structure:
- `id` (`bigint unsigned`, PK)
- `name` (`string`), `code` (`string`, unique), `contact_name` (`string`, nullable)
- `phone` (`string`, nullable), `email` (`string`, nullable), `cr_number` (`string`, nullable), `vat_number` (`string`, nullable)
- `address` (`text`, nullable), `status` (`string`, default 'active')

### 3. `batches` Table Structure:
- `id` (`bigint unsigned`, PK)
- `product_id` (`foreignId` -> `products`, cascadeOnDelete)
- `warehouse_id` (`foreignId` -> `warehouses`, cascadeOnDelete)
- `batch_number` (`string`), `manufactured_at` (`date`, nullable), `expiry_date` (`date`)
- `quantity` (`integer`, default 0), `cost_price` (`decimal 12,2`, nullable), `sell_price` (`decimal 12,2`, nullable)
- `is_active` (`boolean`, default true)

### 4. `stock_movements` Table Structure:
- `id` (`bigint unsigned`, PK)
- `product_id` (`foreignId` -> `products`, cascadeOnDelete)
- `batch_id` (`foreignId` -> `batches`, cascadeOnDelete)
- `from_warehouse_id` (`foreignId` -> `warehouses`, nullable)
- `to_warehouse_id` (`foreignId` -> `warehouses`, nullable)
- `user_id` (`foreignId` -> `users`, nullOnDelete)
- `type` (`enum`: `'stock_in'`, `'stock_out'`, `'transfer'`, `'adjustment'`, `'dispense'`, `'purchase_receive'`)
- `quantity` (`integer`), `reference_number` (`string`, nullable), `notes` (`text`, nullable)

### 5. `purchase_orders` & `purchase_order_items` Tables Structure:
- `purchase_orders`: `po_number` (`unique`), `supplier_id`, `warehouse_id`, `created_by`, `status` (`'draft'`, `'ordered'`, `'received'`, `'cancelled'`), `order_date`, `expected_delivery_date`, `total_amount`, `notes`.
- `purchase_order_items`: `purchase_order_id`, `product_id`, `quantity_ordered`, `quantity_received`, `unit_price`, `total_price`.

### 6. `medication_dispenses` & `medication_dispense_items` Tables Structure:
- `medication_dispenses`: `dispense_number` (`unique`), `patient_id`, `doctor_id`, `booking_id`, `warehouse_id`, `dispensed_by`, `dispensed_at`, `total_amount`, `notes`.
- `medication_dispense_items`: `medication_dispense_id`, `product_id`, `batch_id`, `quantity`, `unit_price`, `subtotal`.

---

## Phase 8 Financial Schema Extensions:


### 1. `invoices` Table Structure:
- `id` (`bigint unsigned`, PK)
- `invoice_number` (`string`, unique) — e.g. `INV-2026-000101`
- `uuid` (`uuid`, unique, nullable) — ZATCA UUID v4
- `booking_id` (`foreignId` -> `bookings`, nullable)
- `order_id` (`foreignId` -> `orders`, nullable)
- `contract_id` (`foreignId` -> `contracts`, nullable)
- `user_id` (`foreignId` -> `users`, nullable)
- `company_id` (`foreignId` -> `companies`, nullable)
- `issue_date` (`date`), `due_date` (`date`, nullable)
- `subtotal` (`decimal 12,2`), `vat_rate` (`decimal 5,2`, default 15.00), `vat_amount` (`decimal 12,2`), `total_amount` (`decimal 12,2`)
- `payment_status` (`enum`: `'unpaid'`, `'partially_paid'`, `'paid'`, `'refunded'`, `'cancelled'`)
- `zatca_status` (`enum`: `'draft'`, `'generated'`, `'submitted'`, `'cleared'`, `'reported'`)
- `qr_code_tlv` (`text`, nullable) — TLV Base64 Tag 1-5 string
- `invoice_hash` (`string`, nullable) — SHA-256 cryptographic hash
- `created_at`, `updated_at`

### 2. `invoice_items` Table Structure:
- `id` (`bigint unsigned`, PK)
- `invoice_id` (`foreignId` -> `invoices`, cascadeOnDelete)
- `description` (`string`), `quantity` (`integer`, default 1)
- `unit_price` (`decimal 12,2`), `subtotal` (`decimal 12,2`), `vat_amount` (`decimal 12,2`), `total_amount` (`decimal 12,2`)

### 3. `payments` Table Structure:
- `id` (`bigint unsigned`, PK)
- `payment_number` (`string`, unique) — e.g. `PAY-2026-000101`
- `invoice_id` (`foreignId` -> `invoices`, nullOnDelete)
- `user_id` (`foreignId` -> `users`, nullOnDelete)
- `company_id` (`foreignId` -> `companies`, nullOnDelete)
- `amount` (`decimal 12,2`)
- `payment_method` (`enum`: `'mada'`, `'apple_pay'`, `'visa'`, `'mastercard'`, `'stc_pay'`, `'cash'`, `'bank_transfer'`)
- `status` (`enum`: `'pending'`, `'completed'`, `'failed'`, `'refunded'`)
- `transaction_reference` (`string`, nullable)
- `gateway_response` (`json`, nullable)
- `paid_at` (`timestamp`, nullable)

### 4. `refund_requests` Table Structure:
- `id` (`bigint unsigned`, PK)
- `refund_number` (`string`, unique) — e.g. `REF-2026-000101`
- `payment_id` (`foreignId` -> `payments`)
- `invoice_id` (`foreignId` -> `invoices`, nullable)
- `user_id` (`foreignId` -> `users`)
- `amount` (`decimal 12,2`), `reason` (`text`)
- `status` (`enum`: `'pending'`, `'approved'`, `'rejected'`)
- `approved_by` (`foreignId` -> `users`, nullable)
- `processed_at` (`timestamp`, nullable)

## Phase 7 Schema Extensions:


### 1. `lab_samples` Table Structure:
- `id` (`bigint unsigned`, PK)
- `visit_code` (`string`, unique) — e.g. `VIS-2026-100001` generated sequentially.
- `patient_id` (`foreignId` -> `users`)
- `booking_id` (`foreignId` -> `bookings`, nullable)
- `company_id` (`foreignId` -> `companies`, nullable)
- `contract_id` (`foreignId` -> `contracts`, nullable)
- `assigned_staff_id` (`foreignId` -> `users`, nullable) — Assigned `lab_tech`.
- `sample_status` (`string`, default: `'registered'`) — 9 Stages: `registered`, `assigned`, `sample_collected`, `sent_to_lab`, `received_by_lab`, `processing`, `result_ready`, `report_uploaded`, `delivered`.
- Timestamps: `collected_at`, `sent_to_lab_at`, `received_at`, `processing_at`, `result_ready_at`, `report_uploaded_at`, `delivered_at`.
- `notes` (`text`, nullable)
- `created_at`, `updated_at`

### 2. `medical_reports` Table Structure:
- `id` (`bigint unsigned`, PK)
- `lab_sample_id` (`foreignId` -> `lab_samples`, nullable)
- `patient_id` (`foreignId` -> `users`)
- `booking_id` (`foreignId` -> `bookings`, nullable)
- `company_id` (`foreignId` -> `companies`, nullable)
- `visit_code` (`string`, nullable)
- `file_path` (`string`) — Stored in `private/medical_reports/`
- `file_name` (`string`)
- `file_size` (`bigint unsigned`)
- `mime_type` (`string`, default: `'application/pdf'`)
- `uploaded_by` (`foreignId` -> `users`)
- `verified_by` (`foreignId` -> `users`, nullable)
- `uploaded_at`, `verified_at`, `created_at`, `updated_at`

### 3. `medical_report_versions` Table Structure:
- `id` (`bigint unsigned`, PK)
- `medical_report_id` (`foreignId` -> `medical_reports`)
- `file_path` (`string`)
- `file_name` (`string`)
- `file_size` (`bigint unsigned`)
- `mime_type` (`string`, default: `'application/pdf'`)
- `uploaded_by` (`foreignId` -> `users`)
- `replaced_by` (`foreignId` -> `users`, nullable)
- `reason` (`string`, nullable)
- `created_at`, `updated_at`

### 1. `contracts` Table Modifications:
- `discount_percentage` (`decimal(5,2)`, default: `0.00`) — Contract wide percentage discount fallback.

### 2. `contract_prices` Table Structure:
- `id` (`bigint unsigned`, PK)
- `contract_id` (`foreignId` -> `contracts`)
- `service_id` (`foreignId` -> `services`)
- `custom_price` (`decimal(10,2)`) — Special negotiated contract price for specific service.
- `created_at`, `updated_at`

### 3. `contract_beneficiaries` Table Structure:
- `id` (`bigint unsigned`, PK)
- `company_id` (`foreignId` -> `companies`, nullable)
- `contract_id` (`foreignId` -> `contracts`)
- `patient_id` (`foreignId` -> `users`, nullable) — Auto-linked patient user account.
- `name` (`string`)
- `identification_type` (`string`, default: `'saudi_id'`) — Values: `saudi_id, iqama, border_number, gcc_id`
- `identification_number` (`string`, nullable)
- `phone` (`string`, nullable)
- `employee_id_number` (`string`, nullable)
- `status` (`string`, default: `'active'`)
- `created_at`, `updated_at`

### 4. `bookings` Table Phase 6 Fields:
- `contract_id` (`foreignId` -> `contracts`, nullable)
- `company_id` (`foreignId` -> `companies`, nullable)
- `patient_id` (`foreignId` -> `users`, nullable)

---

## Phase 6 Final Phase Audit Architecture Notes (2026-08-08):

### Booking Number (`bookings.booking_number`):
- **Architecture**: `BK-{YEAR}-{SEQUENCE}` (e.g., `BK-2026-10001`)
- **Generator**: `Booking::boot()` in `app/Models/Booking.php` — 100%00% sequential, collision-safe.
- **Policy**: Never pass `booking_number` manually in `Booking::create()`. Boot handles it.

### Identity Type (`identification_type`):
- **Canonical Values**: `saudi_id` | `iqama` | `border_number` | `gcc_id`
- **Validation**: Enforced via `in:` rule across all controllers.

### No Fake Data & Transaction Safety:
- **Zero Fallback Fake Models**: 0 hardcoded companies/contracts/users created as fallbacks.
- **DB Transactions**: All multi-step catalog & company operations execute within `DB::transaction()` blocks.
