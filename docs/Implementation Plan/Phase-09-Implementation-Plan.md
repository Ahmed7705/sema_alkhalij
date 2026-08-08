# Phase 9 Implementation Plan — Inventory, Pharmacy, Purchasing & Stock Operations

**Project Name**: Sema Al-Khalij Medical Services & Operations  
**Phase**: Phase 9 — Inventory, Pharmacy, Purchasing & Stock Operations  
**Target Completion**: 2026-08-08  
**Status**: 🚀 IN PROGRESS

---

## 1. Overview & Business Objectives

Phase 9 introduces an enterprise-grade Pharmacy, Inventory, Purchasing, and Stock Operations infrastructure for Sema Al-Khalij Medical Services. The system enables multi-warehouse inventory management, batch & expiry date tracking, purchasing workflows, supplier relations, and FEFO (First Expired, First Out) pharmacy medication dispensing linked directly to home visits and patient prescriptions.

---

## 2. Core Functional Modules

### 1. Multi-Warehouse & Item Inventory Management
- **Warehouses Directory**: Multi-store support (e.g., Central Medical Store, Home Care Pharmacy, Mobile Fleet Clinic) with active status and location tracking.
- **Item & Batch Tracking**: SKU, Barcode, Batch Number, Expiry Date, Buy Price, Sell Price, Reorder Level, Current Stock, Reserved Stock, Available Stock.
- **Stock Movement History**: Detailed audit trail for `stock_in`, `stock_out`, `transfer`, `dispense`, `adjustment`, `damaged`, `expired`.

### 2. Supplier Management & Purchasing Workflow
- **Supplier Directory**: Full CRUD, contacts, CR Number, VAT Registration Number, address, and purchasing history.
- **Purchasing Workflow**: `Purchase Request` → `Purchase Order` → `Goods Receiving (Stock In)` → `Inventory Updated` → `Available for Dispensing`.
- **Partial Receiving Support**: Partial goods receiving and supplier invoice linkage.

### 3. FEFO Pharmacy Medication Dispensing
- **Visit & Prescription Dispensing**: Dispense medications for patient home visits and medical bookings.
- **Automatic Stock Deduction**: Automatically deducts quantities from earliest-expiring batch (FEFO algorithm).
- **Over-Dispense Prevention**: Server-side validation strictly prevents dispensing more than available batch stock.

### 4. Stock Alerts & Comprehensive Financial Reports
- **Alert Widgets**: Low stock warnings, Out of stock alerts, Expired soon (within 30/60/90 days), and Expired items dashboard widgets.
- **Reports**: Inventory Valuation Report, Stock Movement History, Expiry Date Audit, Purchase Order Summary, Supplier Activity, and Medication Dispensing Report.

---

## 3. Database Schema Design (`database/migrations/2026_08_09_000001_create_phase9_inventory_pharmacy_tables.php`)

1. **`warehouses`**: `id`, `name_ar`, `name_en`, `code`, `city`, `address`, `is_main`, `is_active`, `created_at`, `updated_at`.
2. **`suppliers`**: `id`, `name`, `code`, `contact_name`, `phone`, `email`, `cr_number`, `vat_number`, `address`, `status`, `created_at`, `updated_at`.
3. **`batches`**: `id`, `product_id`, `warehouse_id`, `batch_number`, `expiry_date`, `quantity`, `reserved_quantity`, `buy_price`, `sell_price`, `created_at`, `updated_at`.
4. **`stock_movements`**: `id`, `movement_number`, `product_id`, `batch_id`, `from_warehouse_id`, `to_warehouse_id`, `type`, `quantity`, `user_id`, `reference_type`, `reference_id`, `notes`, `created_at`, `updated_at`.
5. **`purchase_requests`**: `id`, `request_number`, `user_id`, `warehouse_id`, `supplier_id`, `status`, `total_estimated_amount`, `notes`, `created_at`, `updated_at`.
6. **`purchase_orders`**: `id`, `po_number`, `request_id`, `supplier_id`, `warehouse_id`, `user_id`, `status`, `subtotal`, `vat_amount`, `total_amount`, `notes`, `created_at`, `updated_at`.
7. **`purchase_order_items`**: `id`, `purchase_order_id`, `product_id`, `quantity_ordered`, `quantity_received`, `unit_price`, `total_amount`, `created_at`, `updated_at`.
8. **`medication_dispenses`**: `id`, `dispense_number`, `booking_id`, `patient_id`, `doctor_id`, `dispensed_by`, `warehouse_id`, `notes`, `created_at`, `updated_at`.
9. **`medication_dispense_items`**: `id`, `dispense_id`, `product_id`, `batch_id`, `quantity`, `unit_price`, `total_price`, `created_at`, `updated_at`.

---

## 4. Audit Log Events

- `CREATE_PRODUCT`
- `UPDATE_PRODUCT`
- `DELETE_PRODUCT`
- `STOCK_IN`
- `STOCK_OUT`
- `STOCK_TRANSFER`
- `STOCK_ADJUSTMENT`
- `DISPENSE_MEDICATION`
- `CREATE_PURCHASE_ORDER`
- `RECEIVE_PURCHASE`
- `CANCEL_PURCHASE`

---

## 5. Verification & Test Suite

- Feature test file: `tests/Feature/Phase9InventoryPharmacyPurchasingTest.php`.
- Full PHPUnit test suite verification.
- Route list compilation.
