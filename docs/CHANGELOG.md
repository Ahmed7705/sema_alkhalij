# Changelog — Sema Al-Khalij Medical Services

## [2026-08-04] — CRM, Medical Operations, Corporate Management & Lab Sample Tracking

### Added:
- **Database Architecture**: Executed 3 new migration files creating `staff_profiles`, `companies`, `contract_requests`, `contracts`, `contract_prices`, `contract_beneficiaries`, `lab_samples`, and `medical_reports` tables.
- **Service Assignment Engine**: `ServiceAssignmentService` validating state transitions (`requested` → `assigned` → `accepted` → `in_progress` → `completed` → `verified`) with audit trail.
- **Patient Identification Support**: Integrated Saudi National ID, Iqama, Border Number, and GCC ID fields in users and bookings.
- **Staff Operations Dashboard**: Added `/staff/dashboard` for medical providers to track, accept, start, and complete assigned visits.
- **Corporate CRM & Company Portal**: Added `/company/portal` for company managers to submit service requests for beneficiaries with server-side contract pricing.
- **Company Security Isolation**: Added `CompanyPolicy` enforcing strict company data isolation against IDOR vulnerabilities.
- **Laboratory Tracking & Visit Codes**: `VisitCodeGeneratorService` generating unique visit codes (`VIS-YYYY-XXXXXX`) using DB transaction locking.
- **Secure Medical PDF Reports**: Added `MedicalReportController` storing medical PDFs in private storage (`storage/app/private/medical_reports/`) with authorized streaming download route and audit logging.
- **Advanced Operational Search**: Added Livewire `AdvancedOperationsSearch` component (`/admin/operations/search`) with composite filters by request, visit code, ID, company, staff, status, and dates.
