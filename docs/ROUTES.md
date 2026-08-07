# Registered Routes Matrix — Sema Al-Khalij Medical Services & Operations

Total Routes Registered: **131 Routes** (100% Active & Protected)

## Corporate Contracts Routes (Admin):
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
