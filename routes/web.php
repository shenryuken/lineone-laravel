<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KycController as AdminKycController;
use App\Http\Controllers\Admin\PendingPaymentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\StripePaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Gateway\PaymentGatewayController;
use App\Http\Controllers\Gateway\WebhookController;
use App\Http\Controllers\Gateway\MerchantGatewayController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    if (auth()->check()) {
        // Redirect authenticated users to dashboard
        return redirect()->route('dashboard'); // or your dashboard route name
    }
    // Show welcome page for guests
    return view('welcome');
});

// Social Login Routes (including Auth0)
Route::get('login/{provider}', [AuthController::class, 'redirectToProvider'])
    ->name('login.social')
    ->middleware('guest')
    ->where('provider', 'google|facebook|auth0');

Route::get('login/{provider}/callback', [AuthController::class, 'handleProviderCallback'])
    ->name('login.social.callback')
    ->middleware('guest')
    ->where('provider', 'google|facebook|auth0');

Route::middleware('guest')->group(function () {


    Route::get('/login', [AuthController::class, 'loginView'])->name('loginView');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'registerView'])->name('registerView');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    // Password Reset Routes
    Route::get('/forgot-password', [AuthController::class, 'forgotPasswordView'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::get('/reset-password', [AuthController::class, 'resetPasswordView'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);
// Stripe Payment Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/stripe/checkout', [StripePaymentController::class, 'checkout'])->name('stripe.checkout');
    Route::get('/stripe/success', [StripePaymentController::class, 'success'])->name('stripe.success');
    Route::get('/stripe/cancel', [StripePaymentController::class, 'cancel'])->name('stripe.cancel');

    Route::match(['get', 'post'], '/deposit/callback/{wallet}/{method}', [DepositController::class, 'handleCallback'])
        ->name('deposit.callback');
});

// Add this route outside the auth middleware group
// RediPay routes
Route::post('redipay/callback', [App\Http\Controllers\RediPayCallbackController::class, 'handleRedirect'])->name('redipay.callback');
// Route::get('redipay/callback', [App\Http\Controllers\RediPayCallbackController::class, 'handleRedirect']);
Route::match(['get', 'post'], 'redipay/success', [App\Http\Controllers\PaymentStatusController::class, 'show'])
    ->name('redipay.success')
    ->withoutMiddleware(['auth']);

// Payment status routes
Route::get('payment/status/{reference?}', [App\Http\Controllers\PaymentStatusController::class, 'show'])
    ->name('payment.status')
    ->middleware(['auth']);

Route::post('payment/status/check', [App\Http\Controllers\PaymentStatusController::class, 'check'])
    ->name('payment.status.check')
    ->middleware(['auth']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', function () {
        if (auth()->user()->hasRole('admin')) {
            return view('admin.dashboard');
        } elseif (auth()->user()->hasRole('merchant')) {
            return view('merchant.dashboard');
        } else {
            return view('user.dashboard');
        }
    })->name('dashboard');

    // Route::get('/deposit/callback/{wallet}/{method}', [DepositController::class, 'handleCallback'])->name('deposit.callback');
    // Route::post('/deposit/callback/{wallet}/{method}', [DepositController::class, 'handleCallback']);
    // Deposit callback routes - support both GET and POST methods
    // Route::match(['get', 'post'], '/deposit/callback/{wallet}/{method}', [DepositController::class, 'handleCallback'])
    //     ->name('deposit.callback')->withoutMiddleware(['verified','verify_csrf_token']);

    Route::get('/transactions/history', function () {
        return view('transactions.history');
    })->name('transactions.history');

    // KYC Routes
    Route::get('/kyc/dashboard', [App\Http\Controllers\KycController::class, 'dashboard'])->name('kyc.dashboard');
    Route::get('/kyc/apply', [App\Http\Controllers\KycController::class, 'apply'])->name('kyc.apply');
    Route::get('/kyc/status', [App\Http\Controllers\KycController::class, 'status'])->name('kyc.status');
    Route::get('/kyc/application/{kyc}', [App\Http\Controllers\KycController::class, 'viewApplication'])->name('kyc.view-application');
    Route::get('/kyc/update', [App\Http\Controllers\KycController::class, 'update'])->name('kyc.update');
    Route::get('/kyc/upload-additional', [App\Http\Controllers\KycController::class, 'uploadAdditionalDocument'])->name('kyc.upload.additional');

    // KYB Routes
    // Route::prefix('kyb')->name('kyb.')->group(function () {
    //     Route::get('/dashboard', [App\Http\Controllers\KybController::class, 'dashboard'])->name('dashboard');
    //     Route::get('/apply', [App\Http\Controllers\KybController::class, 'apply'])->name('apply');
    //     Route::get('/status', [App\Http\Controllers\KybController::class, 'status'])->name('status');
    //     Route::get('/view/{kyb}', [App\Http\Controllers\KybController::class, 'viewApplication'])->name('view');
    //     Route::get('/update', [App\Http\Controllers\KybController::class, 'update'])->name('update');
    //     Route::get('/upload-additional', [App\Http\Controllers\KybController::class, 'uploadAdditionalDocument'])->name('upload-additional');
    // });


    // Admin Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);

        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Transaction Routes
        Route::get('/transactions', [App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('transactions.index');
        Route::get('/transactions/{transaction}', [App\Http\Controllers\Admin\TransactionController::class, 'show'])->name('transactions.show');

        Route::get('/banks', [App\Http\Controllers\Admin\BankController::class, 'index'])->name('banks.index');
        Route::get('/banks/create', [App\Http\Controllers\Admin\BankController::class, 'create'])->name('banks.create');
        Route::get('/banks/{bank}/edit', [App\Http\Controllers\Admin\BankController::class, 'edit'])->name('banks.edit');

        Route::get('/countries', [App\Http\Controllers\Admin\CountryController::class, 'index'])->name('countries.index');
        Route::get('/countries/{country}', [App\Http\Controllers\Admin\CountryController::class, 'show'])->name('countries.show');
    
        // Admin KYC Routes
        Route::get('/kyc/dashboard', function () {
            return view('admin.kyc.dashboard');
        })->name('kyc.dashboard');
        Route::get('/kyc', [App\Http\Controllers\Admin\KycController::class, 'index'])->name('kyc.index');
        Route::get('/kyc/{kyc}', [App\Http\Controllers\Admin\KycController::class, 'show'])->name('kyc.show');
        Route::post('/kyc/{kyc}/verify', [App\Http\Controllers\Admin\KycController::class, 'updateVerificationStatus'])->name('kyc.verify');
        Route::post('/kyc/{kyc}/approve', [App\Http\Controllers\Admin\KycController::class, 'approve'])->name('kyc.approve');
        Route::post('/kyc/{kyc}/reject', [App\Http\Controllers\Admin\KycController::class, 'reject'])->name('kyc.reject');
        Route::post('/kyc/{kyc}/kiv', [App\Http\Controllers\Admin\KycController::class, 'kiv'])->name('kyc.kiv');
        Route::post('/kyc/{kyc}/request-info', [App\Http\Controllers\Admin\KycController::class, 'requestAdditionalInfo'])->name('kyc.request-info');
        // End Admin KYC Routes

        // Admin Pending Payments Routes
        Route::get('/pending-payments', [PendingPaymentController::class, 'index'])->name('pending-payments.index');
        Route::get('/pending-payments/{pendingPayment}', [PendingPaymentController::class, 'show'])->name('pending-payments.show');
        Route::post('/pending-payments/{pendingPayment}/update-status', [PendingPaymentController::class, 'updateStatus'])->name('pending-payments.update-status');
        Route::post('/pending-payments/{pendingPayment}/check-status', [PendingPaymentController::class, 'checkStatus'])->name('pending-payments.check-status');
        Route::post('/pending-payments/{pendingPayment}/process-payment', [PendingPaymentController::class, 'processPayment'])->name('pending-payments.process-payment');
        // End Admin Pending Payments Routes

        Route::prefix('kyb')->name('admin.kyb.')->group(function () {
            Route::get('/dashboard', [App\Http\Controllers\Admin\KybController::class, 'dashboard'])->name('dashboard');
            Route::get('/', [App\Http\Controllers\Admin\KybController::class, 'index'])->name('index');
            Route::get('/{kyb}', [App\Http\Controllers\Admin\KybController::class, 'show'])->name('show');
        });
    });
    //End Admin Route

    Route::middleware('role:merchant')->group(function () {
        Route::get('/merchant/dashboard', function () {
            return view('merchant.dashboard');
        })->name('merchant.dashboard');
    });

    // Merchant KYB Routes
    Route::middleware('role:merchant')->prefix('merchant/kyb')->name('merchant.kyb.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\KybController::class, 'dashboard'])->name('dashboard');
        Route::get('/apply', [App\Http\Controllers\KybController::class, 'apply'])->name('apply');
        Route::get('/status', [App\Http\Controllers\KybController::class, 'status'])->name('status');
        Route::get('/application/{kyb}', [App\Http\Controllers\KybController::class, 'viewApplication'])->name('view');
        Route::get('/update', [App\Http\Controllers\KybController::class, 'update'])->name('update');
        Route::get('/upload-additional', [App\Http\Controllers\KybController::class, 'uploadAdditionalDocument'])->name('upload-additional');
    });
});

