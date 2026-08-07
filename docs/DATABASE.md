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
- `identification_type` (`string`, default: `'saudi_id'`)
- `identification_number` (`string`, nullable)
- `phone` (`string`, nullable)
- `employee_id_number` (`string`, nullable)
- `status` (`string`, default: `'active'`)
- `created_at`, `updated_at`

### 4. `bookings` Table Phase 6 Fields:
- `contract_id` (`foreignId` -> `contracts`, nullable)
- `company_id` (`foreignId` -> `companies`, nullable)
- `patient_id` (`foreignId` -> `users`, nullable)
