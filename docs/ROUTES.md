# Registered Routes Matrix — Sema Al-Khalij Medical Services & Operations

Total Routes Registered: **142 Routes** (100% Active & Protected)

## Laboratory Operations & Medical Reports Routes (Phase 7):
- `GET /admin/lab-samples` (`admin.lab-samples.index`) — Admin Lab Samples Directory & Analytics
- `GET /admin/lab-samples/create` (`admin.lab-samples.create`) — Manual Sample Registration Form
- `POST /admin/lab-samples` (`admin.lab-samples.store`) — Save New Lab Sample
- `GET /admin/lab-samples/{id}` (`admin.lab-samples.show`) — 9-Stage Timeline & Sample Detail View
- `POST /admin/lab-samples/{id}/status` (`admin.lab-samples.status`) — Workflow Stage Transition
- `POST /admin/lab-samples/{id}/assign` (`admin.lab-samples.assign`) — Assign Lab Technician
- `GET /staff/lab/dashboard` (`staff.lab.dashboard`) — Lab Technician Portal Dashboard (Assigned Samples)
- `GET /staff/lab/samples/{id}` (`staff.lab.show`) — Lab Technician Sample View & Report Upload
- `POST /staff/lab/samples/{id}/status` (`staff.lab.status`) — Lab Technician Status Update
- `POST /medical-reports/upload` (`medical-reports.upload`) — Upload Medical PDF Report
- `POST /medical-reports/{id}/replace` (`medical-reports.replace`) — Replace PDF Report & Save Version Audit
- `DELETE /medical-reports/{id}` (`medical-reports.destroy`) — Delete PDF Report
- `GET /medical-reports/{report}/download` (`medical-reports.download`) — Stream Private Medical PDF (IDOR Protected & Audit Logged)
- `GET /admin/contracts` (`admin.contracts.index`) — Admin Contracts Directory
- `GET /admin/contracts/create` (`admin.contracts.create`) — New Contract Setup Form
- `POST /admin/contracts` (`admin.contracts.store`) — Save New Contract
- `GET /admin/contracts/{id}` (`admin.contracts.show`) — Multi-tab Contract Detail View
- `GET /admin/contracts/{id}/edit` (`admin.contracts.edit`) — Edit Contract Form
- `PUT /admin/contracts/{id}` (`admin.contracts.update`) — Update Contract Details
- `POST /admin/contracts/{id}/toggle` (`admin.contracts.toggle`) — Toggle Contract Status
- `POST /admin/contracts/{id}/services` (`admin.contracts.services.add`) — Attach Covered Service & Custom Price
- `POST /admin/contracts/{id}/services/{serviceId}/remove` (`admin.contracts.services.remove`) — Remove Covered Service
- `POST /admin/contracts/{id}/prices/{priceId}` (`admin.contracts.prices.update`) — Update Custom Contract Price

## Corporate Beneficiaries Routes (Admin):
- `GET /admin/beneficiaries` (`admin.beneficiaries.index`) — Admin Beneficiaries Directory
- `GET /admin/beneficiaries/create` (`admin.beneficiaries.create`) — New Beneficiary Enrollment Form
- `POST /admin/beneficiaries` (`admin.beneficiaries.store`) — Save New Beneficiary
- `GET /admin/beneficiaries/{id}` (`admin.beneficiaries.show`) — Beneficiary Details View
- `GET /admin/beneficiaries/{id}/edit` (`admin.beneficiaries.edit`) — Edit Beneficiary Form
- `PUT /admin/beneficiaries/{id}` (`admin.beneficiaries.update`) — Update Beneficiary Information
- `POST /admin/beneficiaries/{id}/toggle` (`admin.beneficiaries.toggle`) — Toggle Beneficiary Active Status

## Company Portal & Request Voucher Routes (Company):
- `GET /company/portal` (`company.portal`) — Corporate Portal Dashboard (Overview, Requests, Contracts, Beneficiaries)
- `POST /company/requests` (`company.requests.store`) — Corporate Service Request Submission
- `POST /company/beneficiaries` (`company.beneficiaries.store`) — Portal Beneficiary Registration
- `GET /company/requests/{booking}/print` (`company.requests.print`) — Printable Corporate Service Request Voucher
