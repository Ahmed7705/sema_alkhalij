# Phase 7 — Laboratory Operations, Medical Reports & Diagnostics — Implementation Plan

## Goal
Implement a production-grade Laboratory Operations, Medical Reports & Diagnostics module in Sema Al-Khalij CRM. This includes a 9-stage Lab Sample Workflow state machine, secure private PDF report storage & versioning, Lab Tech Staff Portal, Customer Portal lab tracking with interactive timeline, Company Portal lab results integration, real MySQL analytics, and automated PHPUnit tests.

---

## Proposed Changes

### Database & Migrations
#### [NEW] `database/migrations/2026_08_08_000001_add_phase7_laboratory_columns.php`
- Extend `lab_samples` with: `sent_to_lab_at`, `processing_at`, `report_uploaded_at`, `delivered_at`, `notes`.
- Add `medical_report_versions` table for PDF report replacement audit history (`medical_report_id`, `file_path`, `file_name`, `file_size`, `uploaded_by`, `uploaded_at`, `reason`).

---

### Services & State Machine
#### [NEW] `app/Services/LabWorkflowService.php`
- Enforce strict 9-stage workflow sequence:
  `registered` → `assigned` → `sample_collected` → `sent_to_lab` → `received_by_lab` → `processing` → `result_ready` → `report_uploaded` → `delivered`
- Reject invalid transitions with `InvalidArgumentException` / HTTP 422.
- Automatically timestamp stage transitions and trigger notifications & audit logs.

---

### Controllers & Middleware
#### [NEW] `app/Http/Controllers/Admin/LabSampleManagerController.php`
- `index()`: Filterable list by status, date, company, staff, patient.
- `create()` & `store()`: Manual sample creation or auto-creation from booking.
- `show()`: Detailed view with 9-step timeline, sample details, PDF report & version history.
- `updateStatus()`: Validate and process workflow transition.
- `assignStaff()`: Assign `lab_tech` staff to sample.

#### [NEW] `app/Http/Controllers/Staff/LabStaffController.php`
- Lab Tech portal for assigned samples (`assigned_staff_id === auth()->id()`).
- View assigned list, update status, upload/replace PDF report, view timeline.
- Strict isolation preventing access to other technicians' samples.

#### [MODIFY] `app/Http/Controllers/MedicalReportController.php`
- Enforce private storage (`private/medical_reports`).
- `upload()`: Save PDF, set `report_uploaded` status, log `AuditLog`.
- `replace()`: Archive old PDF into `medical_report_versions`, store new PDF, update record.
- `destroy()`: Delete report, update status back to `result_ready`, log `AuditLog`.
- `download()`: Check IDOR permissions (Admin, Patient, Lab Tech, Company Admin). Stream PDF with `AuditLog::log('medical_report_downloaded')`.

---

### Views & UI Components
#### [NEW] `resources/views/admin/lab-samples/index.blade.php`
- Filterable table, search bar, status badges, metrics summary.

#### [NEW] `resources/views/admin/lab-samples/show.blade.php`
- 9-stage interactive timeline step-bar, sample details, assigned staff, upload/replace PDF modal, version history.

#### [NEW] `resources/views/admin/lab-samples/create.blade.php`
- Form for creating lab sample tied to patient, booking, and company.

#### [NEW] `resources/views/staff/lab-portal.blade.php`
- Dedicated Lab Tech Portal for managing assigned samples.

#### [MODIFY] `resources/views/profile.blade.php`
- Customer Portal Lab Samples section with 9-stage timeline and secure PDF Download button.

#### [MODIFY] `resources/views/company/portal.blade.php`
- Company Portal "Lab Samples & Reports" tab with company-isolated data and PDF download.

---

### Routes
#### [MODIFY] `routes/web.php`
- Admin lab sample management routes (`admin.lab-samples.*`).
- Lab Staff portal routes (`staff.lab.*`).
- Medical Report upload/replace/delete/download routes (`medical-reports.*`).
- Company & Customer lab sample routes.

---

### Testing & Verification Plan
#### [NEW] `tests/Feature/Phase7LabOperationsMedicalReportsTest.php`
- 20+ feature tests covering:
  - Admin lab sample CRUD and filtering.
  - 9-stage workflow state machine enforcement & invalid transition rejection.
  - Lab Tech portal isolation and sample management.
  - Customer portal sample view & secure PDF download (only when ready).
  - Company portal isolation for lab samples.
  - Private PDF storage & IDOR protection.
  - Audit logging for all lab and report actions.

---

## Verification Plan

### Automated Tests
- Run `php artisan test --filter=Phase7LabOperationsMedicalReportsTest`
- Run full suite: `php artisan test`

### Route List Verification
- Run `php artisan route:list` to verify route count.
