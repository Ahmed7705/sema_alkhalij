# Database Schema — Sema Al-Khalij Medical Services & Operations

## Phase 6 Schema Extensions:

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

## Phase 6 Final Bug Fix Architecture Notes (2026-08-08):

### Booking Number (`bookings.booking_number`):
- **Architecture**: `BK-{YEAR}-{SEQUENCE}` (e.g., `BK-2026-10001`)
- **Generator**: `Booking::boot()` in `app/Models/Booking.php` — sequential, collision-safe.
- **Policy**: Never pass `booking_number` manually in `Booking::create()`. Boot handles it.

### Identity Type (`identification_type`):
- **Canonical Values**: `saudi_id` | `iqama` | `border_number` | `gcc_id`
- **Note**: `border_no` was a legacy inconsistency — corrected to `border_number` across all controllers and views.
- **No `passport`** unless explicitly added in future requirements.

### No Fake Data Policy:
- **Prohibited**: `Company::create()`, `Contract::create()` as fallbacks in Production Controllers.
- **When no companies exist**: Show `company/portal-no-company.blade.php` empty state.
- **When no active contract**: Show warning banner in `company/portal.blade.php`; disable service request submission.
