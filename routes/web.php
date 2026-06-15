<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TenantPaymentController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\TenantDashboardController;
use App\Http\Controllers\TenantComplaintController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\ReminderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ExtensionController;
use App\Http\Controllers\Admin\ExtensionController as AdminExtensionController;

// ============================================================
// 1. PUBLIC PAGES
// ============================================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/rooms', [HomeController::class, 'rooms'])->name('rooms');
Route::get('/rooms/{id}', [HomeController::class, 'roomDetail'])->name('rooms.show');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'sendContact'])->name('contact.send');
// ============================================================
// 2. AUTH PAGES
// ============================================================
Route::view('/login', 'auth.login')->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post')->middleware('throttle:5,1');
Route::view('/register', 'auth.register')->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 2.1 EMAIL VERIFICATION
Route::middleware('auth')->group(function () {
    Route::view('/email/verify', 'auth.verify-email')->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('home')->with('success', 'Email berhasil diverifikasi! Selamat datang.');
    })->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

    Route::post('/email/resend', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Link verifikasi telah dikirim ulang ke email Anda.');
    })->middleware('throttle:6,1')->name('verification.send');

    Route::get('/dashboard', [TenantDashboardController::class, 'index'])
    ->name('tenant.dashboard');
});

// ============================================================
// WEBHOOK MIDTRANS (di luar auth, tidak perlu CSRF) udah ga pake midtrans
// ============================================================
// Route::post('/payments/webhook', [TenantPaymentController::class, 'webhook'])->name('payments.webhook');

// Route::post('/booking/webhook', [BookingController::class, 'webhook'])->name('booking.webhook');

Route::post('/chatbot/message', [App\Http\Controllers\ChatbotController::class, 'message'])->name('chatbot.message');



// ============================================================
// 3. PROTECTED ROUTES
// ============================================================
Route::middleware(['auth', 'verified'])->group(function () {

    // --- BOOKING (Tenant) ---
    Route::prefix('booking')->name('booking.')->group(function () {
    Route::get('/create',                [BookingController::class, 'create'])      ->name('create');
    Route::post('/store',                [BookingController::class, 'store'])       ->name('store');
    Route::get('/upload-dp/{booking}',   [BookingController::class, 'uploadDp'])    ->name('upload-dp');
    Route::get('/upload-dp/{booking}/proof', [BookingController::class, 'uploadDpProof'])->name('upload-dp-proof');
    Route::post('/upload-dp/{booking}/proof', [BookingController::class, 'storeDpProof']) ->name('store-dp-proof');
    Route::get('/confirmation/{booking}',[BookingController::class, 'confirmation'])->name('confirmation');
    Route::get('/status',                [BookingController::class, 'status'])      ->name('status');
});

    // --- PAYMENTS (Tenant) ---
    Route::prefix('payments')->name('payments.')->group(function () {
    Route::get('/',                   [TenantPaymentController::class, 'index'])      ->name('index');
    Route::get('/my-payments',        [TenantPaymentController::class, 'myPayments']) ->name('my');
    Route::get('/{id}/pay',           [TenantPaymentController::class, 'qris'])       ->name('pay');
    Route::get('/{id}/upload-proof',  [TenantPaymentController::class, 'uploadProof'])->name('upload-proof');
    Route::post('/{id}/upload-proof', [TenantPaymentController::class, 'storeProof']) ->name('store-proof');
    Route::get('/{id}',               [TenantPaymentController::class, 'show'])       ->name('show');
});

   // --- COMPLAINTS (Tenant) ---
Route::prefix('tenant/complaints')->name('tenant.complaints.')->group(function () {
    Route::get('/',       [TenantComplaintController::class, 'index'])       ->name('index');
    Route::get('/create', [TenantComplaintController::class, 'create'])      ->name('create');
    Route::post('/',      [TenantComplaintController::class, 'store'])       ->name('store');
    Route::get('/my',     [TenantComplaintController::class, 'myComplaints'])->name('my');
    Route::get('/{id}',   [TenantComplaintController::class, 'show'])        ->name('show');
});


    // --- PROFILE (Tenant) ---
    

Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/',               [ProfileController::class, 'index'])          ->name('index');
    Route::get('/edit',           [ProfileController::class, 'edit'])           ->name('edit');
    Route::put('/update',         [ProfileController::class, 'update'])         ->name('update');
    Route::put('/update-password',[ProfileController::class, 'updatePassword']) ->name('update.password');
});

// --- CHECKOUT REQUEST (Tenant) ---
Route::post('/checkout/request', [ExtensionController::class, 'requestCheckout'])->name('checkout.request');

