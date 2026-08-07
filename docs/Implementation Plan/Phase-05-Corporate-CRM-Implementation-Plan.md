# Phase 5 Implementation Plan — Corporate CRM & Contract Requests

This plan outlines the technical design, database schema additions, admin controllers, views, corporate workflow state machine, atomic request-to-company conversion, company data isolation, and automated feature test suite for **Phase 5 — Corporate CRM & Contract Requests**.

## User Review Required

> [!IMPORTANT]
> - **Company Data Isolation & IDOR Protection**: Server-side scoping enforces that corporate users (`company_admin`, `company_operator`) can only access data belonging strictly to their assigned `company_id`. Attempts to access another company's portal or data return HTTP 403 Forbidden.
> - **Atomic Request-to-Company Conversion**: Approved contract requests (`status = approved`) can be converted into a real `Company` entity inside a database transaction (`DB::transaction`). Duplicate CR numbers and double-conversions are blocked with strict server-side validation.
> - **Company Soft Status Control**: Inactive or suspended companies preserve all historical contracts, beneficiaries, and visits; hard deletion is prohibited when operational records exist.
> - **100% Bilingual (Arabic/English) UI**: All new Phase 5 admin views support full Arabic RTL and English LTR without hardcoded strings or mixed languages.

---

## Gap Matrix Summary

| Requirement | Backend | Database | Admin UI | Route | Permission | Real Data | Action Required |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| **Companies Management** | Missing `CompanyManagerController` | Missing `company_code`, `contact_person` | Missing `admin/companies/*` Blade views | Missing `/admin/companies` | `admin` protected | Real MySQL | Create controller, views, routes |
| **Company Standalone Details** | Missing `show()` in `CompanyManagerController` | Complete | Missing `admin/companies/show.blade.php` | Missing `/admin/companies/{id}` | `admin` protected | Real MySQL | Create multi-tab view (Overview, Users, Contracts, Beneficiaries, Visits, History) |
| **Company Users Management** | Missing user link/role actions | Complete (`users.company_id`) | Missing user tab & forms | Missing `/admin/companies/{id}/users/*` | `admin` protected | Real MySQL | Add company user management actions |
| **Contract Requests Register** | Missing `ContractRequestManagerController` | Needs `rejection_reason`, `converted_company_id`, review timestamps | Missing `admin/contract-requests/*` views | Missing `/admin/contract-requests` | `admin` protected | Real MySQL | Create controller, views, routes |
| **Contract Request Workflow** | Missing state machine (`new` → `under_review` → `approved`/`rejected`) | Complete | Action buttons in details view | Missing status update routes | `admin` protected | Real MySQL | Enforce Server-Side workflow transitions and rejection reasons |
| **Convert Request to Company** | Missing DB transaction conversion logic | Needs `contract_request_id` relationship | Action button on approved view | Missing `/admin/contract-requests/{id}/convert` | `admin` protected | Real MySQL | Implement atomic conversion preventing duplicate CR / double conversion |
| **Company Data Isolation** | Needs strict scoping in `CompanyPortalController` | Complete | Complete | Portal routes protected | Server-Side Policy check | Real MySQL | Enforce Server-Side isolation blocking cross-company access |
| **Audit Logging & Sidebar** | Log all Phase 5 actions | Complete (`audit_logs`) | Admin Sidebar update | Complete | `admin` protected | Real MySQL | Log all Phase 5 sensitive actions & update Admin Sidebar |

---

## Proposed Changes

### Database & Migrations

#### [NEW] [2026_08_07_000001_add_phase5_corporate_crm_columns.php](file:///e:/Saudi/Jazan/Other%20projects/Sema-Alkhalij/code/database/migrations/2026_08_07_000001_add_phase5_corporate_crm_columns.php)
- Add `company_code` (unique, nullable), `contact_person` (nullable), `contract_request_id` (nullable) to `companies` table.
- Add `rejection_reason` (nullable), `reviewed_by` (nullable), `reviewed_at` (nullable), `approved_by` (nullable), `approved_at` (nullable), `converted_company_id` (nullable) to `contract_requests` table.

