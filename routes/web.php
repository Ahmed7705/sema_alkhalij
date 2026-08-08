<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\InvoiceController;


use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceManagerController;
use App\Http\Controllers\Admin\ProductManagerController;
use App\Http\Controllers\Admin\BookingManagerController;
use App\Http\Controllers\Admin\OrderManagerController;
use App\Http\Controllers\Admin\SettingsManagerController;
use App\Http\Controllers\Admin\UserManagerController;
use App\Http\Controllers\Admin\InventoryManagerController;
use App\Http\Controllers\Admin\SupplierManagerController;
use App\Http\Controllers\Admin\PurchasingManagerController;
use App\Http\Controllers\Admin\PharmacyDispensingController;
use App\Http\Controllers\Admin\InventoryReportController;


/*
|--------------------------------------------------------------------------
| Web Routes — Sema Al-Khalij Medical Services
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\CorporateServicesController;
use App\Http\Controllers\LanguageController;

// Language Switcher
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

// Public Marketing Pages
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/corporate-services', [CorporateServicesController::class, 'index'])->name('corporate-services');
Route::post('/corporate-services', [CorporateServicesController::class, 'storeContractRequest'])->name('corporate-services.store');

Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

Route::get('/blog', function () {
    return view('blog');
})->name('blog');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::match(['get', 'post'], '/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/verify-otp', [VerificationController::class, 'showVerificationForm'])->name('verify.otp.form');
Route::post('/verify-otp', [VerificationController::class, 'verify'])->name('verify.otp');
Route::post('/verify-otp/resend', [VerificationController::class, 'resend'])->name('verify.otp.resend');

// Password Reset Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Social Login Routes (Google & Apple)
Route::get('/auth/{provider}', [SocialAuthController::class, 'redirectToProvider'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('social.callback');

use App\Http\Controllers\AddressController;

// Customer Profile & Portal Routes (Protected by Auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/profile/bookings/{booking}', [ProfileController::class, 'showBooking'])->name('profile.booking-show');
    Route::get('/profile/orders/{order}', [ProfileController::class, 'showOrder'])->name('profile.order-show');

    // Customer Address Management Routes
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::post('/addresses/{address}/set-default', [AddressController::class, 'setDefault'])->name('addresses.set-default');

    // Customer Wishlist Routes
    Route::get('/wishlist', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{wishlistItem}', [\App\Http\Controllers\WishlistController::class, 'destroy'])->name('wishlist.destroy');
});

// Legal Pages
Route::get('/privacy-policy', function () {
    return view('legal.privacy');
})->name('privacy');

Route::get('/terms', function () {
    return view('legal.terms');
})->name('terms');

use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\AuditLogController;

use App\Http\Controllers\Admin\AnalyticsController;

use App\Http\Controllers\Staff\StaffDashboardController;
use App\Http\Controllers\Company\CompanyPortalController;
use App\Http\Controllers\MedicalReportController;

// STAFF OPERATIONS ROUTES (Protected by Auth)
Route::middleware(['auth'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
    Route::post('visits/{booking}/status', [StaffDashboardController::class, 'updateStatus'])->name('visits.update-status');

    // Lab Tech Portal Routes
    Route::get('lab/dashboard', [\App\Http\Controllers\Staff\LabStaffController::class, 'dashboard'])->name('lab.dashboard');
    Route::get('lab/samples/{id}', [\App\Http\Controllers\Staff\LabStaffController::class, 'show'])->name('lab.show');
    Route::post('lab/samples/{id}/status', [\App\Http\Controllers\Staff\LabStaffController::class, 'updateStatus'])->name('lab.status');
});

// CORPORATE COMPANY PORTAL ROUTES (Protected by Auth)
Route::middleware(['auth'])->prefix('company')->name('company.')->group(function () {
    Route::get('portal', [CompanyPortalController::class, 'dashboard'])->name('portal');
    Route::post('requests', [CompanyPortalController::class, 'storeServiceRequest'])->name('requests.store');
    Route::post('beneficiaries', [CompanyPortalController::class, 'storeBeneficiary'])->name('beneficiaries.store');
    Route::get('requests/{booking}/print', [CompanyPortalController::class, 'printServiceRequest'])->name('requests.print');
    Route::get('statement/download', [InvoiceController::class, 'downloadCorporateStatement'])->name('statement.download');
});

// SECURE MEDICAL REPORT ROUTES (Protected by Auth)
Route::middleware(['auth'])->group(function () {
    Route::post('medical-reports/upload', [MedicalReportController::class, 'store'])->name('medical-reports.upload');
    Route::post('medical-reports/{id}/replace', [MedicalReportController::class, 'replace'])->name('medical-reports.replace');
    Route::delete('medical-reports/{id}', [MedicalReportController::class, 'destroy'])->name('medical-reports.destroy');
    Route::get('medical-reports/{report}/download', [MedicalReportController::class, 'download'])->name('medical-reports.download');

    // Financial Invoices, Receipts & Refunds
    Route::get('invoices/{id}/download', [InvoiceController::class, 'downloadPdf'])->name('invoices.download');
    Route::get('receipts/{paymentId}/download', [InvoiceController::class, 'downloadReceipt'])->name('receipts.download');
    Route::post('refunds/request', [\App\Http\Controllers\RefundRequestController::class, 'store'])->name('refunds.store');
});



use App\Http\Controllers\Admin\CompanyManagerController;
use App\Http\Controllers\Admin\ContractRequestManagerController;
use App\Http\Controllers\Admin\StaffManagerController;
use App\Http\Controllers\Admin\ContractManagerController;
use App\Http\Controllers\Admin\BeneficiaryManagerController;

// ADMIN CONTROL PANEL ROUTES (Protected by Auth & Admin Middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Phase 13 Analytics & Reports
    Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

    // Advanced Operations Search
    Route::get('operations/search', function() {
        return view('admin.operations.search');
    })->name('operations.search');

    // Global Search
    Route::get('search', [SearchController::class, 'search'])->name('search');

    // Audit Activity Logs
    Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit.index');

    // Corporate Companies Management
    Route::get('companies', [CompanyManagerController::class, 'index'])->name('companies.index');
    Route::get('companies/create', [CompanyManagerController::class, 'create'])->name('companies.create');
    Route::post('companies', [CompanyManagerController::class, 'store'])->name('companies.store');
    Route::get('companies/{id}', [CompanyManagerController::class, 'show'])->name('companies.show');
    Route::get('companies/{id}/edit', [CompanyManagerController::class, 'edit'])->name('companies.edit');
    Route::put('companies/{id}', [CompanyManagerController::class, 'update'])->name('companies.update');
    Route::post('companies/{id}/toggle', [CompanyManagerController::class, 'toggleStatus'])->name('companies.toggle');
    Route::post('companies/{id}/users', [CompanyManagerController::class, 'addUser'])->name('companies.users.add');
    Route::post('companies/{id}/users/{userId}/detach', [CompanyManagerController::class, 'detachUser'])->name('companies.users.detach');
    Route::post('companies/{id}/users/{userId}/toggle', [CompanyManagerController::class, 'toggleUserStatus'])->name('companies.users.toggle');

    // Corporate Contract Requests Management
    Route::get('contract-requests', [ContractRequestManagerController::class, 'index'])->name('contract-requests.index');
    Route::get('contract-requests/{id}', [ContractRequestManagerController::class, 'show'])->name('contract-requests.show');
    Route::post('contract-requests/{id}/status', [ContractRequestManagerController::class, 'updateStatus'])->name('contract-requests.status');
    Route::post('contract-requests/{id}/convert', [ContractRequestManagerController::class, 'convertToCompany'])->name('contract-requests.convert');

    // Corporate Contracts Management
    Route::get('contracts', [ContractManagerController::class, 'index'])->name('contracts.index');
    Route::get('contracts/create', [ContractManagerController::class, 'create'])->name('contracts.create');
    Route::post('contracts', [ContractManagerController::class, 'store'])->name('contracts.store');
    Route::get('contracts/{id}', [ContractManagerController::class, 'show'])->name('contracts.show');
    Route::get('contracts/{id}/edit', [ContractManagerController::class, 'edit'])->name('contracts.edit');
    Route::put('contracts/{id}', [ContractManagerController::class, 'update'])->name('contracts.update');
    Route::post('contracts/{id}/toggle', [ContractManagerController::class, 'toggleStatus'])->name('contracts.toggle');
    Route::post('contracts/{id}/services', [ContractManagerController::class, 'addService'])->name('contracts.services.add');
    Route::post('contracts/{id}/services/{serviceId}/remove', [ContractManagerController::class, 'removeService'])->name('contracts.services.remove');
    Route::post('contracts/{id}/prices/{priceId}', [ContractManagerController::class, 'updatePrice'])->name('contracts.prices.update');

    // Corporate Beneficiaries Management
    Route::get('beneficiaries', [BeneficiaryManagerController::class, 'index'])->name('beneficiaries.index');
    Route::get('beneficiaries/create', [BeneficiaryManagerController::class, 'create'])->name('beneficiaries.create');
    Route::post('beneficiaries', [BeneficiaryManagerController::class, 'store'])->name('beneficiaries.store');
    Route::get('beneficiaries/{id}', [BeneficiaryManagerController::class, 'show'])->name('beneficiaries.show');
    Route::get('beneficiaries/{id}/edit', [BeneficiaryManagerController::class, 'edit'])->name('beneficiaries.edit');
    Route::put('beneficiaries/{id}', [BeneficiaryManagerController::class, 'update'])->name('beneficiaries.update');
    Route::post('beneficiaries/{id}/toggle', [BeneficiaryManagerController::class, 'toggleStatus'])->name('beneficiaries.toggle');

    // Laboratory Samples Management
    Route::get('lab-samples', [\App\Http\Controllers\Admin\LabSampleManagerController::class, 'index'])->name('lab-samples.index');
    Route::get('lab-samples/create', [\App\Http\Controllers\Admin\LabSampleManagerController::class, 'create'])->name('lab-samples.create');
    Route::post('lab-samples', [\App\Http\Controllers\Admin\LabSampleManagerController::class, 'store'])->name('lab-samples.store');
    Route::get('lab-samples/{id}', [\App\Http\Controllers\Admin\LabSampleManagerController::class, 'show'])->name('lab-samples.show');
    Route::post('lab-samples/{id}/status', [\App\Http\Controllers\Admin\LabSampleManagerController::class, 'updateStatus'])->name('lab-samples.status');
    Route::post('lab-samples/{id}/assign', [\App\Http\Controllers\Admin\LabSampleManagerController::class, 'assignStaff'])->name('lab-samples.assign');

    // Financial Operations & ZATCA E-Invoicing Management
    Route::prefix('finance')->name('finance.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\FinanceManagerController::class, 'dashboard'])->name('dashboard');
        Route::get('/invoices', [\App\Http\Controllers\Admin\FinanceManagerController::class, 'invoices'])->name('invoices.index');
        Route::get('/invoices/{id}', [\App\Http\Controllers\Admin\FinanceManagerController::class, 'showInvoice'])->name('invoices.show');
        Route::post('/invoices/corporate', [\App\Http\Controllers\Admin\FinanceManagerController::class, 'storeCorporateInvoice'])->name('invoices.corporate.store');
        Route::get('/payments', [\App\Http\Controllers\Admin\FinanceManagerController::class, 'payments'])->name('payments.index');
        Route::get('/payments/{id}', [\App\Http\Controllers\Admin\FinanceManagerController::class, 'showPayment'])->name('payments.show');
        Route::get('/refunds', [\App\Http\Controllers\Admin\FinanceManagerController::class, 'refunds'])->name('refunds.index');
        Route::post('/refunds/{id}/approve', [\App\Http\Controllers\Admin\FinanceManagerController::class, 'approveRefund'])->name('refunds.approve');
        Route::post('/refunds/{id}/reject', [\App\Http\Controllers\Admin\FinanceManagerController::class, 'rejectRefund'])->name('refunds.reject');
        Route::get('/vat-report', [\App\Http\Controllers\Admin\FinanceManagerController::class, 'vatReport'])->name('vat-report');
    });

    // Medical Staff Management


    Route::get('staff', [StaffManagerController::class, 'index'])->name('staff.index');
    Route::get('staff/create', [StaffManagerController::class, 'create'])->name('staff.create');
    Route::post('staff', [StaffManagerController::class, 'store'])->name('staff.store');
    Route::get('staff/{id}', [StaffManagerController::class, 'show'])->name('staff.show');
    Route::get('staff/{id}/edit', [StaffManagerController::class, 'edit'])->name('staff.edit');
    Route::put('staff/{id}', [StaffManagerController::class, 'update'])->name('staff.update');
    Route::post('staff/{id}/toggle', [StaffManagerController::class, 'toggleStatus'])->name('staff.toggle');
    
    // Services
    Route::resource('services', ServiceManagerController::class);
    
    // Products
    Route::resource('products', ProductManagerController::class);
    
    // Bookings & Visit Assignment / Verification
    Route::get('bookings', [BookingManagerController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{id}', [BookingManagerController::class, 'show'])->name('bookings.show');
    Route::post('bookings/{id}/assign', [BookingManagerController::class, 'assign'])->name('bookings.assign');
    Route::post('bookings/{id}/verify', [BookingManagerController::class, 'verify'])->name('bookings.verify');
    Route::post('bookings/{id}/status', [BookingManagerController::class, 'updateStatus'])->name('bookings.status');
    
    // Orders
    Route::get('orders', [OrderManagerController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [OrderManagerController::class, 'show'])->name('orders.show');
    Route::post('orders/{id}/status', [OrderManagerController::class, 'updateStatus'])->name('orders.status');
    
    // Settings & CMS
    Route::get('settings', [SettingsManagerController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingsManagerController::class, 'update'])->name('settings.update');
    
    // Inventory, Pharmacy, Purchasing & Stock Operations (Phase 9)
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [InventoryManagerController::class, 'dashboard'])->name('dashboard');
        Route::get('warehouses', [InventoryManagerController::class, 'warehouses'])->name('warehouses.index');
        Route::post('warehouses', [InventoryManagerController::class, 'storeWarehouse'])->name('warehouses.store');
        Route::get('stock', [InventoryManagerController::class, 'stock'])->name('stock.index');
        Route::post('stock/in', [InventoryManagerController::class, 'storeStockIn'])->name('stock.in');
        Route::post('stock/{batchId}/adjust', [InventoryManagerController::class, 'adjustStock'])->name('stock.adjust');
        Route::post('stock/transfer', [InventoryManagerController::class, 'transferStock'])->name('stock.transfer');

        // Suppliers
        Route::get('suppliers', [SupplierManagerController::class, 'index'])->name('suppliers.index');
        Route::post('suppliers', [SupplierManagerController::class, 'store'])->name('suppliers.store');
        Route::get('suppliers/{id}', [SupplierManagerController::class, 'show'])->name('suppliers.show');
        Route::put('suppliers/{id}', [SupplierManagerController::class, 'update'])->name('suppliers.update');

        // Purchasing
        Route::get('purchasing', [PurchasingManagerController::class, 'index'])->name('purchasing.index');
        Route::post('purchasing', [PurchasingManagerController::class, 'store'])->name('purchasing.store');
        Route::get('purchasing/{id}', [PurchasingManagerController::class, 'show'])->name('purchasing.show');
        Route::post('purchasing/{id}/receive', [PurchasingManagerController::class, 'receiveGoods'])->name('purchasing.receive');
        Route::post('purchasing/{id}/cancel', [PurchasingManagerController::class, 'cancel'])->name('purchasing.cancel');

        // Pharmacy Medication Dispensing
        Route::get('pharmacy', [PharmacyDispensingController::class, 'index'])->name('pharmacy.index');
        Route::get('pharmacy/dispense', [PharmacyDispensingController::class, 'create'])->name('pharmacy.dispense');
        Route::post('pharmacy/dispense', [PharmacyDispensingController::class, 'store'])->name('pharmacy.dispense.store');

        // Inventory & Dispensing Reports
        Route::get('reports', [InventoryReportController::class, 'index'])->name('reports.index');
    });


    // Users & Roles
    Route::get('users', [UserManagerController::class, 'index'])->name('users.index');
    Route::post('users/{id}/role', [UserManagerController::class, 'updateRole'])->name('users.role');
    Route::post('users/{id}/toggle', [UserManagerController::class, 'toggleStatus'])->name('users.toggle');
    Route::delete('users/{id}', [UserManagerController::class, 'destroy'])->name('users.destroy');
});

