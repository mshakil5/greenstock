<?php


use Illuminate\Support\Facades\Route;


use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StockTransferController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ChartOfAccountController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\IncomeController;
use App\Http\Controllers\Admin\LiabilityController;
use App\Http\Controllers\Admin\EquityController;
use App\Http\Controllers\Admin\EquityHolderController;
use App\Http\Controllers\Admin\LedgerController;
use App\Http\Controllers\Admin\DaybookController;
use App\Http\Controllers\Admin\CashflowController;
use App\Http\Controllers\Admin\IncomestatementController;
use App\Http\Controllers\Admin\BalancesheetController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\CompanyDetailsController;
use App\Http\Controllers\Admin\FinancialStatementController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ServiceSalesController;

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::group(['prefix' =>'admin/', 'middleware' => ['auth', 'is_admin']], function(){
  
    Route::get('home', [HomeController::class, 'adminHome'])->name('admin.home');


    // add Branch
    Route::get('/branch', [BranchController::class, 'view_branch'])->name('view_branch');
    Route::get('/branch-all', [BranchController::class, 'get_all_branch']);
    Route::post('/branch', [BranchController::class, 'save_branch']);
    Route::get('/published-branch/{id}', [BranchController::class, 'published_branch']);
    Route::get('/unpublished-branch/{id}', [BranchController::class, 'unpublished_branch']);
    Route::post('/edit-branch/{id}', [BranchController::class, 'edit_branch']);
    
    //System User
    Route::get('/create-user', [UserController::class, 'create_user'])->name('create_user');
    Route::post('/create-user', [UserController::class, 'save_user'])->name('save_user');
    Route::get('/manage-user', [UserController::class, 'manage_user'])->name('manage_user');
    Route::post('/update-user', [UserController::class, 'update_user'])->name('update_user');

    Route::get('/create-employee', [EmployeeController::class, 'create_employee'])->name('create_employee');
    Route::post('/create-employee', [EmployeeController::class, 'save_employee'])->name('save_employee');
    Route::get('/manage-employee', [EmployeeController::class, 'manage_employee'])->name('manage_employee');
    Route::post('/update-employee', [EmployeeController::class, 'update_employee'])->name('update_employee');

    Route::get('/create-admin', [UserController::class, 'create_admin'])->name('create_admin');
    Route::post('/create-admin', [UserController::class, 'save_admin'])->name('save_admin');
    Route::get('/manage-admin', [UserController::class, 'manage_admin'])->name('manage_admin');
    Route::post('/update-admin', [UserController::class, 'update_admin'])->name('update_admin');
    Route::get('/super-admin', [UserController::class, 'super_admin'])->name('super_admin');
    Route::post('/update-super-admin', [UserController::class, 'update_super_admin'])->name('update_super_admin');
    
    Route::get('/published-user/{id}', [UserController::class, 'published_user']);
    Route::get('/unpublished-user/{id}', [UserController::class, 'unpublished_user']);

    // switch branch
    Route::get('/switch-branch', [UserController::class, 'switch_branch'])->name('switch_branch');
    Route::post('/switch-branch', [UserController::class, 'switch_branch_store'])->name('switch_branch_store');

    // add product
    Route::get('add-product', [ProductController::class, 'addProduct'])->name('admin.addproduct');
    Route::get('product-edit/{id}', [ProductController::class, 'editProduct'])->name('admin.editproduct');
    Route::get('manage-product', [ProductController::class, 'view_manage_product'])->name('admin.manage_product');
    Route::get('filter-all', [ProductController::class, 'filter_product'])->name('admin.filter_product');
    Route::get('product-info/{product}', [ProductController::class, 'get_product']);
    Route::post('update-product-details', [ProductController::class, 'update_product_details']);

    // add category
    Route::get('/product-category', [CategoryController::class, 'view_product_category'])->name('view_product_category');
    // Route::get('/category-all', [CategoryController::class, 'get_all_category']);
    Route::post('/category', [CategoryController::class, 'save_category']);
    Route::get('/published-category/{id}', [CategoryController::class, 'published_category']);
    Route::get('/unpublished-category/{id}', [CategoryController::class, 'unpublished_category']);
    Route::post('/edit-category/{id}', [CategoryController::class, 'edit_category']);

    // add brand
    Route::get('/product-brand', [BrandController::class, 'view_product_brand'])->name('view_product_brand');
    // Route::get('/brand-all', [BrandController::class, 'get_all_brand']);
    Route::post('/brand', [BrandController::class, 'save_brand']);
    Route::get('/published-brand/{id}', [BrandController::class, 'published_brand']);
    Route::get('/unpublished-brand/{id}', [BrandController::class, 'unpublished_brand']);
    Route::post('/edit-brand/{id}', [BrandController::class, 'edit_brand']);

    // company
    Route::get('company', [CompanyController::class, 'index'])->name('admin.company');
    Route::post('company', [CompanyController::class, 'store']);
    Route::get('company/{id}', [CompanyController::class, 'edit']);
    Route::put('company/{id}', [CompanyController::class, 'update']);

    // add group
    Route::get('/product-group', [GroupController::class, 'view_product_group'])->name('view_product_group');
    // Route::get('/group-all', [GroupController::class, 'get_all_group']);
    Route::post('/group', [GroupController::class, 'save_group']);
    Route::get('/published-group/{id}', [GroupController::class, 'published_group']);
    Route::get('/unpublished-group/{id}', [GroupController::class, 'unpublished_group']);
    Route::post('/edit-group/{id}', [GroupController::class, 'edit_group']);

    // add size
    Route::get('/product-size', [SizeController::class, 'view_product_size'])->name('view_product_size');
    Route::get('/size-all', [SizeController::class, 'get_all_size']);
    Route::post('/size', [SizeController::class, 'save_size']);
    Route::get('/published-size/{id}', [SizeController::class, 'published_size']);
    Route::get('/unpublished-size/{id}', [SizeController::class, 'unpublished_size']);
    Route::post('/edit-size/{id}', [SizeController::class, 'edit_size']);
    
    //Vendor
    Route::get('suppliers', [VendorController::class, 'add_vendor'])->name('admin.addvendor');
    Route::post('supplier/save', [VendorController::class, 'save_vendor'])->name('admin.savevendor');
    Route::post('supplier/update', [VendorController::class, 'update_vendor'])->name('admin.updatevendor');
    Route::get('supplier/type', [VendorController::class, 'vendor_type'])->name('admin.addtype');
    Route::post('supplier/type', [VendorController::class, 'save_type']);

    // Customer
    Route::get('customers', [CustomerController::class, 'index'])->name('admin.addcustomer');
    Route::post('customers', [CustomerController::class, 'store']);
    Route::get('customers/{id}', [CustomerController::class, 'edit']);
    Route::put('customers/{id}', [CustomerController::class, 'update']);
    Route::get('customers/{id}/change-status', [CustomerController::class, 'changeStatus']);

    // service section
    Route::get('add-services', [ServiceController::class, 'addService'])->name('admin.addService');
    Route::post('add-services', [ServiceController::class, 'storeService'])->name('admin.storeService');
    Route::post('update-services', [ServiceController::class, 'updateService'])->name('admin.updateService');
    Route::get('all-services', [ServiceController::class, 'allService'])->name('admin.manageService');
    Route::get('services-edit/{id}', [ServiceController::class, 'serviceEdit'])->name('admin.serviceEdit');

    // stock
    Route::get('add-stock', [StockController::class, 'addstock'])->name('admin.addstock');
    Route::get('purchase-edit/{id}', [StockController::class, 'editpurchase'])->name('admin.purchaseedit');
    Route::get('purchase-return/{id}', [StockController::class, 'purchaseReturn'])->name('admin.purchasereturn');
    Route::post('purchase-return/{id}', [StockController::class, 'purchaseReturnStore']);
    Route::post('add-stock', [StockController::class, 'stockStore']);
    Route::post('update-purchase', [StockController::class, 'purchaseUpdate']);
    Route::post('update-stock', [StockController::class, 'stockUpdate']);
    Route::get('stock-history/{id}', [StockController::class, 'stockHistory'])->name('admin.stockhistory');
    Route::get('stock-re-entry', [StockController::class, 'stockReEntry'])->name('stock-re-entry');
    Route::get('stock-re-entry-product-push/{id}', [StockController::class, 'pushProduct']);
    Route::get('stock-re-entry-old-purchase-get/{id}', [StockController::class, 'getOldPurchase']);
    Route::get('filter-stock-all', [StockController::class, 'filter_product'])->name('stock.filterall');
    Route::get('manage-stock', [StockController::class, 'managestock'])->name('admin.managestock');
    Route::post('manage-stock', [StockController::class, 'managestock'])->name('managestock.search');
    Route::get('stock-return-history', [StockController::class, 'stockReturnHistory'])->name('admin.stockReturnHistory');
    Route::get('damaged-products', [StockController::class, 'damagedProducts'])->name('admin.damagedProducts');

    // stock history 
    Route::get('product-purchase-history', [StockController::class, 'productPurchaseHistory'])->name('admin.product.purchasehistory');

    // stock transfer history
    Route::get('stock-transfer-request', [StockTransferController::class, 'stock_transfer_request'])->name('admin.stock.transferrequest');
    Route::post('save-stock-transfer', [StockTransferController::class, 'saveStockTransfer'])->name('admin.stock.transfer');
    Route::get('stock-transfer-history', [StockController::class, 'stock_transfer_history'])->name('admin.stock.transferhistory');
    // admin stock transfer
    Route::post('admin-stock-transfer', [StockTransferController::class, 'adminStockTransfer'])->name('admin.stock.transfer');

    // product return
    Route::post('save-product-return', [StockController::class, 'saveStockReturn'])->name('admin.stock.return');

    // invoices
    Route::get('all-sellsinvoice', [InvoiceController::class, 'all_sell_invoice'])->name('admin.allsellinvoice');
    Route::get('invoice/{id}', [InvoiceController::class, 'get_invoice'])->name('admin.get_invoice');
    Route::get('invoice-download/{id}', [InvoiceController::class, 'customer_invoice_download'])->name('admin.download_invoice');
    Route::get('filter', [InvoiceController::class, 'filter'])->name('invoice-filter');

    // payment method
    Route::get('payment-method', [PaymentMethodController::class, 'view_payment_method'])->name('view_payment_method');
    Route::get('method-all', [PaymentMethodController::class, 'get_all_method']);
    Route::post('payment-method', [PaymentMethodController::class, 'save_method']);
    Route::get('published-method/{id}', [PaymentMethodController::class, 'published_method']);
    Route::get('unpublished-method/{id}', [PaymentMethodController::class, 'unpublished_method']);
    Route::post('edit-method/{id}', [PaymentMethodController::class, 'edit_method']);

    // for purchase 
    Route::post('getproduct', [ProductController::class, 'getproduct']);
    Route::post('getservice', [ServiceSalesController::class, 'getservice']);

    Route::get('sales', [SalesController::class, 'sales'])->name('admin.sales');
    Route::post('sales-store', [SalesController::class, 'salesStore'])->name('admin.sales.store');
    Route::post('service-sales-store', [SalesController::class, 'serviceSalesStore'])->name('admin.ServiceSales.store');
    Route::get('service-sales/{id}', [SalesController::class, 'serviceSalesEdit'])->name('admin.serviceSales.edit');
    Route::post('service-sales-update', [SalesController::class, 'serviceSalesUpdate'])->name('admin.ServiceSales.update');
    Route::get('sales-edit/{id}', [SalesController::class, 'salesEdit'])->name('admin.sales.edit');
    Route::post('sales-update', [SalesController::class, 'salesUpdate'])->name('admin.sales.update');

    Route::post('quotation-store', [SalesController::class, 'quotationStore'])->name('admin.quotation.store');
    Route::get('quotation-edit/{id}', [SalesController::class, 'quotationEdit'])->name('admin.quotation.edit');
    Route::post('quotation-update', [SalesController::class, 'quotationUpdate'])->name('admin.quotation.update');

    Route::post('delivery-note-store', [SalesController::class, 'deliveryNoteStore'])->name('admin.deliverynote.store');
    Route::get('delivery-note-edit/{id}', [SalesController::class, 'deliveryNoteEdit'])->name('admin.deliverynote.edit');
    Route::post('delivery-note-update', [SalesController::class, 'deliveryNoteUpdate'])->name('admin.deliverynote.update');

    Route::get('all-quotation', [SalesController::class, 'getAllQuoation'])->name('admin.allquotation');
    Route::get('filter-quotation', [SalesController::class, 'filterQuotation'])->name('quotation-filter.admin');

    Route::get('all-delivery-note', [SalesController::class, 'getAllDeliveryNote'])->name('admin.alldeliverynote');
    Route::get('filter-delivery-note', [SalesController::class, 'filterDeliveryNote'])->name('delivery-note-filter.admin');

    Route::get('/sales-return/{id}', [SalesController::class, 'salesReturn'])->name('admin.sales.return');
    Route::get('all-sales-return', [SalesController::class, 'getAllReturnInvoice'])->name('admin.allreturninvoices');
    Route::post('saveCustomer', [SalesController::class, 'saveCustomer'])->name('admin.saveCustomer');

    // service order
    Route::get('service-sales', [ServiceSalesController::class, 'salesService'])->name('admin.salesService');
    Route::get('service-request', [ServiceSalesController::class, 'salesServiceRequest'])->name('admin.salesServiceRequest');
    Route::get('processing-service-request/{id}', [ServiceSalesController::class, 'processingServiceRequest'])->name('admin.processingService');
    Route::post('service-request', [ServiceSalesController::class, 'salesServiceRequestStore'])->name('salesServiceRequestStore');
    Route::post('check-bill-no-exits', [ServiceSalesController::class, 'checkBillNoExists'])->name('checkBillNoExists');


    Route::get('get-service-request', [ServiceSalesController::class, 'getServiceRequest'])->name('admin.getServiceRequest');


    Route::get('get-service-request-processing', [ServiceSalesController::class, 'getServiceRequestProcessing'])->name('admin.getServiceRequestProcessing');
    Route::get('get-service-request-pending', [ServiceSalesController::class, 'getServiceRequestPending'])->name('admin.getServiceRequestPending');
    Route::get('get-service-request-precomplete', [ServiceSalesController::class, 'getServiceRequestPrecomplete'])->name('admin.getServiceRequestPrecomplete');
    Route::get('get-service-request-complete', [ServiceSalesController::class, 'getServiceRequestComplete'])->name('admin.getServiceRequestComplete');
    Route::get('get-service-request-cancel', [ServiceSalesController::class, 'getServiceRequestCancel'])->name('admin.getServiceRequestCancel');


    Route::post('change-service-status', [ServiceSalesController::class, 'changeServiceStatus'])->name('admin.updateStatus');
    Route::get('get-service-status-review', [ServiceSalesController::class, 'getServiceStaffReview'])->name('admin.getStaffReviews');



    Route::get('order-new-product/{id}', [ServiceSalesController::class, 'orderNewProduct'])->name('admin.orderproduct');
    Route::post('order-new-product/save', [ServiceSalesController::class, 'orderNewProductStore'])->name('admin.orderNewProductStore');
    Route::post('order-new-product/update', [ServiceSalesController::class, 'orderNewProductUpdate'])->name('admin.orderNewProductUpdate');

    Route::get('order-assign-staff/{id}', [ServiceSalesController::class, 'orderAssignStaff'])->name('admin.assignStaff');
    Route::post('order-assign-staff/save', [ServiceSalesController::class, 'orderAssignStaffStore'])->name('admin.assignStaffStore');
    Route::post('order-assign-staff/update', [ServiceSalesController::class, 'assignStaffUpdate'])->name('admin.assignStaffUpdate');
    
    
    // partno status 
    Route::get('/published-partno/{id}', [OrderController::class, 'published_partno']);
    Route::get('/unpublished-partno/{id}', [OrderController::class, 'unpublished_partno']);

    // roles and permission
    Route::get('role', [RoleController::class, 'index'])->name('admin.role');
    Route::post('role', [RoleController::class, 'store'])->name('admin.rolestore');
    Route::get('role/{id}', [RoleController::class, 'edit'])->name('admin.roleedit');
    Route::post('role-update', [RoleController::class, 'update'])->name('admin.roleupdate');

    // reports
    Route::get('getreport-title', [ReportController::class, 'getReportTitle'])->name('report');
    Route::get('sales-report', [ReportController::class, 'getSalesReport'])->name('salesReport');
    Route::post('sales-report', [ReportController::class, 'getSalesReport'])->name('salesReport.search');

    Route::get('quotation-report', [ReportController::class, 'getQuotationReport'])->name('quotationReport');
    Route::post('quotation-report', [ReportController::class, 'getQuotationReport'])->name('quotationReport.search');

    Route::get('delivery-note-report', [ReportController::class, 'getDeliveryNoteReport'])->name('deliveryNoteReport');
    Route::post('delivery-note-report', [ReportController::class, 'getDeliveryNoteReport'])->name('deliveryNoteReport.search');

    Route::get('purchase-report', [ReportController::class, 'getPurchaseReport'])->name('purchaseReport');
    Route::post('purchase-report', [ReportController::class, 'getPurchaseReport'])->name('purchaseReport.search');

    Route::get('sales-return-report', [ReportController::class, 'getSalesReturnReport'])->name('salesReturnReport');
    Route::post('sales-return-report', [ReportController::class, 'getSalesReturnReport'])->name('salesReturnReport.search');

    Route::get('purchase-return-report', [ReportController::class, 'getPurchaseReturnReport'])->name('purchaseReturnReport');
    Route::post('purchase-return-report', [ReportController::class, 'getPurchaseReturnReport'])->name('purchaseReturnReport.search');

    Route::get('stock-transfer-report', [ReportController::class, 'getStockTransferReport'])->name('stockTransferReport');
    Route::post('stock-transfer-report', [ReportController::class, 'getStockTransferReport'])->name('stockTransferReport.search');
    
    Route::get('profit-loss-report', [ReportController::class, 'getProfitLossReport'])->name('profitLossReport');
    Route::post('profit-loss-report', [ReportController::class, 'getProfitLossReport'])->name('profitLossReport.search');

    //Chart of account
    Route::get('chart-of-account', [ChartOfAccountController::class, 'index'])->name('admin.addchartofaccount');
    Route::post('chart-of-accounts', [ChartOfAccountController::class, 'index'])->name('admin.addchartofaccount.filter');
    Route::post('chart-of-account', [ChartOfAccountController::class, 'store']);
    Route::get('chart-of-account/{id}', [ChartOfAccountController::class, 'edit']);
    Route::put('chart-of-account/{id}', [ChartOfAccountController::class, 'update']);
    Route::get('chart-of-account/{id}/change-status', [ChartOfAccountController::class, 'changeStatus']);

    //Equity holders
    Route::get('share-holders', [EquityHolderController::class, 'index'])->name('admin.equityholders');
    Route::post('share-holders', [EquityHolderController::class, 'store']);
    Route::get('share-holders/{id}', [EquityHolderController::class, 'edit']);
    Route::put('share-holders/{id}', [EquityHolderController::class, 'update']);
    Route::get('share-holders/{id}/change-status', [EquityHolderController::class, 'changeStatus']);

    // Share holder ledger
    Route::get('shareholder-ledger/{id}', [EquityHolderController::class, 'shareHolderLedger'])->name('admin.shareholders-ledger');

    //Expense
    Route::get('expense', [ExpenseController::class, 'index'])->name('admin.expense');
    Route::post('expenses', [ExpenseController::class, 'index'])->name('admin.expense.filter');
    Route::post('expense', [ExpenseController::class, 'store']);
    Route::get('expense/{id}', [ExpenseController::class, 'edit']);
    Route::put('expense/{id}', [ExpenseController::class, 'update']); 

    //Asset
    Route::get('asset', [AssetController::class, 'index'])->name('admin.asset');
    Route::post('assets', [AssetController::class, 'index'])->name('admin.asset.filter');
    Route::post('asset', [AssetController::class, 'store']);
    Route::get('asset/{id}', [AssetController::class, 'edit']);
    Route::put('asset/{id}', [AssetController::class, 'update']); 

    //Income
    Route::get('income', [IncomeController::class, 'index'])->name('admin.income');
    Route::post('incomes', [IncomeController::class, 'index'])->name('admin.income.filter');
    Route::post('income', [IncomeController::class, 'store']);
    Route::get('income/{id}', [IncomeController::class, 'edit']);
    Route::put('income/{id}', [IncomeController::class, 'update']); 

    //Liability
    Route::get('liabilities', [LiabilityController::class, 'index'])->name('admin.liabilities');
    Route::post('liability', [LiabilityController::class, 'index'])->name('admin.liability.filter');
    Route::post('liabilities', [LiabilityController::class, 'store']);
    Route::get('liabilities/{id}', [LiabilityController::class, 'edit']);
    Route::put('liabilities/{id}', [LiabilityController::class, 'update']); 

    //Equity
    Route::get('equity', [EquityController::class, 'index'])->name('admin.equity');
    Route::post('equities', [EquityController::class, 'index'])->name('admin.equity.filter');
    Route::post('equity', [EquityController::class, 'store']);
    Route::get('equity/{id}', [EquityController::class, 'edit']);
    Route::put('equity/{id}', [EquityController::class, 'update']); 

    //Ledger
    Route::get('ledger', [LedgerController::class, 'index'])->name('admin.ledger');
    Route::get('ledger/asset-details/{id}', [LedgerController::class, 'asset']);
    Route::get('ledger/expense-details/{id}', [LedgerController::class, 'expense']);
    Route::get('ledger/income-details/{id}', [LedgerController::class, 'income']);
    Route::get('ledger/liability-details/{id}', [LedgerController::class, 'liability']);
    Route::get('ledger/equity-details/{id}', [LedgerController::class, 'equity']);

    // Daybook
    Route::get('cashbook', [DaybookController::class, 'cashBook'])->name('admin.cashbook');
    Route::post('cashbook', [DaybookController::class, 'cashBook'])->name('admin.cashbook');
    Route::get('bankbook', [DaybookController::class, 'bankBook'])->name('admin.bankbook');
    Route::post('bankbook', [DaybookController::class, 'bankBook'])->name('admin.bankbook');

    //Financial Statement
    Route::get('cash-flow', [CashflowController::class, 'cashFlowByDate'])->name('admin.cashflow');
    Route::post('cash-flow', [CashflowController::class, 'cashFlowByDate'])->name('admin.cashflow');
    Route::get('income-statement', [IncomestatementController::class, 'incomeStatement'])->name('admin.incomestatement');
    Route::post('income-statement', [IncomestatementController::class, 'incomeStatement'])->name('admin.incomestatement');

    Route::get('get-start-date', [FinancialStatementController::class, 'getStartDate'])->name('admin.getStartDate');
    Route::post('get-start-date', [FinancialStatementController::class, 'postStartDate'])->name('admin.getStartDate');
    Route::get('balance-sheet', [FinancialStatementController::class, 'balanceSheet'])->name('admin.balancesheet');
    Route::post('balance-sheet', [FinancialStatementController::class, 'balanceSheet'])->name('admin.balancesheet');

    // company information
    Route::get('/company-details', [CompanyDetailsController::class, 'index'])->name('admin.companyDetail');
    Route::post('/company-details', [CompanyDetailsController::class, 'update'])->name('admin.companyDetails');
});