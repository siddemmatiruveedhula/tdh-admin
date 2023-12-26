<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Pos\AreaController;
use App\Http\Controllers\Pos\BeatController;
use App\Http\Controllers\Pos\CityController;
use App\Http\Controllers\Pos\RoleController;
use App\Http\Controllers\Pos\UnitController;
use App\Http\Controllers\Pos\UserController;
use App\Http\Controllers\Demo\DemoController;
use App\Http\Controllers\Pos\BrandController;
use App\Http\Controllers\Pos\CheckController;
use App\Http\Controllers\Pos\OrderController;
use App\Http\Controllers\Pos\StateController;
use App\Http\Controllers\Pos\StockController;
use App\Http\Controllers\Pos\LedgerController;
use App\Http\Controllers\Pos\TargetController;
use App\Http\Controllers\Pos\CountryController;
use App\Http\Controllers\Pos\DefaultController;
use App\Http\Controllers\Pos\InvoiceController;
use App\Http\Controllers\Pos\ProductController;
use App\Http\Controllers\Pos\StorageController;
use App\Http\Controllers\Pos\VariantController;
use App\Http\Controllers\Pos\VehicleController;
use App\Http\Controllers\Pos\VisitorController;
use App\Http\Controllers\Pos\CategoryController;
use App\Http\Controllers\Pos\CustomerController;
use App\Http\Controllers\Pos\DistrictController;
use App\Http\Controllers\Pos\DivisionController;
use App\Http\Controllers\Pos\EmployeeController;
use App\Http\Controllers\Pos\IpaymentController;
use App\Http\Controllers\Pos\PurchaseController;
use App\Http\Controllers\Pos\SupplierController;
use App\Http\Controllers\Pos\AssignPjpController;
use App\Http\Controllers\Pos\DashboardController;
use App\Http\Controllers\Pos\AttendanceController;
use App\Http\Controllers\Pos\DepartmentController;
use App\Http\Controllers\Pos\OutstandingController;
use App\Http\Controllers\Pos\StorageTypeController;
use App\Http\Controllers\Pos\VehicleTypeController;
use App\Http\Controllers\Pos\CustomerTypeController;
use App\Http\Controllers\Pos\ProductGalleryController;
use App\Http\Controllers\Pos\TransportationController;
use App\Http\Controllers\Pos\CustomerCategoryTypeController;
use App\Http\Controllers\Pos\HolidayController;
use App\Http\Controllers\Pos\LeaveController;
use App\Http\Controllers\Pos\LeaveTypeController;
use App\Http\Controllers\Pos\SaleOrderController;

Route::get('/', function () {
    return Redirect::route('login');
});

