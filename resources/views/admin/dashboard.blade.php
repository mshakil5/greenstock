@extends('admin.layouts.master')

@section('content')
    @if((Auth::user()->type == '1' || Auth::user()->type == '0') && in_array('36', json_decode(Auth::user()->role->permission)))
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading"><i class="fa fa-navicon"></i> Todays Sales Amount</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
                                    
                                    <h5 class="btn btn-success btn-sm center-block px-2">Sales : {{
                                        \App\Models\Order::where('sales_status', '=', '1')
                                        ->where('orderdate', date('Y-m-d'))
                                        ->when(auth()->user()->role_id != 1, function ($query) {
                                            return $query->where('branch_id', auth()->user()->branch_id);
                                        })
                                        ->sum('net_total')
                                    }} </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading"><i class="fa fa-navicon"></i> Today Cash Sales Amount</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
                                    
                                    <h5 class="btn btn-success btn-sm center-block px-2"> {{
                                        \App\Models\Order::where('sales_status', '=', '1')
                                        ->where('orderdate', date('Y-m-d'))
                                        ->when(auth()->user()->role_id != 1, function ($query) {
                                            return $query->where('branch_id', auth()->user()->branch_id);
                                        })
                                        ->sum('net_total') 
                                        -
                                        \App\Models\Order::where('sales_status', '=', '1')
                                        ->where('orderdate', date('Y-m-d'))
                                        ->when(auth()->user()->role_id != 1, function ($query) {
                                            return $query->where('branch_id', auth()->user()->branch_id);
                                        })
                                        ->sum('due')
                                    }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading"><i class="fa fa-navicon"></i> Today Credit Sales Amount</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
                                    
                                    <h5 class="btn btn-success btn-sm center-block px-2"> {{
                                        \App\Models\Order::where('sales_status', '=', '1')
                                        ->where('orderdate', date('Y-m-d'))
                                        ->when(auth()->user()->role_id != 1, function ($query) {
                                            return $query->where('branch_id', auth()->user()->branch_id);
                                        })
                                        ->sum('due')
                                    }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading"><i class="fa fa-navicon"></i> Total Product</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
                                    
                                    <h5 class="btn btn-success btn-sm center-block px-2"> {{
                                        \App\Models\Product::when(auth()->user()->role_id != 1, function ($query) {
                                            return $query->where('branch_id', auth()->user()->branch_id);
                                        })->count()
                                    }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading"><i class="fa fa-navicon"></i> Todays Quotation Create</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
                                    
                                    <h5 class="btn btn-success btn-sm center-block px-2"> {{
                                        \App\Models\Order::where('quotation', '=', '1')
                                        ->where('orderdate', date('Y-m-d'))
                                        ->when(auth()->user()->role_id != 1, function ($query) {
                                            return $query->where('branch_id', auth()->user()->branch_id);
                                        })
                                        ->count()
                                    }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading"><i class="fa fa-navicon"></i> Todays Delivery Note Create</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
                                    
                                    <h5 class="btn btn-success btn-sm center-block px-2"> {{
                                        \App\Models\Order::where('delivery_note', '=', '1')
                                        ->where('orderdate', date('Y-m-d'))
                                        ->when(auth()->user()->role_id != 1, function ($query) {
                                            return $query->where('branch_id', auth()->user()->branch_id);
                                        })
                                        ->count()
                                    }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading"><i class="fa fa-navicon"></i> Today Purchase Amount</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
                                    
                                    <h5 class="btn btn-success btn-sm center-block px-2"> {{
                                        \App\Models\Purchase::where('date', date('Y-m-d'))
                                        ->when(auth()->user()->role_id != 1, function ($query) {
                                            return $query->where('branch_id', auth()->user()->branch_id);
                                        })
                                        ->sum('net_amount')
                                    }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading"><i class="fa fa-navicon"></i> Total Supplier</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
                                    <h5 class="btn btn-success btn-sm center-block px-2">
                                        {{ 
                                            \App\Models\Vendor::when(auth()->user()->role_id != 1, function ($query) {
                                                return $query->where('branch_id', auth()->user()->branch_id);
                                            })->count() 
                                        }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading"><i class="fa fa-money"></i> Today's Expense</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
                                    <h5 class="btn btn-success btn-sm center-block px-2">
                                      {{
                                            \App\Models\Transaction::where('table_type', 'Expenses')
                                            ->whereDate('created_at', \Carbon\Carbon::today())
                                            ->when(auth()->user()->role_id != 1, function ($query) {
                                                return $query->where('branch_id', auth()->user()->branch_id);
                                            })
                                            ->sum('at_amount')
                                        }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading"><i class="fa fa-money"></i> Today's Income</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
                                    <h5 class="btn btn-success btn-sm center-block px-2">
                                        {{
                                            \App\Models\Transaction::where('table_type', 'Income')
                                            ->whereDate('created_at', \Carbon\Carbon::today())
                                            ->when(auth()->user()->role_id != 1, function ($query) {
                                                return $query->where('branch_id', auth()->user()->branch_id);
                                            })
                                            ->sum('at_amount')
                                        }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading"><i class="fa fa-balance-scale"></i> Today's Liability</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
                                    <h5 class="btn btn-success btn-sm center-block px-2">
                                        {{
                                            \App\Models\Transaction::where('table_type', 'Liabilities')
                                            ->whereDate('created_at', \Carbon\Carbon::today())
                                            ->when(auth()->user()->role_id != 1, function ($query) {
                                                return $query->where('branch_id', auth()->user()->branch_id);
                                            })
                                            ->sum('at_amount')
                                        }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading"><i class="fa fa-users"></i> Total Customers</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
                                    <h5 class="btn btn-success btn-sm center-block px-2">
                                        {{
                                            \App\Models\Customer::when(auth()->user()->role_id != 1, function ($query) {
                                                return $query->where('branch_id', auth()->user()->branch_id);
                                            })
                                            ->count()
                                        }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    @endif
    @if ((Auth::user()->type == '1' || Auth::user()->type == '0') && in_array('36', json_decode(Auth::user()->role->permission)))
    @php
        $processingServiceRequest = \App\Models\ServiceRequest::where('status', 1)->get();
        $pendingServiceRequest = \App\Models\ServiceRequest::where('status', 0)->get();
    @endphp
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading"><i class="fa fa-users"></i>Pending Service Request</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="" class="table table-hover table-responsive " width="100%">
                                    <thead>
                                        <tr>
                                            <th>Invoice No</th>
                                            <th>Bill No</th>
                                            <th>Date</th>
                                            <th><i class=""></i> Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pendingServiceRequest as $item)
                                        <tr>
                                            <td>{{$item->invoice_no}}</td>
                                            <td>{{$item->bill_no}}</td>
                                            <td>{{$item->date}}</td>
                                            <td>
                                                {{-- <div class="table-actions"><a href="{{route('admin.processingService', $item->id)}}" class="btn btn-sm btn-primary"><span title="Return"><i class="fa fa-eye"></i>View</span></a></div> --}}

                                                <div class="table-actions"><a href="{{route('admin.serviceSales.edit', $item->id)}}" class="btn btn-sm btn-primary"><span title="Return"><i class="fa fa-eye"></i>View</span></a></div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading"><i class="fa fa-users"></i>Processing Service Request</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="" class="table table-hover table-responsive " width="100%">
                                    <thead>
                                        <tr>
                                            <th>Invoice No</th>
                                            <th>Bill No</th>
                                            <th>Date</th>
                                            <th><i class=""></i> Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($processingServiceRequest as $item)
                                        <tr>
                                            <td>{{$item->invoice_no}}</td>
                                            <td>{{$item->bill_no}}</td>
                                            <td>{{$item->date}}</td>
                                            <td>
                                                {{-- <div class="table-actions"><a href="{{route('admin.processingService', $item->id)}}" class="btn btn-sm btn-primary"><span title="Return"><i class="fa fa-eye"></i>View</span></a></div> --}}

                                                <div class="table-actions"><a href="{{route('admin.serviceSales.edit', $item->id)}}" class="btn btn-sm btn-primary"><span title="Return"><i class="fa fa-eye"></i>View</span></a></div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
