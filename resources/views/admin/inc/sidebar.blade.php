<ul class="sidebar-menu" data-widget="tree">

    <li class="{{ (request()->is('admin/home')) ? 'active' : '' }}">
        <a href="{{URL::to('/home')}}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>       

    @if(
        (Auth::user()->type == '1' && (in_array('1', json_decode(Auth::user()->role->permission)) || in_array('20', json_decode(Auth::user()->role->permission)) || in_array('37', json_decode(Auth::user()->role->permission)))) ||
        (Auth::user()->type == '0' && (in_array('1', json_decode(Auth::user()->role->permission)) || in_array('20', json_decode(Auth::user()->role->permission)) || in_array('37', json_decode(Auth::user()->role->permission))))
    )
    <li class="treeview {{ (request()->is('admin/add-product')) ? 'active' : '' }}{{ (request()->is('admin/manage-product')) ? 'active' : '' }}{{ (request()->is('admin/product-category')) ? 'active' : '' }}{{ (request()->is('admin/product-brand')) ? 'active' : '' }} {{ (request()->is('admin/product-brand')) ? 'active' : '' }}{{ (request()->is('admin/product-group')) ? 'active' : '' }} {{ request()->routeIs('admin.editproduct') ? 'active' : '' }}">
        <a href="#">
            <i class="fa fa-files-o"></i>
            <span> Products</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
            @if(Auth::user()->type == '1' && in_array('1', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('1', json_decode(Auth::user()->role->permission)))
                <li class="{{ (request()->is('admin/add-product')) ? 'active' : '' }}"><a href="{{ route('admin.addproduct')}}"><i class="fa fa-clone"></i> Add New Product</a> </li>
            @endif

            @if(Auth::user()->type == '1' && in_array('20', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('20', json_decode(Auth::user()->role->permission)))
                <li class="{{ (request()->is('admin/manage-product') || request()->routeIs('admin.editproduct')) ? 'active' : '' }}"><a href="{{ route('admin.manage_product')}}"><i class="fa fa-leaf"></i> Manage product</a> </li>
            @endif
            @if((Auth::user()->type == '1' || Auth::user()->type == '0') && in_array('37', json_decode(Auth::user()->role->permission)))
                {{-- <li class="{{ (request()->is('admin/product-category')) ? 'active' : '' }}"><a href="{{ route('view_product_category')}}"><i class="fa fa-credit-card"></i>Code</a></li> --}}
                <li class="{{ (request()->is('admin/product-brand')) ? 'active' : '' }}"><a href="{{ route('view_product_brand')}}"><i class="fa fa-credit-card"></i>Brand</a></li>
                <li class="{{ (request()->is('admin/product-group')) ? 'active' : '' }}"><a href="{{ route('view_product_group')}}"><i class="fa fa-credit-card"></i>Specification</a> </li>
            
                {{-- <li><a href="{{ route('view_product_size')}}"><i class="fa fa-credit-card"></i>Sizes</a>
                </li> --}}

            @endif
        </ul>
    </li>

    {{-- service section  --}}

    <li class="treeview {{ (request()->is('admin/add-services')) ? 'active' : '' }}{{ (request()->is('admin/all-services')) ? 'active' : '' }}">
        <a href="#">
            <i class="fa fa-files-o"></i>
            <span> Service Package</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
            
            <li class="{{ (request()->is('admin/add-services')) ? 'active' : '' }}"><a href="{{ route('admin.addService')}}"><i class="fa fa-clone"></i> Add New Package</a> </li>

            <li class="{{ (request()->is('admin/all-services') || request()->routeIs('admin.editproduct')) ? 'active' : '' }}"><a href="{{ route('admin.manageService')}}"><i class="fa fa-leaf"></i>  Package List</a> </li>
        </ul>
    </li>





    @endif


    @if(
        (Auth::user()->type == '1' && (in_array('5', json_decode(Auth::user()->role->permission)) || in_array('21', json_decode(Auth::user()->role->permission)) || in_array('7', json_decode(Auth::user()->role->permission)) || in_array('18', json_decode(Auth::user()->role->permission)) || in_array('19', json_decode(Auth::user()->role->permission)) || in_array('38', json_decode(Auth::user()->role->permission)))) ||
        (Auth::user()->type == '0' && (in_array('5', json_decode(Auth::user()->role->permission)) || in_array('21', json_decode(Auth::user()->role->permission)) || in_array('7', json_decode(Auth::user()->role->permission)) || in_array('18', json_decode(Auth::user()->role->permission)) || in_array('19', json_decode(Auth::user()->role->permission)) || in_array('38', json_decode(Auth::user()->role->permission))))
    )
    <li class="treeview {{ (request()->is('admin/add-stock')) ? 'active' : '' }} {{ (request()->is('admin/manage-stock')) ? 'active' : '' }} {{ (request()->is('admin/product-purchase-history')) ? 'active' : '' }} {{ (request()->is('admin/stock-transfer-request')) ? 'active' : '' }} {{ (request()->is('admin/stock-transfer-history')) ? 'active' : '' }} {{ (request()->is('admin/stock-return-history')) ? 'active' : '' }} {{ (request()->is('admin/damaged-products')) ? 'active' : '' }} {{ request()->routeIs('admin.purchaseedit') ? 'active' : '' }} {{ request()->routeIs('admin.purchasereturn') ? 'active' : '' }}">
        <a href="#">
            <i class="fa fa-clipboard"></i>
            <span>Stocks</span>
            <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
            @if(Auth::user()->type == '1' && in_array('5', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('5', json_decode(Auth::user()->role->permission)))
            <li class="{{ (request()->is('admin/add-stock')) ? 'active' : '' }}"><a href="{{ route('admin.addstock')}}"><i class="fa fa-plus"></i>Purchase </a></li>
            @endif
            @if(Auth::user()->type == '1' && in_array('21', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('21', json_decode(Auth::user()->role->permission)))
            <li class="{{ (request()->is('admin/manage-stock')) ? 'active' : '' }}"><a href="{{ route('admin.managestock')}}"><i class="fa fa-truck"></i> Stock List</a></li>
            @endif

            @if(Auth::user()->type == '1' && in_array('5', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('5', json_decode(Auth::user()->role->permission)))
            <li class="{{ (request()->is('admin/product-purchase-history') || request()->routeIs('admin.purchaseedit') || request()->routeIs('admin.purchasereturn')) ? 'active' : '' }}"><a href="{{ route('admin.product.purchasehistory')}}"><i class="fa fa-history"></i>Purchase History</a></li>
            @endif

            @if(Auth::user()->type == '1' && in_array('7', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('7', json_decode(Auth::user()->role->permission)))
            <li class="{{ (request()->is('admin/stock-transfer-request')) ? 'active' : '' }}"><a href="{{ route('admin.stock.transferrequest')}}"><i class="fa fa-history"></i>Stock Transfer Request</a></li>
            @endif

            @if(Auth::user()->type == '1' && in_array('18', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('18', json_decode(Auth::user()->role->permission)))
            <li class="{{ (request()->is('admin/stock-transfer-history')) ? 'active' : '' }}"><a href="{{ route('admin.stock.transferhistory')}}"><i class="fa fa-history"></i>Transferred History</a></li>
            @endif

            @if(Auth::user()->type == '1' && in_array('19', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('19', json_decode(Auth::user()->role->permission)))
            <li class="{{ (request()->is('admin/stock-return-history')) ? 'active' : '' }}"><a href="{{ route('admin.stockReturnHistory')}}"><i class="fa fa-undo"></i>Returned History</a></li>
            @endif

            @if((Auth::user()->type == '1' || Auth::user()->type == '0') && in_array('38', json_decode(Auth::user()->role->permission)))
            <li class="{{ (request()->is('admin/damaged-products')) ? 'active' : '' }}"><a href="{{ route('admin.damagedProducts')}}"><i class="fa fa-undo"></i>Damaged Products</a></li>
            @endif
        </ul>
    </li>
    @endif

    <li class="treeview {{ (request()->is('admin/all-sellsinvoice') || request()->is('admin/sales') || request()->is('admin/all-delivery-note') || request()->is('admin/all-quotation') || request()->is('admin/all-sales-return') || request()->routeIs('admin.sales.edit') || request()->routeIs('admin.sales.return') || request()->routeIs('admin.quotation.edit') || request()->routeIs('admin.deliverynote.edit')) ? 'active' : '' }}">
        <a href="#">
            <i class="fa fa-user"></i> <span>Sales</span><span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
            @if(Auth::user()->type == '1' && in_array('3', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('3', json_decode(Auth::user()->role->permission)))
            <li class="{{ (request()->is('admin/sales')) ? 'active' : '' }}">
                <a href="{{ route('admin.sales')}}"><i class="fa fa-adjust"></i>Product Sales
                </a>
            </li>
            @endif
            @if(Auth::user()->type == '1' && in_array('4', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('4', json_decode(Auth::user()->role->permission)))
            <li class="{{ (request()->is('admin/all-sellsinvoice') || request()->routeIs('admin.sales.edit') || request()->routeIs('admin.sales.return')) ? 'active' : '' }}">
                <a href="{{ route('admin.allsellinvoice')}}"><i class="fa fa-adjust"></i> Manage Sales
                </a>
            </li>
            @endif
            @if(Auth::user()->type == '1' && in_array('9', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('9', json_decode(Auth::user()->role->permission)))
            <li class="{{ (request()->is('admin/all-quotation') || request()->routeIs('admin.quotation.edit')) ? 'active' : '' }}">
                <a href="{{ route('admin.allquotation')}}"><i class="fa fa-adjust"></i> Quotations
                </a>
            </li>
            @endif
            {{-- @if(Auth::user()->type == '1' && in_array('11', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('11', json_decode(Auth::user()->role->permission)))
            <li class="{{ (request()->is('admin/all-delivery-note') || request()->routeIs('admin.deliverynote.edit')) ? 'active' : '' }}">
                <a href="{{ route('admin.alldeliverynote')}}"><i class="fa fa-adjust"></i> Delivery Notes
                </a>
            </li>
            @endif --}}
            @if((Auth::user()->type == '1' || Auth::user()->type == '0') && in_array('13', json_decode(Auth::user()->role->permission)))
            <li class="{{ (request()->is('admin/all-sales-return')) ? 'active' : '' }}">
                <a href="{{ route('admin.allreturninvoices')}}"><i class="fa fa-adjust"></i> Returned Products
                </a>
            </li>
            @endif
        </ul>
    </li>


    <li class="treeview {{ (request()->is('admin/service-sales') || request()->is('admin/service-sales') || request()->is('admin/service-sales')) ? 'active' : '' }}{{ (request()->is('admin/service-request')) ? 'active' : '' }}{{ (request()->is('admin/get-service-request')) ? 'active' : '' }}{{ (request()->is('admin/processing-service-request/*')) ? 'active' : '' }}">
        <a href="#">
            <i class="fa fa-user"></i> <span>Service Sales</span><span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">


            @if(Auth::user()->type == '1' && in_array('3', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('3', json_decode(Auth::user()->role->permission)))
            <li class="{{ (request()->is('admin/service-request')) ? 'active' : '' }}">
                <a href="{{ route('admin.salesServiceRequest')}}"><i class="fa fa-adjust"></i>Service Request
                </a>
            </li>

            <li class="{{ (request()->is('admin/get-service-request')) ? 'active' : '' }}{{ (request()->is('admin/processing-service-request/*')) ? 'active' : '' }}">
                <a href="{{ route('admin.getServiceRequest')}}"><i class="fa fa-adjust"></i>Manage Service Request
                </a>
            </li>

            <li class="{{ (request()->is('admin/get-service-request-pending')) ? 'active' : '' }}{{ (request()->is('admin/processing-service-request/*')) ? 'active' : '' }}">
                <a href="{{ route('admin.getServiceRequestPending')}}"><i class="fa fa-adjust"></i>Pending Service Request
                </a>
            </li>
            <li class="{{ (request()->is('admin/get-service-request-processing')) ? 'active' : '' }}{{ (request()->is('admin/processing-service-request/*')) ? 'active' : '' }}">
                <a href="{{ route('admin.getServiceRequestProcessing')}}"><i class="fa fa-adjust"></i>Processing Service Request
                </a>
            </li>
            <li class="{{ (request()->is('admin/get-service-request-precomplete')) ? 'active' : '' }}{{ (request()->is('admin/processing-service-request/*')) ? 'active' : '' }}">
                <a href="{{ route('admin.getServiceRequestPrecomplete')}}"><i class="fa fa-adjust"></i>Pre-complete Service Request
                </a>
            </li>
            <li class="{{ (request()->is('admin/get-service-request-complete')) ? 'active' : '' }}{{ (request()->is('admin/processing-service-request/*')) ? 'active' : '' }}">
                <a href="{{ route('admin.getServiceRequestComplete')}}"><i class="fa fa-adjust"></i>Complete Service Request
                </a>
            </li>

            @endif

            {{-- @if(Auth::user()->type == '1' && in_array('3', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('3', json_decode(Auth::user()->role->permission)))
            <li class="{{ (request()->is('admin/service-sales')) ? 'active' : '' }}">
                <a href="{{ route('admin.salesService')}}"><i class="fa fa-adjust"></i>Create Service Sales
                </a>
            </li>
            @endif --}}


            {{-- @if(Auth::user()->type == '1' && in_array('4', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('4', json_decode(Auth::user()->role->permission)))
            <li class="{{ (request()->is('admin/all-sellsinvoice') || request()->routeIs('admin.sales.edit') || request()->routeIs('admin.sales.return')) ? 'active' : '' }}">
                <a href="{{ route('admin.allsellinvoice')}}"><i class="fa fa-adjust"></i> Manage Sales
                </a>
            </li>
            @endif
            @if(Auth::user()->type == '1' && in_array('9', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('9', json_decode(Auth::user()->role->permission)))
            <li class="{{ (request()->is('admin/all-quotation') || request()->routeIs('admin.quotation.edit')) ? 'active' : '' }}">
                <a href="{{ route('admin.allquotation')}}"><i class="fa fa-adjust"></i> Quotations
                </a>
            </li>
            @endif
            @if(Auth::user()->type == '1' && in_array('11', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('11', json_decode(Auth::user()->role->permission)))
            <li class="{{ (request()->is('admin/all-delivery-note') || request()->routeIs('admin.deliverynote.edit')) ? 'active' : '' }}">
                <a href="{{ route('admin.alldeliverynote')}}"><i class="fa fa-adjust"></i> Delivery Notes
                </a>
            </li>
            @endif --}}
            
        </ul>
    </li>

    @if(Auth::user()->type == '1' && in_array('14', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('14', json_decode(Auth::user()->role->permission)))
    <li class="{{ (request()->is('admin/suppliers')) ? 'active' : '' }}">
        <a href="{{ route('admin.addvendor')}}">
            <i class="fa fa-users"></i>
            <span>Supplier</span>
            <span class="pull-right-container"> </span>
        </a>
    </li>
    @endif

    @if(Auth::user()->type == '1' && in_array('15', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('15', json_decode(Auth::user()->role->permission)))
    <li class="{{ (request()->is('admin/customers')) ? 'active' : '' }}">
        <a href="{{ route('admin.addcustomer')}}">
            <i class="fa fa-users"></i>
            <span>Customer</span>
            <span class="pull-right-container"> </span>
        </a>
    </li>

    <li class="{{ (request()->is('admin/company')) ? 'active' : '' }}">
        <a href="{{ route('admin.company')}}">
            <i class="fa fa-users"></i>
            <span>Company</span>
            <span class="pull-right-container"> </span>
        </a>
    </li>

    @endif


    @if(Auth::user()->type == '1' && in_array('16', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('16', json_decode(Auth::user()->role->permission)))
    <li class="{{ (request()->is('admin/branch')) ? 'active' : '' }} d-none">
        <a href="{{ route('view_branch')}}">
            <i class="fa fa-users"></i>
            <span>Branch</span>
            <span class="pull-right-container"> </span>
        </a>
    </li>
    @endif


    @if((Auth::user()->type == '1' || Auth::user()->type == '0') && in_array('24', json_decode(Auth::user()->role->permission)))
    <li class="{{ (request()->is('admin/chart-of-account')) ? 'active' : '' }} d-none">
        <a href="{{ route('admin.addchartofaccount')}}">
            <i class="fa fa-users"></i>
            <span>Chart Of Accounts</span>
            <span class="pull-right-container"> </span>
        </a>
    </li>
    @endif


    @if((Auth::user()->type == '1' || Auth::user()->type == '0') && in_array('25', json_decode(Auth::user()->role->permission)))
    <li class="{{ (request()->is('admin/income')) ? 'active' : '' }} d-none">
        <a href="{{ route('admin.income')}}">
            <i class="fa fa-users"></i>
            <span>Income</span>
            <span class="pull-right-container"> </span>
        </a>
    </li>
    @endif


    @if((Auth::user()->type == '1' || Auth::user()->type == '0') && in_array('26', json_decode(Auth::user()->role->permission)))
    <li class="{{ (request()->is('admin/expense')) ? 'active' : '' }} d-none">
        <a href="{{ route('admin.expense')}}">
            <i class="fa fa-users"></i>
            <span>Expense</span>
            <span class="pull-right-container"> </span>
        </a>
    </li>
    @endif


    @if((Auth::user()->type == '1' || Auth::user()->type == '0') && in_array('27', json_decode(Auth::user()->role->permission)))
    <li class="{{ (request()->is('admin/asset')) ? 'active' : '' }} d-none">
        <a href="{{ route('admin.asset')}}">
            <i class="fa fa-users"></i>
            <span>Assets</span>
            <span class="pull-right-container"> </span>
        </a>
    </li>
    @endif


    @if((Auth::user()->type == '1' || Auth::user()->type == '0') && in_array('28', json_decode(Auth::user()->role->permission)))
    <li class="{{ (request()->is('admin/liabilities')) ? 'active' : '' }} d-none">
        <a href="{{ route('admin.liabilities')}}">
            <i class="fa fa-users"></i>
            <span>Liabilities</span>
            <span class="pull-right-container"> </span>
        </a>
    </li>
    @endif


    @if((Auth::user()->type == '1' || Auth::user()->type == '0') && in_array('29', json_decode(Auth::user()->role->permission)))
    <li class="{{ (request()->is('admin/equity')) ? 'active' : '' }} d-none">
        <a href="{{ route('admin.equity')}}">
            <i class="fa fa-users"></i>
            <span>Equity</span>
            <span class="pull-right-container"> </span>
        </a>
    </li>
    @endif


    @if((Auth::user()->type == '1' || Auth::user()->type == '0') && in_array('30', json_decode(Auth::user()->role->permission)))
    <li class="{{ (request()->is('admin/ledger*')) ? 'active' : '' }} d-none">
        <a href="{{ route('admin.ledger')}}">
            <i class="fa fa-users"></i>
            <span>Ledger</span>
            <span class="pull-right-container"> </span>
        </a>
    </li>
    @endif

    
    @if((Auth::user()->type == '1' || Auth::user()->type == '0') && in_array('31', json_decode(Auth::user()->role->permission)))
    <li class="treeview {{ (request()->is('admin/cashbook') || request()->is('admin/bankbook')) ? 'active' : '' }}">
        <a href="#">
            <i class="fa fa-user"></i> <span>Day Book</span><span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
            <li class="{{ (request()->is('admin/cashbook')) ? 'active' : '' }}"><a href="{{ route('admin.cashbook') }}"><i class="fa fa-adjust"></i> Day Cashbook</a></li>
            <li class="{{ (request()->is('admin/bankbook')) ? 'active' : '' }}"><a href="{{ route('admin.bankbook') }}"><i class="fa fa-adjust"></i> Day Bankbook</a></li>
        </ul>
    </li>
    @endif

    @if(Auth::user()->type == '1' && in_array('32', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('32', json_decode(Auth::user()->role->permission)))
    <li class="treeview {{ (request()->is('admin/cash-flow') || request()->is('admin/income-statement') || request()->is('admin/balance-sheet')) ? 'active' : '' }} d-none">
        <a href="#">
            <i class="fa fa-user"></i> <span>Financial Statement</span><span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
            <li class="{{ (request()->is('admin/cash-flow')) ? 'active' : '' }}"><a href="{{ route('admin.cashflow') }}"><i class="fa fa-adjust"></i> Cash Flow</a></li>
            <li class="{{ (request()->is('admin/income-statement')) ? 'active' : '' }}"><a href="{{ route('admin.incomestatement') }}"><i class="fa fa-adjust"></i>Income Statement</a></li>
            <li class="{{ (request()->is('admin/balance-sheet')) ? 'active' : '' }}"><a href="{{ route('admin.getStartDate') }}"><i class="fa fa-adjust"></i>Balance Sheet</a></li>
        </ul>
    </li>
    @endif

    @if(Auth::user()->type == '1' && in_array('33', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('33', json_decode(Auth::user()->role->permission)))
    <li class="{{ request()->routeIs('admin.equityholders', 'admin.shareholders-ledger') ? 'active' : '' }} d-none">
        <a href="{{ route('admin.equityholders')}}">
            <i class="fa fa-users"></i>
            <span>Share Holders</span>
            <span class="pull-right-container"> </span>
        </a>
    </li>
    @endif

    @if(Auth::user()->type == '1' && in_array('23', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('23', json_decode(Auth::user()->role->permission)))
    <li class="{{ (request()->is('admin/getreport-title')) ? 'active' : '' }}{{ (request()->is('admin/sales-report')) ? 'active' : '' }}{{ (request()->is('admin/sales-return-report')) ? 'active' : '' }}{{ (request()->is('admin/quotation-report')) ? 'active' : '' }}{{ (request()->is('admin/delivery-note-report')) ? 'active' : '' }}{{ (request()->is('admin/purchase-report')) ? 'active' : '' }}{{ (request()->is('admin/purchase-return-report')) ? 'active' : '' }}{{ (request()->is('admin/stock-transfer-report')) ? 'active' : '' }}">
        <a href="{{ route('report')}}">
            <i class="fa fa-users"></i>
            <span>Report</span>
            <span class="pull-right-container"> </span>
        </a>
    </li>
    @endif

    
    <li class="treeview {{ (request()->is('admin/role*')) ? 'active' : '' }}{{ (request()->is('admin/manage-user')) ? 'active' : '' }}{{ (request()->is('admin/create-user')) ? 'active' : '' }}{{ (request()->is('admin/manage-admin')) ? 'active' : '' }}{{ (request()->is('admin/create-admin')) ? 'active' : '' }}{{ (request()->is('admin/create-employee')) ? 'active' : '' }}{{ (request()->is('admin/manage-employee')) ? 'active' : '' }}">
        <a href="#">
            <i class="fa fa-users"></i>
            <span>System Users</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
            <!-- <li class="{{ (request()->is('admin/create-user')) ? 'active' : '' }}"><a href="{{ route('create_user')}}"><i class="fa fa-plus"></i> Add New User</a>
            </li> -->
            <!-- <li class="{{ (request()->is('admin/manage-user')) ? 'active' : '' }}"><a href="{{ route('manage_user')}}"><i class="fa fa-adjust"></i>Manage User</a>
            </li> -->
            <!-- <li class="{{ (request()->is('admin/create-admin')) ? 'active' : '' }}"><a href="{{ route('create_admin')}}"><i class="fa fa-plus"></i> Add New Admin</a> -->
            @if(Auth::user()->type == '1' && in_array('8', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('8', json_decode(Auth::user()->role->permission)))
            <li class="{{ (request()->is('admin/manage-admin')) ? 'active' : '' }}"><a href="{{ route('manage_admin')}}"><i class="fa fa-adjust"></i>Manage Admin</a>
            </li>
            @endif

            <!-- <li class="{{ (request()->is('admin/create-employee')) ? 'active' : '' }}"><a href="{{ route('create_employee')}}"><i class="fa fa-plus"></i> Add New Employee</a>
            </li> -->
            @if(Auth::user()->type == '1' && in_array('39', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('39', json_decode(Auth::user()->role->permission)))
            <li class="{{ (request()->is('admin/manage-employee')) ? 'active' : '' }}"><a href="{{ route('manage_employee')}}"><i class="fa fa-adjust"></i>Manage Employee</a>
            </li>
            @endif

            @if(Auth::user()->type == '1' && in_array('40', json_decode(Auth::user()->role->permission)) || Auth::user()->type == '0' && in_array('40', json_decode(Auth::user()->role->permission)))
            <li class="{{ (request()->is('admin/role*')) ? 'active' : '' }}"><a href="{{ route('admin.role')}}"><i class="fa fa-adjust"></i>Manage Role</a>
            </li>
            @endif
        </ul>
    </li>

    @if(
        (Auth::user()->type == '1' && (in_array('22', json_decode(Auth::user()->role->permission)) || in_array('34', json_decode(Auth::user()->role->permission)) || in_array('35', json_decode(Auth::user()->role->permission)))) ||
        (Auth::user()->type == '0' && (in_array('22', json_decode(Auth::user()->role->permission)) || in_array('34', json_decode(Auth::user()->role->permission)) || in_array('35', json_decode(Auth::user()->role->permission))))
    )
    <li class="treeview {{ request()->is('admin/payment-method') || request()->is('admin/switch-branch') || request()->is('admin/company-details') ? 'active' : '' }}">
        <a href="#">
            <i class="fa fa-cog"></i> <span>Settings</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            @if((Auth::user()->type == '1' || Auth::user()->type == '0') && in_array('22', json_decode(Auth::user()->role->permission)))
            <li class="{{ request()->is('admin/payment-method') ? 'active' : '' }} d-none">
                <a href="{{ route('view_payment_method') }}">
                    <i class="fa fa-users"></i> Payment Method
                </a>
            </li>
            @endif
            @if((Auth::user()->type == '1' || Auth::user()->type == '0') && in_array('34', json_decode(Auth::user()->role->permission)))
            <li class="{{ request()->is('admin/switch-branch') ? 'active' : '' }} d-none">
                <a href="{{ route('switch_branch') }}">
                    <i class="fa fa-users"></i> Switch Branch
                </a>
            </li>
            @endif
            @if((Auth::user()->type == '1' || Auth::user()->type == '0') && in_array('35', json_decode(Auth::user()->role->permission)))
            <li class="{{ request()->is('admin/company-details') ? 'active' : '' }}">
                <a href="{{ route('admin.companyDetail') }}">
                    <i class="fa fa-users"></i> Company Details
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif

</ul>