# Changelog — Sema Al-Khalij Medical Services

## Phase 4 — Medical Staff Management & Staff Operations Portal (2026-08-07)
- **Added**: `Admin\StaffManagerController` with `/admin/staff` directory, search, role filters, creation (`/admin/staff/create`), edit (`/admin/staff/{id}/edit`), show (`/admin/staff/{id}`), and active status toggle (`/admin/staff/{id}/toggle`).
- **Added**: Standalone Admin Visit Management (`/admin/bookings/{id}`) displaying patient identification, service details, corporate contract, active practitioner assignment/reassignment form, and real audit timeline.
- **Added**: Server-Side Workflow State Machine (`requested` → `assigned` → `accepted` → `in_progress` → `completed` → `verified`).
- **Added**: Supervisor Verification action (`/admin/bookings/{id}/verify`) restricted to admins, managers, and customer service supervisors.
- **Added**: Admin Sidebar links for Medical Staff (`admin.staff.index`) and Patients/Customers (`admin.users.index`).
- **Added**: `tests/Feature/Phase4MedicalStaffOperationsTest.php` with 18 feature tests.
- **Result**: 55 / 55 tests passing cleanly across full test suite.