Route::middleware('auth')->group(function () {

    //Route::get('/', [PagesController::class, 'dashboardsCrmAnalytics'])->name('index');

    Route::get('/elements/avatar', [PagesController::class, 'elementsAvatar'])->name('elements/avatar');
    Route::get('/elements/alert', [PagesController::class, 'elementsAlert'])->name('elements/alert');
    Route::get('/elements/button', [PagesController::class, 'elementsButton'])->name('elements/button');
    Route::get('/elements/button-group', [PagesController::class, 'elementsButtonGroup'])->name('elements/button-group');
    Route::get('/elements/badge', [PagesController::class, 'elementsBadge'])->name('elements/badge');
    Route::get('/elements/breadcrumb', [PagesController::class, 'elementsBreadcrumb'])->name('elements/breadcrumb');
    Route::get('/elements/card', [PagesController::class, 'elementsCard'])->name('elements/card');
    Route::get('/elements/divider', [PagesController::class, 'elementsDivider'])->name('elements/divider');
    Route::get('/elements/mask', [PagesController::class, 'elementsMask'])->name('elements/mask');
    Route::get('/elements/progress', [PagesController::class, 'elementsProgress'])->name('elements/progress');
    Route::get('/elements/skeleton', [PagesController::class, 'elementsSkeleton'])->name('elements/skeleton');
    Route::get('/elements/spinner', [PagesController::class, 'elementsSpinner'])->name('elements/spinner');
    Route::get('/elements/tag', [PagesController::class, 'elementsTag'])->name('elements/tag');
    Route::get('/elements/tooltip', [PagesController::class, 'elementsTooltip'])->name('elements/tooltip');
    Route::get('/elements/typography', [PagesController::class, 'elementsTypography'])->name('elements/typography');

    Route::get('/components/accordion', [PagesController::class, 'componentsAccordion'])->name('components/accordion');
    Route::get('/components/collapse', [PagesController::class, 'componentsCollapse'])->name('components/collapse');
    Route::get('/components/tab', [PagesController::class, 'componentsTab'])->name('components/tab');
    Route::get('/components/dropdown', [PagesController::class, 'componentsDropdown'])->name('components/dropdown');
    Route::get('/components/popover', [PagesController::class, 'componentsPopover'])->name('components/popover');
    Route::get('/components/modal', [PagesController::class, 'componentsModal'])->name('components/modal');
    Route::get('/components/drawer', [PagesController::class, 'componentsDrawer'])->name('components/drawer');
    Route::get('/components/steps', [PagesController::class, 'componentsSteps'])->name('components/steps');
    Route::get('/components/timeline', [PagesController::class, 'componentsTimeline'])->name('components/timeline');
    Route::get('/components/pagination', [PagesController::class, 'componentsPagination'])->name('components/pagination');
    Route::get('/components/menu-list', [PagesController::class, 'componentsMenuList'])->name('components/menu-list');
    Route::get('/components/treeview', [PagesController::class, 'componentsTreeview'])->name('components/treeview');
    Route::get('/components/table', [PagesController::class, 'componentsTable'])->name('components/table');
    Route::get('/components/table-advanced', [PagesController::class, 'componentsTableAdvanced'])->name('components/table-advanced');
    Route::get('/components/table-gridjs', [PagesController::class, 'componentsTableGridjs'])->name('components/gridjs');
    Route::get('/components/apexchart', [PagesController::class, 'componentsApexchart'])->name('components/apexchart');
    Route::get('/components/carousel', [PagesController::class, 'componentsCarousel'])->name('components/carousel');
    Route::get('/components/notification', [PagesController::class, 'componentsNotification'])->name('components/notification');
    Route::get('/components/extension-clipboard', [PagesController::class, 'componentsExtensionClipboard'])->name('components/extension-clipboard');
    Route::get('/components/extension-persist', [PagesController::class, 'componentsExtensionPersist'])->name('components/extension-persist');
    Route::get('/components/extension-monochrome', [PagesController::class, 'componentsExtensionMonochrome'])->name('components/extension-monochrome');

    Route::get('/forms/layout-v1', [PagesController::class, 'formsLayoutV1'])->name('forms/layout-v1');
    Route::get('/forms/layout-v2', [PagesController::class, 'formsLayoutV2'])->name('forms/layout-v2');
    Route::get('/forms/layout-v3', [PagesController::class, 'formsLayoutV3'])->name('forms/layout-v3');
    Route::get('/forms/layout-v4', [PagesController::class, 'formsLayoutV4'])->name('forms/layout-v4');
    Route::get('/forms/layout-v5', [PagesController::class, 'formsLayoutV5'])->name('forms/layout-v5');
    Route::get('/forms/input-text', [PagesController::class, 'formsInputText'])->name('forms/input-text');
    Route::get('/forms/input-group', [PagesController::class, 'formsInputGroup'])->name('forms/input-group');
    Route::get('/forms/input-mask', [PagesController::class, 'formsInputMask'])->name('forms/input-mask');
    Route::get('/forms/checkbox', [PagesController::class, 'formsCheckbox'])->name('forms/checkbox');
    Route::get('/forms/radio', [PagesController::class, 'formsRadio'])->name('forms/radio');
    Route::get('/forms/switch', [PagesController::class, 'formsSwitch'])->name('forms/switch');
    Route::get('/forms/select', [PagesController::class, 'formsSelect'])->name('forms/select');
    Route::get('/forms/tom-select', [PagesController::class, 'formsTomSelect'])->name('forms/tom-select');
    Route::get('/forms/textarea', [PagesController::class, 'formsTextarea'])->name('forms/textarea');
    Route::get('/forms/range', [PagesController::class, 'formsRange'])->name('forms/range');
    Route::get('/forms/datepicker', [PagesController::class, 'formsDatepicker'])->name('forms/datepicker');
    Route::get('/forms/timepicker', [PagesController::class, 'formsTimepicker'])->name('forms/timepicker');
    Route::get('/forms/datetimepicker', [PagesController::class, 'formsDatetimepicker'])->name('forms/datetimepicker');
    Route::get('/forms/text-editor', [PagesController::class, 'formsTextEditor'])->name('forms/text-editor');
    Route::get('/forms/upload', [PagesController::class, 'formsUpload'])->name('forms/upload');
    Route::get('/forms/validation', [PagesController::class, 'formsValidation'])->name('forms/validation');

    Route::get('/layouts/onboarding-1', [PagesController::class, 'layoutsOnboarding1'])->name('layouts/onboarding-1');
    Route::get('/layouts/onboarding-2', [PagesController::class, 'layoutsOnboarding2'])->name('layouts/onboarding-2');
    Route::get('/layouts/user-card-1', [PagesController::class, 'layoutsUserCard1'])->name('layouts/user-card-1');
    Route::get('/layouts/user-card-2', [PagesController::class, 'layoutsUserCard2'])->name('layouts/user-card-2');
    Route::get('/layouts/user-card-3', [PagesController::class, 'layoutsUserCard3'])->name('layouts/user-card-3');
    Route::get('/layouts/user-card-4', [PagesController::class, 'layoutsUserCard4'])->name('layouts/user-card-4');
    Route::get('/layouts/user-card-5', [PagesController::class, 'layoutsUserCard5'])->name('layouts/user-card-5');
    Route::get('/layouts/user-card-6', [PagesController::class, 'layoutsUserCard6'])->name('layouts/user-card-6');
    Route::get('/layouts/user-card-7', [PagesController::class, 'layoutsUserCard7'])->name('layouts/user-card-7');
    Route::get('/layouts/blog-card-1', [PagesController::class, 'layoutsBlogCard1'])->name('layouts/blog-card-1');
    Route::get('/layouts/blog-card-2', [PagesController::class, 'layoutsBlogCard2'])->name('layouts/blog-card-2');
    Route::get('/layouts/blog-card-3', [PagesController::class, 'layoutsBlogCard3'])->name('layouts/blog-card-3');
    Route::get('/layouts/blog-card-4', [PagesController::class, 'layoutsBlogCard4'])->name('layouts/blog-card-4');
    Route::get('/layouts/blog-card-5', [PagesController::class, 'layoutsBlogCard5'])->name('layouts/blog-card-5');
    Route::get('/layouts/blog-card-6', [PagesController::class, 'layoutsBlogCard6'])->name('layouts/blog-card-6');
    Route::get('/layouts/blog-card-7', [PagesController::class, 'layoutsBlogCard7'])->name('layouts/blog-card-7');
    Route::get('/layouts/blog-card-8', [PagesController::class, 'layoutsBlogCard8'])->name('layouts/blog-card-8');
    Route::get('/layouts/blog-details', [PagesController::class, 'layoutsBlogDetails'])->name('layouts/blog-details');
    Route::get('/layouts/help-1', [PagesController::class, 'layoutsHelp1'])->name('layouts/help-1');
    Route::get('/layouts/help-2', [PagesController::class, 'layoutsHelp2'])->name('layouts/help-2');
    Route::get('/layouts/help-3', [PagesController::class, 'layoutsHelp3'])->name('layouts/help-3');
    Route::get('/layouts/price-list-1', [PagesController::class, 'layoutsPriceList1'])->name('layouts/price-list-1');
    Route::get('/layouts/price-list-2', [PagesController::class, 'layoutsPriceList2'])->name('layouts/price-list-2');
    Route::get('/layouts/price-list-3', [PagesController::class, 'layoutsPriceList3'])->name('layouts/price-list-3');
    Route::get('/layouts/price-list-4', [PagesController::class, 'layoutsPriceList4'])->name('layouts/price-list-4');
    Route::get('/layouts/invoice-1', [PagesController::class, 'layoutsInvoice1'])->name('layouts/invoice-1');
    Route::get('/layouts/invoice-2', [PagesController::class, 'layoutsInvoice2'])->name('layouts/invoice-2');
    Route::get('/layouts/sign-in-1', [PagesController::class, 'layoutsSignIn1'])->name('layouts/sign-in-1');
    Route::get('/layouts/sign-in-2', [PagesController::class, 'layoutsSignIn2'])->name('layouts/sign-in-2');
    Route::get('/layouts/sign-up-1', [PagesController::class, 'layoutsSignUp1'])->name('layouts/sign-up-1');
    Route::get('/layouts/sign-up-2', [PagesController::class, 'layoutsSignUp2'])->name('layouts/sign-up-2');
    Route::get('/layouts/error-404-1', [PagesController::class, 'layoutsError4041'])->name('layouts/error-404-1');
    Route::get('/layouts/error-404-2', [PagesController::class, 'layoutsError4042'])->name('layouts/error-404-2');
    Route::get('/layouts/error-404-3', [PagesController::class, 'layoutsError4043'])->name('layouts/error-404-3');
    Route::get('/layouts/error-404-4', [PagesController::class, 'layoutsError4044'])->name('layouts/error-404-4');
    Route::get('/layouts/error-401', [PagesController::class, 'layoutsError401'])->name('layouts/error-401');
    Route::get('/layouts/error-429', [PagesController::class, 'layoutsError429'])->name('layouts/error-429');
    Route::get('/layouts/error-500', [PagesController::class, 'layoutsError500'])->name('layouts/error-500');
    Route::get('/layouts/starter-blurred-header', [PagesController::class, 'layoutsStarterBlurredHeader'])->name('layouts/starter-blurred-header');
    Route::get('/layouts/starter-unblurred-header', [PagesController::class, 'layoutsStarterUnblurredHeader'])->name('layouts/starter-unblurred-header');
    Route::get('/layouts/starter-centered-link', [PagesController::class, 'layoutsStarterCenteredLink'])->name('layouts/starter-centered-link');
    Route::get('/layouts/starter-minimal-sidebar', [PagesController::class, 'layoutsStarterMinimalSidebar'])->name('layouts/starter-minimal-sidebar');
    Route::get('/layouts/starter-sideblock', [PagesController::class, 'layoutsStarterSideblock'])->name('layouts/starter-sideblock');

    Route::get('/apps/chat', [PagesController::class, 'appsChat'])->name('apps/chat');
    Route::get('/apps/ai-chat', [PagesController::class, 'appsAiChat'])->name('apps/ai-chat');
    Route::get('/apps/filemanager', [PagesController::class, 'appsFilemanager'])->name('apps/filemanager');
    Route::get('/apps/kanban', [PagesController::class, 'appsKanban'])->name('apps/kanban');
    Route::get('/apps/list', [PagesController::class, 'appsList'])->name('apps/list');
    Route::get('/apps/mail', [PagesController::class, 'appsMail'])->name('apps/mail');
    Route::get('/apps/nft-1', [PagesController::class, 'appsNft1'])->name('apps/nft1');
    Route::get('/apps/nft-2', [PagesController::class, 'appsNft2'])->name('apps/nft2');
    Route::get('/apps/pos', [PagesController::class, 'appsPos'])->name('apps/pos');
    Route::get('/apps/todo', [PagesController::class, 'appsTodo'])->name('apps/todo');
    Route::get('/apps/jobs-board', [PagesController::class, 'appsJobsBoard'])->name('apps/jobs-board');
    Route::get('/apps/travel', [PagesController::class, 'appsTravel'])->name('apps/travel');

    Route::get('/dashboards/crm-analytics', [PagesController::class, 'dashboardsCrmAnalytics'])->name('dashboards/crm-analytics');
    Route::get('/dashboards/orders', [PagesController::class, 'dashboardsOrders'])->name('dashboards/orders');
    Route::get('/dashboards/crypto-1', [PagesController::class, 'dashboardsCrypto1'])->name('dashboards/crypto-1');
    Route::get('/dashboards/crypto-2', [PagesController::class, 'dashboardsCrypto2'])->name('dashboards/crypto-2');
    Route::get('/dashboards/banking-1', [PagesController::class, 'dashboardsBanking1'])->name('dashboards/banking-1');
    Route::get('/dashboards/banking-2', [PagesController::class, 'dashboardsBanking2'])->name('dashboards/banking-2');
    Route::get('/dashboards/personal', [PagesController::class, 'dashboardsPersonal'])->name('dashboards/personal');
    Route::get('/dashboards/cms-analytics', [PagesController::class, 'dashboardsCmsAnalytics'])->name('dashboards/cms-analytics');
    Route::get('/dashboards/influencer', [PagesController::class, 'dashboardsInfluencer'])->name('dashboards/influencer');
    Route::get('/dashboards/travel', [PagesController::class, 'dashboardsTravel'])->name('dashboards/travel');
    Route::get('/dashboards/teacher', [PagesController::class, 'dashboardsTeacher'])->name('dashboards/teacher');
    Route::get('/dashboards/education', [PagesController::class, 'dashboardsEducation'])->name('dashboards/education');
    Route::get('/dashboards/authors', [PagesController::class, 'dashboardsAuthors'])->name('dashboards/authors');
    Route::get('/dashboards/doctor', [PagesController::class, 'dashboardsDoctor'])->name('dashboards/doctor');
    Route::get('/dashboards/employees', [PagesController::class, 'dashboardsEmployees'])->name('dashboards/employees');
    Route::get('/dashboards/workspaces', [PagesController::class, 'dashboardsWorkspaces'])->name('dashboards/workspaces');
    Route::get('/dashboards/meetings', [PagesController::class, 'dashboardsMeetings'])->name('dashboards/meetings');
    Route::get('/dashboards/project-boards', [PagesController::class, 'dashboardsProjectBoards'])->name('dashboards/project-boards');
    Route::get('/dashboards/widget-ui', [PagesController::class, 'dashboardsWidgetUi'])->name('dashboards/widget-ui');
    Route::get('/dashboards/widget-contacts', [PagesController::class, 'dashboardsWidgetContacts'])->name('dashboards/widget-contacts');
});