Route::middleware('auth')->group(function () {

    // Admin All Route 
    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin/logout', 'destroy')->name('admin.logout');
        Route::get('/admin/profile', 'Profile')->name('admin.profile');
        Route::get('/edit/profile', 'EditProfile')->name('edit.profile');
        Route::post('/store/profile', 'StoreProfile')->name('store.profile');

        Route::get('/change/password', 'ChangePassword')->name('change.password');
        Route::post('/update/password', 'UpdatePassword')->name('update.password');
    });

    Route::get('/sheet-report', [CheckController::class, 'sheetReport'])->name('sheet-report');
    Route::post('/sheet-report', [CheckController::class, 'sheetReport'])->name('sheet-report');
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance');

    Route::post('api/fetch-states', [CustomerController::class, 'fetchState']);
    Route::post('api/fetch-districts', [CustomerController::class, 'fetchDistrict']);
    Route::post('api/fetch-cities', [CustomerController::class, 'fetchCity']);
    Route::post('api/fetch-areas', [CustomerController::class, 'fetchArea']);

    // Counrty All Route 
    Route::controller(CountryController::class)->group(function () {
        Route::get('/country/all', 'CountryAll')->name('country.all');
        Route::put('country-status/{id}', 'changeStatus')->name('country-status');
        Route::get('/country/add', 'CountryAdd')->name('country.add');
        Route::post('/country/store', 'CountryStore')->name('country.store');
        Route::get('/country/edit/{id}', 'CountryEdit')->name('country.edit');
        Route::post('/country/update', 'CountryUpdate')->name('country.update');

    });

    // State All Route
    Route::controller(StateController::class)->group(function () {
        Route::get('/state/all', 'StateAll')->name('state.all');
        Route::put('state-status/{id}', 'changeStatus')->name('state-status');
        Route::get('/state/add', 'StateAdd')->name('state.add');
        Route::post('/state/store', 'StateStore')->name('state.store');
        Route::get('/state/edit/{id}', 'StateEdit')->name('state.edit');
        Route::post('/state/update', 'StateUpdate')->name('state.update');

    });

    // City All Route 
    Route::controller(CityController::class)->group(function () {
        Route::get('/city/all', 'CityAll')->name('city.all');
        Route::put('city-status/{id}', 'changeStatus')->name('city-status');
        Route::get('/city/add', 'CityAdd')->name('city.add');
        Route::post('/city/store', 'CityStore')->name('city.store');
        Route::get('/city/edit/{id}', 'CityEdit')->name('city.edit');
        Route::post('/city/update', 'CityUpdate')->name('city.update');
        // Route::get('/unit/delete/{id}', 'UnitDelete')->name('unit.delete');

    });

    // district All Route 
    Route::controller(DistrictController::class)->group(function () {
        Route::get('/district/all', 'DistrictAll')->name('district.all');
        Route::put('district-status/{id}', 'changeStatus')->name('district-status');
        Route::get('/district/add', 'DistrictAdd')->name('district.add');
        Route::post('/district/store', 'DistrictStore')->name('district.store');
        Route::get('/district/edit/{id}', 'DistrictEdit')->name('district.edit');
        Route::post('/district/update', 'DistrictUpdate')->name('district.update');
    });
    // Area All Route 
    Route::controller(AreaController::class)->group(function () {
        Route::get('/area/all', 'AreaAll')->name('area.all');
        Route::put('area-status/{id}', 'changeStatus')->name('area-status');
        Route::get('/area/add', 'AreaAdd')->name('area.add');
        Route::post('/area/store', 'AreaStore')->name('area.store');
        Route::get('/area/edit/{id}', 'AreaEdit')->name('area.edit');
        Route::post('/area/update', 'AreaUpdate')->name('area.update');
    });
    Route::controller(VariantController::class)->group(function () {
        Route::get('/variant/all', 'All')->name('variant.all');
        Route::put('variant-status/{id}', 'changeStatus')->name('variant-status');
        Route::get('/variant/add', 'Add')->name('variant.add');
        Route::post('/variant/store', 'Store')->name('variant.store');
        Route::get('/variant/edit/{id}', 'Edit')->name('variant.edit');
        Route::post('/variant/update', 'Update')->name('variant.update');
    });
    Route::controller(BrandController::class)->group(function () {
        Route::get('/brand/all', 'All')->name('brand.all');
        Route::put('brand-status/{id}', 'changeStatus')->name('brand-status');
        Route::get('/brand/add', 'Add')->name('brand.add');
        Route::post('/brand/store', 'Store')->name('brand.store');
        Route::get('/brand/edit/{id}', 'Edit')->name('brand.edit');
        Route::post('/brand/update', 'Update')->name('brand.update');
    });
    Route::controller(StorageTypeController::class)->group(function () {
        Route::get('/storage-type/all', 'All')->name('storage-type.all');
        Route::put('storage-type-status/{id}', 'changeStatus')->name('storage-type-status');
        Route::get('/storage-type/add', 'Add')->name('storage-type.add');
        Route::post('/storage-type/store', 'Store')->name('storage-type.store');
        Route::get('/storage-type/edit/{id}', 'Edit')->name('storage-type.edit');
        Route::post('/storage-type/update', 'Update')->name('storage-type.update');
    });
    Route::controller(StorageController::class)->group(function () {
        Route::get('/storage/all', 'All')->name('storage.all');
        Route::put('storage-status/{id}', 'changeStatus')->name('storage-status');
        Route::get('/storage/add', 'Add')->name('storage.add');
        Route::post('/storage/store', 'Store')->name('storage.store');
        Route::get('/storage/edit/{id}', 'Edit')->name('storage.edit');
        Route::post('/storage/update', 'Update')->name('storage.update');
    });
    Route::controller(VehicleController::class)->group(function () {
        Route::get('/vehicle/all', 'All')->name('vehicles.all');
        Route::get('/vehicle/edit/{id}', 'Edit')->name('vehicles.edit');
        Route::post('/vehicle/update', 'Update')->name('vehicles.update');
        Route::put('vehicles-status/{id}', 'changeStatus')->name('vehicles-status');
    });
    Route::controller(VisitorController::class)->group(function () {
        Route::get('/visitor/all', 'All')->name('visitor.all');
        Route::get('/visitor/edit/{id}', 'Edit')->name('visitor.edit');
        Route::post('/visitor/update', 'Update')->name('visitor.update');
        Route::put('visitor-status/{id}', 'changeStatus')->name('visitor-status');
    });
    Route::controller(VehicleTypeController::class)->group(function () {
        Route::get('/vehicle-type/all', 'All')->name('vehicle.all');
        Route::put('vehicle-type-status/{id}', 'changeStatus')->name('vehicle-type-status');
        Route::get('/vehicle-type/add', 'Add')->name('vehicle.add');
        Route::post('/vehicle-type/store', 'Store')->name('vehicle.store');
        Route::get('/vehicle-type/edit/{id}', 'Edit')->name('vehicle.edit');
        Route::post('/vehicle-type/update', 'Update')->name('vehicle.update');
    });
    Route::controller(TransportationController::class)->group(function () {
        Route::get('/transportation/all', 'All')->name('transportation.all');
        Route::put('transportation-status/{id}', 'changeStatus')->name('transportation-status');
        Route::get('/transportation/add', 'Add')->name('transportation.add');
        Route::post('/transportation/store', 'Store')->name('transportation.store');
        Route::get('/transportation/edit/{id}', 'Edit')->name('transportation.edit');
        Route::post('/transportation/update', 'Update')->name('transportation.update');
    });
    
    // Customer Type All Route 
    Route::controller(CustomerTypeController::class)->group(function () {
        Route::get('/customer-type/all', 'CustomerTypeAll')->name('customer-type.all');
        Route::put('customer-type-status/{id}', 'changeStatus')->name('customer-type-status');
        // Route::get('/state/add', 'StateAdd')->name('state.add');
        // Route::post('/unit/store', 'UnitStore')->name('unit.store');
        // Route::get('/unit/edit/{id}', 'UnitEdit')->name('unit.edit');
        // Route::post('/unit/update', 'UnitUpdate')->name('unit.update');
        // Route::get('/unit/delete/{id}', 'UnitDelete')->name('unit.delete');

    });

    // Customer Category Type All Route 
    Route::controller(CustomerCategoryTypeController::class)->group(function () {
        Route::get('/customer-category-type/all', 'CustomerCategoryTypeAll')->name('customer-category-type.all');
        Route::get('/customer-category-type/add', 'CustomerCategoryTypeAdd')->name('customer-category-type.add');
        Route::post('/customer-category-type/store', 'CustomerCategoryTypeStore')->name('customer-category-type.store');
        Route::get('/customer-category-type/edit/{id}', 'CustomerCategoryTypeEdit')->name('customer-category-type.edit');
        Route::post('/customer-category-type/update', 'CustomerCategoryTypeUpdate')->name('customer-category-type.update');
        Route::put('customer-category-type-status/{id}', 'changeStatus')->name('customer-category-type-status');
        // Route::get('customer-category-type-status/{id}', 'changeStatus')->name('customer-category-type-status');
        // Route::get('/customer-category-type/delete/{id}', 'CustomerCategoryTypeDelete')->name('customer-category-type.delete');

    });

    //  Role All Route 
    Route::controller(RoleController::class)->group(function () {
        Route::get('/role/all', 'RoleAll')->name('role.all');
        Route::put('role-status/{id}', 'changeStatus')->name('role-status');
    });

    // Supplier All Route 
    Route::controller(SupplierController::class)->group(function () {
        Route::get('/organization/all', 'SupplierAll')->name('supplier.all');
        Route::get('/organization/add', 'SupplierAdd')->name('supplier.add');
        Route::post('/organization/store', 'SupplierStore')->name('supplier.store');
        Route::get('/organization/edit/{id}', 'SupplierEdit')->name('supplier.edit');
        Route::post('/organization/update', 'SupplierUpdate')->name('supplier.update');
        Route::get('/organization/delete/{id}', 'SupplierDelete')->name('supplier.delete');
        Route::put('organization-status/{id}', 'changeStatus')->name('organization-status');
    });


    // Customer All Route 
    Route::controller(CustomerController::class)->group(function () {
        Route::get('/customer/all', 'CustomerAll')->name('customer.all');
        Route::get('/customer/add', 'CustomerAdd')->name('customer.add');
        Route::post('/customer/store', 'CustomerStore')->name('customer.store');
        Route::get('/customer/edit/{id}', 'CustomerEdit')->name('customer.edit');
        Route::post('/customer/update', 'CustomerUpdate')->name('customer.update');
        Route::get('/customer/delete/{id}', 'CustomerDelete')->name('customer.delete');

        Route::put('customer-status/{id}', 'changeStatus')->name('customer-status');

        Route::get('/credit/customer', 'CreditCustomer')->name('credit.customer');
        Route::get('/credit/customer/print/pdf', 'CreditCustomerPrintPdf')->name('credit.customer.print.pdf');

        Route::get('/customer/edit/order/{order_id}', 'CustomerEditOrder')->name('customer.edit.order');
        Route::post('/customer/update/order/{order_id}', 'CustomerUpdateOrder')->name('customer.update.order');

        Route::get('/customer/order/details/{order_id}', 'CustomerOrderDetails')->name('customer.order.details.pdf');

        Route::get('/paid/customer', 'PaidCustomer')->name('paid.customer');
        Route::get('/paid/customer/print/pdf', 'PaidCustomerPrintPdf')->name('paid.customer.print.pdf');

        Route::get('/customer/wise/report', 'CustomerWiseReport')->name('customer.wise.report');
        Route::get('/customer/wise/credit/report', 'CustomerWiseCreditReport')->name('customer.wise.credit.report');
        Route::get('/customer/wise/paid/report', 'CustomerWisePaidReport')->name('customer.wise.paid.report');
        Route::get('/customer/import-customers', 'importCustomers')->name('customer.import-customers');
        Route::get('/customer/download-file', 'downloadFile')->name('customer.download-file');
        Route::post('/customer/store-import-customers', 'storeImportCustomers')->name('customer.store-import-customers');
        
    });
    Route::get('/customer/reset-password/{reset_password}/resetPassword', [CustomerController::class, 'resetPassword'])->name('customer.reset-password');
    Route::post('/customer/reset-password/{reset_password}', [CustomerController::class, 'updateResetPassword'])->name('customer.update-reset-password');


    // Unit All Route 
    Route::controller(UnitController::class)->group(function () {
        Route::get('/unit/all', 'UnitAll')->name('unit.all');
        Route::get('/unit/add', 'UnitAdd')->name('unit.add');
        Route::post('/unit/store', 'UnitStore')->name('unit.store');
        Route::get('/unit/edit/{id}', 'UnitEdit')->name('unit.edit');
        Route::post('/unit/update', 'UnitUpdate')->name('unit.update');
        Route::get('/unit/delete/{id}', 'UnitDelete')->name('unit.delete');
        Route::put('unit-status/{id}', 'changeStatus')->name('unit-status');
    });
    Route::controller(EmployeeController::class)->group(function () {
        Route::get('/employee/all', 'EmployeeAll')->name('employee.all');
        Route::put('employee-status/{id}', 'changeStatus')->name('employee-status');
        Route::get('/employee/add', 'EmployeeAdd')->name('employee.add');
        Route::post('/employee/store', 'EmployeeStore')->name('employee.store');
        Route::get('/employee/edit/{id}', 'EmployeeEdit')->name('employee.edit');
        Route::post('/employee/update', 'EmployeeUpdate')->name('employee.update');
        Route::get('/employee/delete/{id}', 'EmployeeDelete')->name('employee.delete');
        Route::get('/employee/import-employees', 'importEmployees')->name('employee.import-employees');
        Route::get('/employee/download-file', 'downloadFile')->name('employee.download-file');
        Route::post('/employee/store-import-employees', 'storeImportEmployees')->name('employee.store-import-employees');
        
    });

    Route::get('reset-password/{reset_password}/resetPassword', [EmployeeController::class, 'resetPassword'])->name('reset-password');
    Route::post('reset-password/{reset_password}', [EmployeeController::class, 'updateResetPassword'])->name('update-reset-password');
    Route::post('api/fetch-divisions', [EmployeeController::class, 'fetchDivision']);
    Route::get('employee-division/{id}', [EmployeeController::class, 'getDivisions'])->name('employee-division');


    // Category All Route 
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/category/all', 'CategoryAll')->name('category.all');
        Route::get('/category/add', 'CategoryAdd')->name('category.add');
        Route::post('/category/store', 'CategoryStore')->name('category.store');
        Route::get('/category/edit/{id}', 'CategoryEdit')->name('category.edit');
        Route::post('/category/update', 'CategoryUpdate')->name('category.update');
        Route::get('/category/delete/{id}', 'CategoryDelete')->name('category.delete');
        Route::put('category-status/{id}', 'changeStatus')->name('category-status');
    });


    // Product All Route 
    Route::controller(ProductController::class)->group(function () {
        Route::get('/product/all', 'ProductAll')->name('product.all');
        Route::get('/product/add', 'ProductAdd')->name('product.add');
        Route::post('/product/store', 'ProductStore')->name('product.store');
        Route::get('/product/edit/{id}', 'ProductEdit')->name('product.edit');
        Route::post('/product/update', 'ProductUpdate')->name('product.update');
        Route::get('/product/delete/{id}', 'ProductDelete')->name('product.delete');
        Route::put('product-status/{id}', 'changeStatus')->name('product-status');
    });


    Route::get('product-gallery/{id}', [ProductGalleryController::class, 'index'])->name('product-gallery');
    Route::post('product-gallery-store', [ProductGalleryController::class, 'store'])->name('product-gallery.store');
    Route::get('product-gallery-delete/{id}', [ProductGalleryController::class, 'destroy'])->name('product-gallery.delete');
    Route::put('product-gallery-status/{id}', [ProductGalleryController::class, 'changeStatus'])->name('product-gallery-status');



    // Purchase All Route 
    Route::controller(PurchaseController::class)->group(function () {
        Route::get('/store/all', 'PurchaseAll')->name('purchase.all');
        Route::get('/store/add', 'PurchaseAdd')->name('purchase.add');
        Route::post('/store/store', 'PurchaseStore')->name('purchase.store');
        Route::get('/store/delete/{id}', 'PurchaseDelete')->name('purchase.delete');
        Route::get('/store/pending', 'PurchasePending')->name('purchase.pending');
        Route::get('/store/approve/{id}', 'PurchaseApprove')->name('purchase.approve');

        Route::get('/daily/store/report', 'DailyPurchaseReport')->name('daily.purchase.report');
        Route::get('/daily/store/pdf', 'DailyPurchasePdf')->name('daily.purchase.pdf');
    });


    // Order All Route 
    Route::controller(OrderController::class)->group(function () {
        Route::get('/order/all', 'OrderAll')->name('order.all');
        Route::get('/order/add', 'orderAdd')->name('order.add');
        Route::post('/order/store', 'OrderStore')->name('order.store');

        //Edit or update Order
        Route::get('/order/edit/{id}', 'OrderEdit')->name('order.edit');
        Route::post('/order/update', 'OrderUpdate')->name('order.update');
        //Convert Approve order to Pending Order
        Route::get('/order/movetopending/{id}', 'OrderConvertToPending')->name('order.pending');

        Route::get('/order/pending/list', 'PendingList')->name('order.pending.list');
        Route::get('/order/delete/{id}', 'OrderDelete')->name('order.delete');
        Route::get('/order/approve/{id}', 'OrderApprove')->name('order.approve');

        Route::post('/approval/store/{id}', 'ApprovalStore')->name('approval.store');
        Route::get('/print/order/list', 'PrintOrderList')->name('print.order.list');
        Route::get('/print/order/{id}', 'PrintOrder')->name('print.order');

        Route::get('/daily/order/report', 'DailyOrderReport')->name('daily.order.report');
        Route::get('/daily/order/pdf', 'DailyOrderPdf')->name('daily.order.pdf');
    });
    Route::post('api/invoicesList', [OrderController::class, 'fetchInvoices']);





    // Stock All Route 
    Route::controller(StockController::class)->group(function () {
        Route::get('/stock/report', 'StockReport')->name('stock.report');
        Route::get('/stock/report/pdf', 'StockReportPdf')->name('stock.report.pdf');

        Route::get('/stock/supplier/wise', 'StockSupplierWise')->name('stock.supplier.wise');
        Route::get('/supplier/wise/pdf', 'SupplierWisePdf')->name('supplier.wise.pdf');
        Route::get('/product/wise/pdf', 'ProductWisePdf')->name('product.wise.pdf');
    });

    // Route::resource('beat', BeatController::class);
    Route::controller(BeatController::class)->group(function () {
        Route::get('/beat', 'index')->name('beat.index');
        Route::get('/beat/show/{id}', 'show')->name('beat.show');
        Route::get('/beat/create', 'create')->name('beat.create');
        Route::post('/beat/store', 'store')->name('beat.store');
        Route::get('/beat/edit/{id}', 'edit')->name('beat.edit');
        Route::post('/beat/update', 'update')->name('beat.update');
    });
    Route::get('beat-report', [BeatController::class, 'beatReport'])->name('beat.report');
    Route::get('beat-view/{eod_id}', [BeatController::class, 'viewBeat'])->name('beat-view');
    Route::put('beat-status/{id}', [BeatController::class, 'changeStatus'])->name('beat-status');
    Route::get('assign-customers-to-beat/{id}', [BeatController::class, 'assignCustomersToBeat'])->name('assign-customers-to-beat');
    Route::put('update-beat-customers/{id}', [BeatController::class, 'updateBeatCustomers'])->name('update-beat-customers');
    Route::resource('department', DepartmentController::class);
    Route::put('department-status/{id}', [DepartmentController::class, 'changeStatus'])->name('department-status');
    Route::resource('division', DivisionController::class);
    Route::put('division-status/{id}', [DivisionController::class, 'changeStatus'])->name('division-status');

    Route::resource('target', TargetController::class);
    Route::put('target-status/{id}', [TargetController::class, 'changeStatus'])->name('target-status');
    Route::get('target-products/{id}', [TargetController::class, 'getProducts'])->name('target-products');

    Route::resource('assign_pjp', AssignPjpController::class);
    Route::get('assign_pjp-edit/{id}', [AssignPjpController::class, 'edit'])->name('assign_pjp-edit');
    Route::put('assign_pjp-status/{id}', [AssignPjpController::class, 'changeStatus'])->name('beat-status');
}); // End Group Middleware


    Route::resource('payment',IpaymentController::class);
    Route::get('payment-edit/{id}', [IpaymentController::class, 'edit'])->name('payment-edit');
    Route::get('partial-adjust', [IpaymentController::class, 'partialAdjust'])->name('payment.partial-adjust');
    Route::post('api/fetch-outstandings', [IpaymentController::class, 'fetchOutstandings']);
    Route::post('api/save-adjustment-payment', [IpaymentController::class, 'saveAdjustmentPayment']);
    Route::post('api/fetch-invoicesList', [IpaymentController::class, 'fetchAdjustedInvoices']);
    Route::get('fully-adjust', [IpaymentController::class, 'fullyAdjust'])->name('payment.fully-adjust');

    Route::resource('outstanding',OutstandingController::class);
    Route::post('api/fetch-paymentsList', [OutstandingController::class, 'fetchAdjustedPayments']);

    Route::get('ledger',[LedgerController::class,'index'])->name('ledger.list');
    Route::post('ledger', [LedgerController::class, 'index'])->name('ledger.fetch');

    Route::resource('saleorder',SaleOrderController::class);
    Route::resource('holiday',HolidayController::class);
    // Leave Type All Route 
    Route::controller(LeaveTypeController::class)->group(function () {
        Route::get('/leavetype/all', 'LeaveTypeAll')->name('leavetype.all');
        Route::put('leavetype-status/{id}', 'changeStatus')->name('leavetype-status');
        Route::get('/leavetype/add', 'LeaveTypeAdd')->name('leavetype.add');
        Route::post('/leavetype/store', 'LeaveTypeStore')->name('leavetype.store');
        Route::get('/leavetype/edit/{id}', 'LeaveTypeEdit')->name('leavetype.edit');
        Route::post('/leavetype/update', 'LeaveTypeUpdate')->name('leavetype.update');

    });
    Route::resource('leave',LeaveController::class);



