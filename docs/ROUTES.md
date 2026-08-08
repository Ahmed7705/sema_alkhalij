# Registered Routes Matrix — Sema Al-Khalij Medical Services & Operations

Total Routes Registered: **168 Routes** (100% Active & Protected)

## Inventory, Pharmacy, Purchasing & Stock Operations Routes (Phase 9):
- `GET /admin/inventory` (`admin.inventory.dashboard`) — Admin Inventory Dashboard, Real-time KPIs & Low/Expiring Stock Alerts
- `GET /admin/inventory/warehouses` (`admin.inventory.warehouses.index`) — Multi-Warehouse Locations Directory
- `POST /admin/inventory/warehouses` (`admin.inventory.warehouses.store`) — Create New Warehouse / Store
- `GET /admin/inventory/stock` (`admin.inventory.stock.index`) — Stock Batches Directory & FEFO Expiry Status
- `POST /admin/inventory/stock/in` (`admin.inventory.stock.in`) — Stock-in Manual Batch Entry
- `POST /admin/inventory/stock/{batchId}/adjust` (`admin.inventory.stock.adjust`) — Adjust Stock Batch Quantity & Audit Log
- `POST /admin/inventory/stock/transfer` (`admin.inventory.stock.transfer`) — Inter-Warehouse Stock Transfer
- `GET /admin/inventory/suppliers` (`admin.inventory.suppliers.index`) — Medical Suppliers Directory & Registration
- `POST /admin/inventory/suppliers` (`admin.inventory.suppliers.store`) — Create New Supplier Profile
- `GET /admin/inventory/suppliers/{id}` (`admin.inventory.suppliers.show`) — Supplier Profile & Order History
- `PUT /admin/inventory/suppliers/{id}` (`admin.inventory.suppliers.update`) — Update Supplier Profile
- `GET /admin/inventory/purchasing` (`admin.inventory.purchasing.index`) — Purchase Orders Directory & Lifecycle
- `POST /admin/inventory/purchasing` (`admin.inventory.purchasing.store`) — Create New Purchase Order (`PO-YYYY-NNNN`)
- `GET /admin/inventory/purchasing/{id}` (`admin.inventory.purchasing.show`) — Purchase Order Detail & Item Breakdown
- `POST /admin/inventory/purchasing/{id}/receive` (`admin.inventory.purchasing.receive`) — Receive Goods & Auto Generate Batches
- `POST /admin/inventory/purchasing/{id}/cancel` (`admin.inventory.purchasing.cancel`) — Cancel Purchase Order
- `GET /admin/inventory/pharmacy` (`admin.inventory.pharmacy.index`) — Pharmacy Medication Dispensing Directory
- `GET /admin/inventory/pharmacy/dispense` (`admin.inventory.pharmacy.dispense`) — New Prescription Dispensing Form (FEFO Auto Selection)
- `POST /admin/inventory/pharmacy/dispense` (`admin.inventory.pharmacy.dispense.store`) — Execute Medication Dispensing & Auto Stock Deduction
- `GET /admin/inventory/reports` (`admin.inventory.reports.index`) — Inventory Valuation, Movement & Dispensing Reports


## Financial Operations, Invoicing & ZATCA Routes (Phase 8):
- `GET /admin/finance` (`admin.finance.dashboard`) — Admin Financial Dashboard KPIs & Revenue Analytics
- `GET /admin/finance/invoices` (`admin.finance.invoices.index`) — Tax Invoices Register & ZATCA Status Filter
- `GET /admin/finance/invoices/{id}` (`admin.finance.invoices.show`) — Invoice Detail & Payment History View
- `POST /admin/finance/invoices/corporate` (`admin.finance.invoices.corporate.store`) — Issue Corporate Contract Claim Invoice
- `GET /admin/finance/payments` (`admin.finance.payments.index`) — Payment Transactions History & Gateway Ref
- `GET /admin/finance/payments/{id}` (`admin.finance.payments.show`) — Payment Detail View & Gateway Response Payload
- `GET /admin/finance/refunds` (`admin.finance.refunds.index`) — Pending Refund Requests Management Directory
- `POST /admin/finance/refunds/{id}/approve` (`admin.finance.refunds.approve`) — Approve Refund Request & Update Payment/Invoice Statuses
- `POST /admin/finance/refunds/{id}/reject` (`admin.finance.refunds.reject`) — Reject Customer Refund Request
- `GET /admin/finance/vat-report` (`admin.finance.vat-report`) — ZATCA 15% VAT Tax Compliance Summary & Report
- `GET /invoices/{id}/download` (`invoices.download`) — Download Printable Tax Invoice PDF with TLV Base64 QR Code
- `GET /receipts/{paymentId}/download` (`receipts.download`) — Download Official Payment Receipt PDF (سند قبض)
- `GET /company/statement/download` (`company.statement.download`) — Download Official Corporate Account Statement PDF (كشف حساب)
- `POST /refunds/request` (`refunds.store`) — Submit Customer Refund Request Form

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
