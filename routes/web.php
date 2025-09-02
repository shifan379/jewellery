<?php

use App\Http\Controllers\APP\BarcodeContoller;
use App\Http\Controllers\APP\CategoryController;
use App\Http\Controllers\APP\EmployeeController;
use App\Http\Controllers\APP\LocationController;
use App\Http\Controllers\APP\PurchaseController;
use App\Http\Controllers\APP\PurchaseOrderController;
use App\Http\Controllers\APP\PurchaseReturnController;
use App\Http\Controllers\APP\SalesController;
use App\Http\Controllers\APP\SalesReturnController;
use App\Http\Controllers\APP\StockAdjustmentController;
use App\Http\Controllers\APP\StockManageController;
use App\Http\Controllers\APP\StockTransferController;
use App\Http\Controllers\APP\SubCategoriesController;
use App\Http\Controllers\APP\SupplierController;
use App\Http\Controllers\APP\UnitController;
use App\Http\Controllers\APP\VariantController;
use App\Http\Controllers\APP\ProductsController;

use App\Http\Controllers\APP\CustomerController;
use App\Http\Controllers\APP\BrandController;
use App\Http\Controllers\APP\CustomerDueController;
use App\Http\Controllers\APP\InvoiceController;
use App\Http\Controllers\APP\QuotationController;
use App\Http\Controllers\APP\WarrantyController;
use App\Http\Controllers\POS\POSController;
use App\Http\Controllers\Report\PurchaseReportController;
use App\Http\Controllers\Report\SalesReportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    if (Auth::check()) {
        // Authenticated user - maybe redirect to dashboard/home
        return redirect('/dashboard');
    } else {
        // Guest - show login view or redirect to login route
        return redirect('/login');
    }

});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return view('app.dashboard');
    })->name('dashboard');

    // App Routes
    //Products
    Route::resource('product', ProductsController::class);
    Route::post('/products/next-item-code', [ProductsController::class, 'nextItemCode'])->name('products.nextItemCode');
    Route::post('/products/filter-by-category', [ProductsController::class, 'filterByCategory'])->name('products.filterByCategory');
    Route::post('/products/destroy', [ProductsController::class, 'destroy'])->name('products.destroy');
    Route::post('products/update/{id}', [ProductsController::class, 'update'])->name('products.update');
    // Export to excel
    Route::post('/products/export-selected', [ProductsController::class, 'exportSelected'])->name('products.exportSelected');
    // Export to pdf
    Route::post('/products/export-selected-pdf', [ProductsController::class, 'exportSelectedPdf'])->name('products.exportSelectedPdf');
    //AI Image
    Route::post('/products/generate-ai-image', [ProductsController::class, 'generateAiImage'])->name('products.generateAiImage');


    // print barcode
    Route::post('/barcode/print', [BarcodeContoller::class, 'print'])->name('barcode.print');

    // Expired Product List
    Route::get('expired-products', [ProductsController::class, 'expiredProducts'])->name('expired.products');
    Route::post('expired/filter-by-category', [ProductsController::class, 'expiredFilterByCategory'])->name('products.filterByCategory.expired');
    Route::post('restore-product', [ProductsController::class, 'restoreProduct'])->name('restore.product');
    // Low Stock Product List
    Route::get('low-stocks', [ProductsController::class, 'lowStockProducts'])->name('low-stock.product');
    Route::post('low-stock/product/edit', [ProductsController::class, 'lowStockProductsEdit'])->name('low-stock.product.edit');
    // Product list send into Email
    Route::post('products-sendviaEmail', [ProductsController::class, 'stockSendMail'])->name('products.sendviaEmail');

    //

    //Categories
    Route::resource('categories', CategoryController::class);
    Route::post('get/sub-data', [CategoryController::class, 'subData'])->name('get.sub.data');
    Route::post('category/filterByStatus', [CategoryController::class, 'filterByStatus'])->name('category.filterByStatus');
    Route::post('category/update', [CategoryController::class, 'update'])->name('category.update');


    // Customer view
    Route::get('customers', [CustomerController::class, 'index'])->name('customer');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{id}', [CustomerController::class, 'show'])->name('customers.show');
    Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    // Customer Download pdf
    Route::post('/customers/download-pdf', [CustomerController::class, 'downloadPdf'])->name('customers.downloadPdf');
    Route::post('/customers/download-excel', [CustomerController::class, 'downloadExcel'])->name('customers.downloadExcel');


    // Supplier Section
    Route::post('/suppliers/download-pdf', [SupplierController::class, 'downloadPdf'])->name('suppliers.downloadPdf');
    Route::post('/suppliers/download-excel', [SupplierController::class, 'downloadExcel'])->name('suppliers.downloadExcel');

    Route::get('suppliers', [SupplierController::class, 'index'])->name('suppliers');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('/suppliers/{id}', [SupplierController::class, 'show'])->name('suppliers.show');
    Route::put('/suppliers/{id}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

    // Location Section
    Route::post('/location/download-pdf', [LocationController::class, 'downloadPdf'])->name('location.downloadPdf');
    Route::post('/location/download-excel', [LocationController::class, 'downloadExcel'])->name('location.downloadExcel');
    Route::get('location', [LocationController::class, 'index'])->name('location');

    Route::post('/location', [LocationController::class, 'store'])->name('location.store');
    Route::get('/location/{id}', [LocationController::class, 'show'])->name('location.show');
    Route::put('/location/{id}', [LocationController::class, 'update'])->name('location.update');
    Route::delete('/location/{id}', [LocationController::class, 'destroy'])->name('location.destroy');


    //Categories
    Route::resource('categories', CategoryController::class);
    Route::post('get/sub-data', [CategoryController::class, 'subData'])->name('get.sub.data');
    Route::post('category/filterByStatus', [CategoryController::class, 'filterByStatus'])->name('category.filterByStatus');
    Route::post('category/update', [CategoryController::class, 'update'])->name('category.update');
    Route::post('category/destroy', [CategoryController::class, 'destroy'])->name('category.destroy');


    // Today Rate
    Route::get('today-rate', [CategoryController::class, 'todayRate'])->name('today.rate');
    Route::post('today-rate/store', [CategoryController::class, 'storeTodayRate'])->name('today.rate.store');
    Route::post('today-rate/update', [CategoryController::class, 'updateTodayRate'])->name('today.rate.update');
    Route::post('today-rate/destroy', [CategoryController::class, 'destroyTodayRate'])->name('today.rate.destroy');

    //Sub Categories
    Route::resource('sub-categories', SubCategoriesController::class)->only(['index', 'store', 'destroy']);
    Route::post('sub-categories/update', [SubCategoriesController::class, 'update'])->name('sub-categories.update');
    Route::post('sub-categories/filterByCategory', [SubCategoriesController::class, 'filterByCategory'])->name('subCategory.filterByCategory');
    Route::post('sub-categories/filterByStatus', [SubCategoriesController::class, 'filterByStatus'])->name('subCategory.filterByStatus');
    Route::post('sub-categories/destroy', [SubCategoriesController::class, 'destroy'])->name('subCategories.destroy');


    //Units Routes
    Route::resource('units', UnitController::class);
    Route::post('unit/update', [UnitController::class, 'update'])->name('unit.update');
    Route::post('unit/filterByStatus', [UnitController::class, 'filterByStatus'])->name('unit.filterByStatus');
    Route::post('unit/destroy', [UnitController::class, 'destroy'])->name('unit.destroy');


    // Purchase Routes

    Route::get('purchase', [PurchaseController::class, 'index'])->name('purchase');
    Route::post('/purchases', [PurchaseController::class, 'store'])->name('purchases.store');
    Route::get('/products/search', [PurchaseController::class, 'searchProducts'])->name('products.search');
    // Route::get('/suppliers/add', [SupplierController::class, 'create'])->name('supplier.view');
    Route::get('/purchase/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');

    Route::put('/purchases/{purchase}', [PurchaseController::class, 'update'])->name('purchases.update');
    Route::get('/purchases/{id}/items', [PurchaseController::class, 'getItems'])->name('purchases.edit');
    Route::delete('/purchases/{purchase}', [PurchaseController::class, 'destroy'])->name('purchases.destroy');

    Route::post('/purchases/export/pdf', [PurchaseController::class, 'downloadPurchasePdf'])->name('purchases.download.pdf');
    Route::post('/purchases/export/excel', [PurchaseController::class, 'downloadPurchaseExcel'])->name('purchases.download.excel');


    // PurchaseOrder Routes

    Route::get('purchase_order', [PurchaseOrderController::class, 'index'])->name('purchase.order');
    Route::post('/purchases/export/selected/pdf', [PurchaseOrderController::class, 'exportSelectedPdf'])->name('purchases.export.selected.pdf');
    Route::post('/purchases/export/selected/excel', [PurchaseOrderController::class, 'exportSelectedExcel'])->name('purchases.export.selected.excel');
    Route::post('/stock-transfers/export/pdf', [StockTransferController::class, 'exportPdf'])->name('stock-transfers.export.pdf');
    Route::post('/stock-transfers/export/excel', [StockTransferController::class, 'exportExcel'])->name('stock-transfers.export.excel');



    // PurchaseRetun Route

    Route::get('purchase_return', [PurchaseReturnController::class, 'index'])->name('purchase.return');
    Route::post('/purchase_returns', [PurchaseReturnController::class, 'store'])->name('purchase_returns.store');

    Route::get('/purchase/search-code', [PurchaseReturnController::class, 'searchByCode'])->name('search.by.code');
    Route::post('/purchases/details', [PurchaseReturnController::class, 'getPurchaseDetails'])->name('purchase.details');
    Route::post('/purchase-return/export', [PurchaseReturnController::class, 'export'])->name('purchase-return.export');
    Route::delete('/purchase/return/{purchase}', [PurchaseReturnController::class, 'destroy'])->name('purchaseReturn.destroy');


    // Manage Stock
    Route::get('stock_management', [StockManageController::class, 'index'])->name('manage_stock');
    Route::delete('/stocks/{id}', [StockManageController::class, 'destroy'])->name('stocks.destroy');
    Route::get('/stocks/export', [StockManageController::class, 'export'])->name('stocks.export');

    // Employee Routes
    Route::get('employee-view', [EmployeeController::class, 'index'])->name('employee.view');
    Route::get('add-employee', [EmployeeController::class, 'create'])->name('employee.create');
    Route::get('/generate-employee-code', [EmployeeController::class, 'generateEmployeeCode']);

    Route::get('edit-employee/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::get('employee-list', [EmployeeController::class, 'list'])->name('employee.list');

    Route::get('employee-details/{id}', [EmployeeController::class, 'details'])->name('employee.details');

    Route::post('add-employee', [EmployeeController::class, 'store'])->name('employee.store');
    Route::post('update-employee/{id}', [EmployeeController::class, 'update'])->name('employee.update');
    Route::delete('delete-employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.delete');
    Route::post('/export-employees', [EmployeeController::class, 'export'])->name('employees.export');

    // Sales Routes
    // Route::get('sales', [SalesController::class, 'index'])->name('sales.index');
    Route::get('/add-sales', [SalesController::class, 'index'])->name('sales');

    // Route::get('/add-sales', [SalesController::class, 'create'])->name('sales.create');
    Route::post('sales/scan', [SalesController::class, 'scan'])->name('sales.scan');
    Route::post('sales/addById', [SalesController::class, 'addById'])->name('sales.addById');
    Route::post('sales/qty/increase', [SalesController::class, 'increaseQty'])->name('sales.qty.increase');
    Route::post('sales/qty/decrease', [SalesController::class, 'decreaseQty'])->name('sales.qty.decrease');

    Route::post('edit/sales/cart', [SalesController::class, 'updateCart'])->name('edit.salesCard');
    Route::post('delete/sales/cart/product', [SalesController::class, 'deleteCartProduct'])->name('delete.cart.product');

    Route::post('/sales/main/discount', [SalesController::class, 'mainDiscount'])->name('sales.main.discount');
    Route::post('sales/save/order', [SalesController::class, 'saveOrder'])->name('save.onlineOrder');
    Route::get('/sales/customer-lookup', [SalesController::class, 'lookupCustomer'])->name('customer.lookup');
    Route::get('/sales/customer-lookup/byname', [SalesController::class, 'lookupCustomerName'])->name('customer.lookupByName');
    Route::post('sales/delete/cart/product', [SalesController::class, 'deleteCartProduct'])->name('delete.sales.cart.product');
    Route::post('sales/print', [SalesController::class, 'salesPrint'])->name('sales.print');

    Route::post('sales/void/cart', [SalesController::class, 'voidCart'])->name('sales.void.cart');


    // Sales Return

    Route::post('sales/pastBill', [SalesController::class, 'billTake'])->name('sales.bill.take');
    Route::post('sales/return/cart', [SalesController::class, 'returnProductToCart'])->name('sales.return.add.Cart');
    Route::post('sales/return/save', [SalesController::class, 'returnSave'])->name('sales.return.save');

    // Print Last Invoice in Sales
    Route::get('sales/print/lastReciept', [POSController::class, 'lastReciept'])->name('sales.print.lastReciept');



    // Stock Transfer Routes
    Route::get('stock-transfer', [StockTransferController::class, 'index'])->name('stock.transfer');
    Route::post('/stock-transfer', [StockTransferController::class, 'store'])->name('stock-transfer.store');

    Route::get('/stock-transfer/product-search', [StockTransferController::class, 'searchProduct'])->name('stock-transfer.product-search');
    Route::get('/stock-transfer/product-details/{id}', [StockTransferController::class, 'getProductStockDetails'])->name('stock-transfer.product-details');
    Route::delete('/stock-transfers/{id}', [StockTransferController::class, 'destroy'])->name('stock-transfers.destroy');

    // Stock Adjustment Routes
    Route::get('stock-adjustment', [StockAdjustmentController::class, 'index'])->name('stock.adjustment');
    // For updating product quantity
    Route::post('/stock-adjustment/update', [StockAdjustmentController::class, 'updateQuantity'])->name('stock.update');
    Route::delete('/stock-adjustment/{id}', [StockAdjustmentController::class, 'destroy'])->name('stock.destroy');
    Route::post('/stock-adjustment/export/', [StockAdjustmentController::class, 'export'])->name('stock.export');


    //Variant Routes
    Route::resource('variants', VariantController::class);
    Route::post('variant/update', [VariantController::class, 'update'])->name('variant.update');
    Route::post('variant/destroy', [VariantController::class, 'destroy'])->name('variant.destroy');

    // Warranty Routes
    Route::resource('warranty', WarrantyController::class);
    Route::post('warrantys/update', [WarrantyController::class, 'update'])->name('warrantys.update');
    Route::post('warrantys/destroy', [WarrantyController::class, 'destroy'])->name('warrantys.destroy');


    //Barcode
    Route::resource('barcode', BarcodeContoller::class);
    Route::post('barcodes-print', [BarcodeContoller::class, 'printBarcode'])->name('barcodes.print');
    Route::post('barcode-delete', [BarcodeContoller::class, 'destroy'])->name('barcode.delete');


    // POS Routes
    Route::get('pos', [POSController::class, 'index'])->name('pos');
    Route::post('pos/scan', [POSController::class, 'scan'])->name('pos.scan');
    Route::post('pos/addById', [POSController::class, 'addById'])->name('pos.addById');
    Route::post('pos/qty/increase', [POSController::class, 'increaseQty'])->name('pos.qty.increase');
    Route::post('pos/qty/decrease', [POSController::class, 'decreaseQty'])->name('pos.qty.decrease');
    Route::post('unitCart/update', [POSController::class, 'unitCart'])->name('unitCart.update');
    Route::post('edit/cart', [POSController::class, 'updateCart'])->name('edit.cart');

    Route::post('void/cart', [POSController::class, 'voidCart'])->name('void.cart');
    Route::post('main/discount', [POSController::class, 'mainDiscount'])->name('main.discount');
    // Pay In Amount
    Route::post('pos/payin', [POSController::class, 'payIn'])->name('pos.payin');
    // POS Main Save Function
    Route::post('save/order', [POSController::class, 'saveOrder'])->name('save.order');
    // Print Invoice for POS
    Route::post('pos/print', [POSController::class, 'posPrint'])->name('pos.print');

    // Return Functions in POS
    Route::post('pos/pastBill', [POSController::class, 'billTake'])->name('pos.bill.take');
    Route::post('pos/return/cart', [POSController::class, 'returnProductToCart'])->name('return.add.Cart');
    Route::post('return/save', [POSController::class, 'returnSave'])->name('return.save');

    // Print Last Invoice in POS
    Route::get('print/lastReciept', [POSController::class, 'lastReciept'])->name('print.lastReciept');

    // Invoice List
    Route::resource('invoice', InvoiceController::class);
    Route::post('invoice/destroy', [InvoiceController::class, 'destroy'])->name('invoice.destroy');
    Route::get('pos-format/{id}', [InvoiceController::class, 'posFormat'])->name('pos.format');
    Route::get('invoice-format/{id}', [InvoiceController::class, 'invoiceFormat'])->name('invoice.format');
    Route::post('invoice/export-selected-pdf', [InvoiceController::class, 'exportSelectedPdf'])->name('invoice.exportSelectedPdf');
    Route::post('invoices/destroy', [InvoiceController::class, 'destroy'])->name('invoices.destroy');

    //Customer Due
    Route::resource('customer-due', CustomerDueController::class);
    Route::post('customer-dues/destroy', [CustomerDueController::class, 'destroy'])->name('customer-dues.destroy');
    Route::post('customer-dues/update', [CustomerDueController::class, 'update'])->name('customer-dues.update');
    Route::post('customer-dues/filter-by', [CustomerDueController::class, 'filterBy'])->name('customer-dues.filterBy');

    // Report
    // 1. Today Profit Print in POS
    Route::get('print/today-profit', [POSController::class, 'todayProfit'])->name('print.todayProfit');

    //2. Sales Report
    Route::resource('salesReport', SalesReportController::class);
    Route::post('salesReport-execl', [SalesReportController::class, 'exportExecl'])->name('salesReport.execl');
    Route::post('get-products-by-location', [SalesReportController::class, 'getProductsByLocation'])->name('getProductsByLocation');
    Route::post('sales-report/filter-by-products', [SalesReportController::class, 'filterByProducts'])->name('filterByProducts');
    Route::post('sales-report/filter-by-date', [SalesReportController::class, 'filterByDate'])->name('filterByDate');
    //3. Purchase Report
    Route::resource('purchaseReport', PurchaseReportController::class);
    Route::post('purchaseReport-execl', [PurchaseReportController::class, 'exportExecl'])->name('purchaseReport.execl');
    Route::post('purchase-report/filter-by-products', [PurchaseReportController::class, 'filterByProducts'])->name('filterByProducts.purchase');

        // Quotation
    Route::resource('quotation', QuotationController::class);
    // Route::post('quotation/destroy', [QuotationController::class, 'destroy'])->name('quotation.destroy');
    Route::get('/products/search', [QuotationController::class, 'search'])->name('products.search');
    Route::post('quotation/addById', [QuotationController::class, 'addById'])->name('quotation.addById');
    Route::post('quotation/scan', [QuotationController::class, 'scan'])->name('quotation.scan');
    Route::get('/quotation/print/{id}', [QuotationController::class, 'print'])->name('quotation.print');

    //test view
    Route::get('test', function () {
        return view('welcome');
    });
});