// Default All Route 
Route::controller(DefaultController::class)->group(function () {
    Route::get('/get-category', 'GetCategory')->name('get-category');
    Route::get('/get-product', 'GetProduct')->name('get-product');
    Route::get('/check-product', 'GetStock')->name('check-product-stock');
});


// Invoice All Routes
Route::controller(InvoiceController::class)->group(function () {
    Route::get('/invoices', 'InvoiceList')->name('invoice.list');
    Route::get('/order/invoice/{id}', 'GenrateInvoice')->name('invoice.genrate');
    Route::post('/order/invoice/store', 'GenrateInvoiceStore')->name('invoice.genrate-store');
    Route::get('/inv-duplicate','duplicateCheck')->name('invoice.duplicate-check');
});


// Route::get('/dashboard', function () {
//     return view('admin.index');
// })->middleware(['auth'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('dashboard', DashboardController::class);
Route::get('/dashboard/products-by-categories/{id}/{order_invoice}/{supplier_id?}', [DashboardController::class, 'getProductsByCategories'])->name('dashboard.products-by-categories');
Route::get('/dashboard/product-data/{id}/{order_invoice}/{supplier_id?}', [DashboardController::class, 'getProductData'])->name('dashboard.product-data');
Route::get('/dashboard/get-order/{id}', [DashboardController::class, 'getOrder'])->name('dashboard.getOrder');
Route::get('/dashboard/getInvoice/{id}', [DashboardController::class, 'getInvoice'])->name('dashboard.getInvoice');
Route::get('/dashboard/get-invoice/{id}', [DashboardController::class, 'getInvoiceStatus'])->name('dashboard.getInvoiceStatus');
Route::get('/dashboard/get-invoice-payment/{id}', [DashboardController::class, 'getInvoicePaymentStatus'])->name('dashboard.getInvoicePaymentStatus');

//Run migrate:
Route::get('/migrate', function () {
    Artisan::call('migrate');
    return '<h1>Migrated</h1>';
});

require __DIR__ . '/auth.php';


// Route::get('/contact', function () {
//     return view('contact');
// });