// --- EXTENSIONS (Tenant) ---
Route::prefix('extensions')->name('extensions.')->group(function () {
    Route::get('/create',           [ExtensionController::class, 'create'])     ->name('create');
    Route::post('/store',           [ExtensionController::class, 'store'])      ->name('store');
    Route::get('/{id}/qris',         [ExtensionController::class, 'qris'])       ->name('qris');
    Route::get('/{id}/upload-proof', [ExtensionController::class, 'uploadProof'])->name('upload-proof');
    Route::post('/{id}/upload-proof',[ExtensionController::class, 'storeProof']) ->name('store-proof');
});



    // ============================================================
    // ADMIN ONLY ROUTES
    // ============================================================
    Route::middleware(['admin'])->prefix('admin')->group(function () {


        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

        // Rooms
        Route::prefix('rooms')->name('dashboard.rooms')->group(function () {
            Route::get('/',          [RoomController::class, 'index'])  ->name('');
            Route::get('/create',    [RoomController::class, 'create']) ->name('.form');
            Route::post('/',         [RoomController::class, 'store'])  ->name('.store');
            Route::get('/{id}/edit', [RoomController::class, 'edit'])   ->name('.edit');
            Route::put('/{id}',      [RoomController::class, 'update']) ->name('.update');
            Route::delete('/{id}',   [RoomController::class, 'destroy'])->name('.destroy');
        });

        // Tenants
        Route::prefix('tenants')->name('tenants.')->group(function () {
            Route::get('/',              [TenantController::class, 'index'])   ->name('index');
            Route::get('/create',        [TenantController::class, 'create'])  ->name('create');
            Route::post('/',             [TenantController::class, 'store'])   ->name('store');
            Route::get('/{id}',          [TenantController::class, 'show'])    ->name('show');
            Route::get('/{id}/edit',     [TenantController::class, 'edit'])    ->name('edit');
            Route::put('/{id}',          [TenantController::class, 'update'])  ->name('update');
            Route::delete('/{id}',       [TenantController::class, 'destroy']) ->name('destroy');
            Route::get('/{id}/contract', [TenantController::class, 'contract'])->name('contract');
        });

        // Payments (Admin)
        Route::prefix('payments')->name('admin.payments.')->group(function () {
    Route::get('/',           [AdminPaymentController::class, 'index'])  ->name('index');
    Route::get('/{id}',       [AdminPaymentController::class, 'show'])   ->name('show');
    Route::post('/{id}/approve', [AdminPaymentController::class, 'approve'])->name('approve');
    Route::post('/{id}/reject',  [AdminPaymentController::class, 'reject']) ->name('reject');
});

       // Complaint admins
Route::prefix('complaints')->name('complaints.')->group(function () {

    Route::get('/', [ComplaintController::class, 'index'])
        ->name('index');

    Route::get('/{id}', [ComplaintController::class, 'show'])
        ->name('show');

});

        Route::prefix('bookings')->name('admin.bookings.')->group(function () {
    Route::get('/',           [AdminBookingController::class, 'index'])  ->name('index');
    Route::get('/{id}',       [AdminBookingController::class, 'show'])   ->name('show');
    Route::post('/{id}/approve', [AdminBookingController::class, 'approve'])->name('approve');
    Route::post('/{id}/reject',  [AdminBookingController::class, 'reject']) ->name('reject');
});

// Complaints Admin
Route::prefix('complaints')->name('admin.complaints.')->group(function () {
    Route::get('/',                    [AdminComplaintController::class, 'index'])       ->name('index');
    Route::get('/{id}',                [AdminComplaintController::class, 'show'])        ->name('show');
    Route::post('/{id}/status',        [AdminComplaintController::class, 'updateStatus'])->name('status');
    Route::post('/{id}/reply',         [AdminComplaintController::class, 'reply'])       ->name('reply');
});

        // Reminders
        Route::prefix('reminders')->name('reminders.')->group(function () {
    Route::get('/',         [ReminderController::class, 'index'])   ->name('index');
    Route::get('/settings', [ReminderController::class, 'settings'])->name('settings');
    Route::post('/send',    [ReminderController::class, 'send'])    ->name('send');
});

// Extensions (Admin)
Route::prefix('extensions')->name('admin.extensions.')->group(function () {
    Route::get('/',           [AdminExtensionController::class, 'index'])  ->name('index');
    Route::get('/{id}',       [AdminExtensionController::class, 'show'])   ->name('show');
    Route::post('/{id}/approve', [AdminExtensionController::class, 'approve'])->name('approve');
    Route::post('/{id}/reject',  [AdminExtensionController::class, 'reject']) ->name('reject');
});

// Checkout approval (Admin)
Route::post('/tenants/{id}/approve-checkout', [AdminExtensionController::class, 'approveCheckout'])->name('tenants.approve-checkout');

        Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('/',          [ReportController::class, 'index'])     ->name('index');
    Route::get('/income/export-pdf', [ReportController::class, 'exportIncomePdf'])->name('income.export-pdf');
    Route::get('/income',    [ReportController::class, 'income'])    ->name('income');
    Route::get('/occupancy/export-pdf',  [ReportController::class, 'exportOccupancyPdf'])->name('occupancy.export-pdf');
    Route::get('/occupancy', [ReportController::class, 'occupancy']) ->name('occupancy');
        });
    });
});



// ============================================================
// 4. ERROR PAGES
// ============================================================
Route::view('/404-demo', 'errors.404')->name('errors.404');
Route::view('/403-demo', 'errors.403')->name('errors.403');