# Database Schema — Sema Al-Khalij Medical Services

## Key Tables for Medical Staff & Operations:

### 1. `staff_profiles`
- `id` (bigint, primary key)
- `user_id` (foreignKey -> `users.id`, onDelete cascade)
- `staff_type` (varchar: `doctor`, `nurse`, `physio`, `lab_tech`, `customer_service`, `manager`)
- `specialty` (varchar, nullable)
- `license_number` (varchar, nullable)
- `job_title` (varchar, nullable)
- `is_active` (boolean, default true)
- `timestamps`

### 2. `bookings` (Assignment & Workflow Columns)
- `assigned_provider_id` (foreignKey -> `users.id`, nullable)
- `assigned_by` (foreignKey -> `users.id`, nullable)
- `assigned_at` (timestamp, nullable)
- `accepted_at` (timestamp, nullable)
- `started_at` (timestamp, nullable)
- `completed_at` (timestamp, nullable)
- `verified_at` (timestamp, nullable)
- `verified_by` (foreignKey -> `users.id`, nullable)
- `status` (varchar: `requested`, `assigned`, `accepted`, `in_progress`, `completed`, `verified`, `cancelled`)

### 3. `audit_logs`
- `id` (bigint, primary key)
- `user_id` (foreignKey -> `users.id`, nullable)
- `action` (varchar)
- `model_type` (varchar, nullable)
- `model_id` (bigint, nullable)
- `old_values` (text, nullable)
- `new_values` (text, nullable)
- `ip_address` (varchar)
- `user_agent` (varchar)
