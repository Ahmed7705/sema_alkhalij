# Database Schema — Sema Al-Khalij Medical Services & Operations

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