// Add this route for debugging
Route::get('/debug-socialite', function() {
    try {
        $providers = ['google', 'facebook', 'auth0'];
        $results = [];

        foreach ($providers as $provider) {
            $results[$provider] = [
                'configured' => class_exists('SocialiteProviders\\' . ucfirst($provider) . '\\' . ucfirst($provider) . 'ExtendSocialite'),
                'settings' => [
                    'client_id' => config('services.' . $provider . '.client_id') ? 'Set' : 'Not set',
                    'client_secret' => config('services.' . $provider . '.client_secret') ? 'Set' : 'Not set',
                    'redirect' => config('services.' . $provider . '.redirect'),
                ]
            ];

            if ($provider === 'auth0') {
                $results[$provider]['settings']['domain'] = config('services.auth0.domain');
            }
        }

        return response()->json([
            'providers' => $results,
            'app_url' => env('APP_URL'),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
})->middleware('auth');

// Add this debug route
Route::get('/debug-auth0', function() {
    return [
        'routes' => [
            'login_social' => route('login.social', 'auth0'),
            'login_social_callback' => route('login.social.callback', 'auth0'),
        ],
        'config' => [
            'auth0' => config('services.auth0'),
            'app_url' => env('APP_URL'),
        ]
    ];
});

// Auth0 direct integration routes
Route::get('/auth0/login', [App\Http\Controllers\Auth0LoginController::class, 'login'])
    ->name('auth0.login')
    ->middleware('guest');

Route::get('/auth0/callback', [App\Http\Controllers\Auth0LoginController::class, 'callback'])
    ->name('auth0.callback')
    ->middleware('guest');

// Direct Google login via Auth0
Route::get('/auth0/google', [App\Http\Controllers\Auth0LoginController::class, 'loginWithGoogle'])
    ->name('auth0.google')
    ->middleware('guest');

// Payment Gateway Routes (Public - for customers)
Route::prefix('payment-gateway')->name('payment.gateway.')->group(function () {
    // Customer-facing payment pages (public access)
    Route::get('checkout/{requestId}', [PaymentGatewayController::class, 'showCheckout'])->name('checkout');
    Route::post('process/{requestId}', [PaymentGatewayController::class, 'processPayment'])->name('process');
    Route::get('success/{requestId}', [PaymentGatewayController::class, 'showSuccess'])->name('success');
    Route::get('error/{requestId}', [PaymentGatewayController::class, 'showError'])->name('error');
    
    // Public webhook test endpoint
    Route::post('webhook/test', [WebhookController::class, 'test'])->name('webhook.test');
});

// Merchant API Key Management Routes
Route::middleware(['auth', 'verified', 'role:merchant'])->group(function () {
    Route::prefix('merchant')->name('merchant.')->group(function () {
        // API Key Management
        Route::resource('api-keys', App\Http\Controllers\Merchant\ApiKeyController::class)->names([
            'index' => 'api-keys.index',
            'create' => 'api-keys.create',
            'store' => 'api-keys.store',
            'show' => 'api-keys.show',
            'edit' => 'api-keys.edit',
            'update' => 'api-keys.update',
            'destroy' => 'api-keys.destroy',
        ]);
        
        // Additional API Key actions
        Route::patch('api-keys/{apiKey}/toggle', [App\Http\Controllers\Merchant\ApiKeyController::class, 'toggle'])
            ->name('api-keys.toggle');
        Route::patch('api-keys/{apiKey}/regenerate-secret', [App\Http\Controllers\Merchant\ApiKeyController::class, 'regenerateSecret'])
            ->name('api-keys.regenerate-secret');

         // Add API Testing route
        Route::get('api-keys/test/console', [App\Http\Controllers\Merchant\ApiKeyController::class, 'testConsole'])
            ->name('api-keys.test');

        // Payment Gateway Dashboard
        Route::prefix('payment-gateway')->name('payment.gateway.')->group(function () {
            Route::get('/', [MerchantGatewayController::class, 'dashboard'])->name('dashboard');
            Route::get('/transactions', [MerchantGatewayController::class, 'transactions'])->name('transactions.index');
            Route::get('/transactions/{id}', [MerchantGatewayController::class, 'showTransaction'])->name('transactions.show');
            Route::post('/transactions/{id}/refund', [MerchantGatewayController::class, 'refundTransaction'])->name('transactions.refund');
            Route::get('/settings', [MerchantGatewayController::class, 'settings'])->name('settings');
            Route::post('/settings', [MerchantGatewayController::class, 'updateSettings'])->name('settings.update');
        });
    });
});