---

### Models & Services

#### [MODIFY] [Company.php](file:///e:/Saudi/Jazan/Other%20projects/Sema-Alkhalij/code/app/Models/Company.php)
- Add fillable fields (`company_code`, `contact_person`, `contract_request_id`).
- Add relationships: `contractRequest()`, `activeContract()`, `contracts()`, `users()`, `bookings()`.

#### [MODIFY] [ContractRequest.php](file:///e:/Saudi/Jazan/Other%20projects/Sema-Alkhalij/code/app/Models/ContractRequest.php)
- Add fillable fields (`rejection_reason`, `reviewed_by`, `reviewed_at`, `approved_by`, `approved_at`, `converted_company_id`).
- Add relationships: `convertedCompany()`, `reviewedBy()`, `approvedBy()`.

---

### Admin Controllers

#### [NEW] [CompanyManagerController.php](file:///e:/Saudi/Jazan/Other%20projects/Sema-Alkhalij/code/app/Http/Controllers/Admin/CompanyManagerController.php)
- `index()`: Filtered companies listing with search (name, CR #, contact, city), status filter, pagination.
- `create()` & `store()`: Create company with CR number uniqueness validation.
- `show()`: Multi-tab view displaying real metrics (active contracts, beneficiaries count, total visits, completed visits), users, contracts, beneficiaries, and visits.
- `edit()` & `update()`: Edit company details.
- `toggleStatus()`: Activate/deactivate company without hard-deleting records.
- `addUser()`, `detachUser()`, `toggleUserStatus()`: Company user management.

#### [NEW] [ContractRequestManagerController.php](file:///e:/Saudi/Jazan/Other%20projects/Sema-Alkhalij/code/app/Http/Controllers/Admin/ContractRequestManagerController.php)
- `index()`: Filtered list of public contract requests (search, status filter, date range, pagination).
- `show()`: Contract request detail view displaying submitted details, expected beneficiaries, notes, review status, and conversion button.
- `updateStatus()`: Transition status (`new` → `under_review`, `under_review` → `rejected` with rejection reason, `under_review` → `approved`).
- `convertToCompany()`: Atomic `DB::transaction` converting approved request to a real `Company` record, generating `company_code`, linking IDs, logging Audit Log, preventing duplicate conversions or duplicate CR numbers.

#### [MODIFY] [CompanyPortalController.php](file:///e:/Saudi/Jazan/Other%20projects/Sema-Alkhalij/code/app/Http/Controllers/Company/CompanyPortalController.php)
- Enforce strict server-side scoping so corporate users (`company_admin`, `company_operator`) are isolated to their own `company_id`.

---

### Blade Views & Layouts

#### [NEW] [admin/companies/index.blade.php](file:///e:/Saudi/Jazan/Other%20projects/Sema-Alkhalij/code/resources/views/admin/companies/index.blade.php)
- 100% bilingual companies register with search, status filters, metrics, and actions.

#### [NEW] [admin/companies/create.blade.php](file:///e:/Saudi/Jazan/Other%20projects/Sema-Alkhalij/code/resources/views/admin/companies/create.blade.php) & [admin/companies/edit.blade.php](file:///e:/Saudi/Jazan/Other%20projects/Sema-Alkhalij/code/resources/views/admin/companies/edit.blade.php)
- Forms for creating and editing company records.

#### [NEW] [admin/companies/show.blade.php](file:///e:/Saudi/Jazan/Other%20projects/Sema-Alkhalij/code/resources/views/admin/companies/show.blade.php)
- Standalone multi-tab view (Overview metrics, Users management, Contracts, Beneficiaries, Service Visits, History).

#### [NEW] [admin/contract-requests/index.blade.php](file:///e:/Saudi/Jazan/Other%20projects/Sema-Alkhalij/code/resources/views/admin/contract-requests/index.blade.php)
- Contract requests directory table.

#### [NEW] [admin/contract-requests/show.blade.php](file:///e:/Saudi/Jazan/Other%20projects/Sema-Alkhalij/code/resources/views/admin/contract-requests/show.blade.php)
- Contract request detail page with workflow action buttons and conversion trigger.

#### [MODIFY] [layouts/admin.blade.php](file:///e:/Saudi/Jazan/Other%20projects/Sema-Alkhalij/code/resources/views/layouts/admin.blade.php)
- Update Admin Sidebar under **Corporate**: link `Companies` to `route('admin.companies.index')` and `Contract Requests` to `route('admin.contract-requests.index')`.

---

### Routes & Middleware

#### [MODIFY] [routes/web.php](file:///e:/Saudi/Jazan/Other%20projects/Sema-Alkhalij/code/routes/web.php)
- Register admin routes for companies and contract requests:
  - `GET /admin/companies` (`admin.companies.index`)
  - `GET /admin/companies/create` (`admin.companies.create`)
  - `POST /admin/companies` (`admin.companies.store`)
  - `GET /admin/companies/{id}` (`admin.companies.show`)
  - `GET /admin/companies/{id}/edit` (`admin.companies.edit`)
  - `PUT /admin/companies/{id}` (`admin.companies.update`)
  - `POST /admin/companies/{id}/toggle` (`admin.companies.toggle`)
  - `POST /admin/companies/{id}/users` (`admin.companies.users.add`)
  - `POST /admin/companies/{id}/users/{userId}/detach` (`admin.companies.users.detach`)
  - `GET /admin/contract-requests` (`admin.contract-requests.index`)
  - `GET /admin/contract-requests/{id}` (`admin.contract-requests.show`)
  - `POST /admin/contract-requests/{id}/status` (`admin.contract-requests.status`)
  - `POST /admin/contract-requests/{id}/convert` (`admin.contract-requests.convert`)

---

## Verification Plan

### Automated Tests
Create `tests/Feature/Phase5CorporateCRMTest.php` with 24 comprehensive feature tests:
1. `admin_can_view_companies`
2. `admin_can_create_company`
3. `admin_can_update_company`
4. `duplicate_cr_number_is_rejected`
5. `admin_can_activate_deactivate_company`
6. `company_details_show_real_relationships`
7. `admin_can_manage_company_users`
8. `unauthorized_roles_cannot_access_corporate_admin`
9. `contract_request_submitted_from_public_site_appears_in_admin`
10. `admin_can_view_request_details`
11. `new_to_under_review_works`
12. `under_review_to_approved_works`
13. `under_review_to_rejected_works`
14. `invalid_workflow_transition_is_rejected`
15. `approved_request_can_be_converted_to_company`
16. `same_request_cannot_be_converted_twice`
17. `duplicate_company_is_prevented`
18. `failed_conversion_rolls_back_transaction`
19. `company_a_cannot_access_company_b_data`
20. `audit_logs_are_created_for_sensitive_actions`
21. `inactive_company_user_cannot_use_restricted_company_functionality`
22. `arabic_phase5_ui_works_correctly_in_rtl`
23. `english_phase5_ui_works_correctly_in_ltr`
24. `authorization_is_enforced_server_side`

Command to run tests:
```powershell
$env:PATH = "C:\xampp\php;C:\ProgramData\ComposerSetup\bin;" + $env:PATH
php artisan test --filter=Phase5CorporateCRMTest
```

### Manual Verification Scenarios
- **Scenario A**: Submit contract request on `/corporate-services` -> verify it appears in `/admin/contract-requests` -> transition `under_review` -> `approved` -> click `Create Company from Request` -> verify redirect to `/admin/companies/{id}` with transferred data & audit log.
- **Scenario B**: Transition contract request to `rejected` with rejection reason -> verify reason stored and company creation disabled.
- **Scenario C**: Create company manually in `/admin/companies/create` -> add company user -> verify user login and corporate portal scoping.
- **Scenario D**: Deactivate company -> verify data remains intact in database without loss of contracts/visits.
- **Scenario E**: Switch language (AR / EN) -> verify full RTL / LTR layout without mixed language labels.
