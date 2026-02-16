@extends('admin.layouts.master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!-- Summernote CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
<!-- Summernote JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
<style>
@media print {
    /* 1. Hide everything except the printable area */
    body * { visibility: hidden; }
    #printableArea, #printableArea * { visibility: visible; }
    #printableArea { 
        position: absolute; 
        left: 0; 
        top: 0; 
        width: 100%;
    }

    /* 2. Hide UI elements like "X" buttons and dropdown arrows */
    .no-print, 
    [onclick^="removeRow"], 
    .btn-group, 
    .fa-wrench { 
        display: none !important; 
    }

    /* 3. Force Bootstrap columns to maintain width on paper */
    .col-md-3 { width: 25% !important; float: left !important; }
    .col-md-4 { width: 33.33% !important; float: left !important; }
    .col-md-6 { width: 50% !important; float: left !important; }
    .row { display: block !important; clear: both !important; }

    /* 4. Fix form inputs so they look like text, not boxes */
    .form-control {
        border: none !important;
        box-shadow: none !important;
        background: transparent !important;
        padding: 0 !important;
        height: auto !important;
    }
    
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* 5. Force background colors and borders to show */
    .box-primary { border-top: 3px solid #3c8dbc !important; }
    .well, .row[style*="background-color"] {
        background-color: #fcfcfc !important;
        border: 1px solid #eee !important;
        -webkit-print-color-adjust: exact;
    }
    
    table { width: 100% !important; border-collapse: collapse; }
    th, td { border: 1px solid #ddd !important; padding: 8px !important; }
}
</style>


<div class="row ">
    <div class="container-fluid">

        <form id="serviceRequestForm">

            <div class="col-md-9">
                <div class="box box-primary box-solid" id="printableArea" style="border-radius: 4px; box-shadow: 0 2px 10px rgba(0,0,0,.1);">
                    <div class="box-header with-border" style="padding: 12px 15px; display: flex; justify-content: space-between; align-items: center;">
                        <h3 class="box-title" style="font-weight: 600; font-size: 18px; margin: 0;">
                            <i class="fa fa-wrench" style="margin-right: 8px;"></i>Service Request Management
                        </h3>

                        <div class="no-print" style="margin: 0;">
                            <button onclick="window.print();" class="btn btn-primary">
                                <i class="fa fa-print"></i> Print Service Request
                            </button>
                        </div>
                    </div>

                    <div class="box-body" style="padding-bottom: 0;">
                        @foreach (['success', 'warning', 'danger'] as $msg)
                            @if (Session::has($msg))
                                <div class="alert alert-{{ $msg }} alert-dismissible" style="margin-bottom: 15px; border-radius: 3px;">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <strong><i class="fa {{ $msg == 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle' }}"></i></strong> 
                                    {{ Session::get($msg) }}
                                    {{ Session::forget($msg) }}
                                </div>
                            @endif
                        @endforeach
                        <div class="ermsg"></div>
                    </div>

                    <div class="box-body">
                        <div class="row" style="background-color: #fcfcfc; border: 1px solid #eee; margin: 0 0 25px 0; padding: 15px 5px; border-radius: 4px;">
                            <div class="col-md-3">
                                <label style="color: #777; text-transform: uppercase; font-size: 11px; display: block; margin-bottom: 5px;">Request Date</label>
                                <span style="font-size: 16px; font-weight: bold; color: #333;">{{$data->date}}</span>
                                <input type="hidden" name="serviceRequestID" value="{{$data->id}}">
                                <input type="hidden" name="orderId" value="{{$data->order->id ?? ''}}">
                            </div>
                            <div class="col-md-3">
                                <label style="color: #777; text-transform: uppercase; font-size: 11px; display: block; margin-bottom: 5px;">Our Invoice #</label>
                                <span style="font-size: 16px; color: #333;">{{$data->invoice_no}}</span>
                            </div>
                            <div class="col-md-3">
                                <label for="bill_no" style="font-size: 12px;">Customer Bill Number</label>
                                <input type="text" class="form-control input-sm" id="bill_no" name="bill_no" value="{{$data->bill_no}}" style="border-radius: 2px;">
                            </div>
                            <div class="col-md-3 text-right">
                                <label style="display: block; visibility: hidden;">Actions</label>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#newCustomerModal" style="border-radius: 2px 0 0 2px;">
                                        <i class="fa fa-file-text-o"></i> View Doc
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#newProductModal" style="border-radius: 0 2px 2px 0;">
                                        <i class="fa fa-barcode"></i> Product
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6" style="border-right: 1px solid #f4f4f4;">
                                <h4 style="border-bottom: 2px solid #3c8dbc; display: inline-block; padding-bottom: 5px; margin-bottom: 20px; font-size: 16px; font-weight: 600;">
                                    Customer Details
                                </h4>
                                
                                <div class="form-group">
                                    <label style="font-size: 13px;">Full Name</label>
                                    <input type="text" class="form-control" name="customer_name" value="{{ $data->customer_name }}">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label style="font-size: 13px;">Phone Number</label>
                                            <input type="text" class="form-control" name="customer_phone" value="{{ $data->customer_phone }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label style="font-size: 13px;">Warranty Status</label>
                                            <select name="warranty" id="warranty" class="form-control">
                                                <option value="">Please Select</option>
                                                @foreach(['Full Warranty', 'Service Only', 'Parts Only', 'Out of Warranty', 'Compressor Warranty'] as $status)
                                                    <option value="{{ $status }}" {{ $data->warranty == $status ? 'selected' : '' }}>{{ $status }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="font-size: 13px;">Address</label>
                                    <textarea class="form-control" name="address" rows="3" style="resize: vertical;">{{ $data->address }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h4 style="border-bottom: 2px solid #3c8dbc; display: inline-block; padding-bottom: 5px; margin-bottom: 20px; font-size: 16px; font-weight: 600;">
                                    Technical Info
                                </h4>

                                <div class="row" style="margin-bottom: 15px;">
                                    <div class="col-xs-6">
                                        <label style="color: #777; font-size: 12px; display: block;">Assigned Staff</label>
                                        <p style="font-weight: 600;"><i class="fa fa-user" style="color: #3c8dbc;"></i> {{$data->user->name}}</p>
                                    </div>
                                    <div class="col-xs-6">
                                        <label style="color: #777; font-size: 12px; display: block;">Company</label>
                                        <p>{{$data->company->name ?? 'N/A'}}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="font-size: 13px;">Product Description</label>
                                    <p class="well well-sm" style="background-color: #f9f9f9; margin-bottom: 10px; border-radius: 2px;">{{$data->product_desc}}</p>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="font-size: 12px;">Model</label>
                                            <input type="text" class="form-control input-sm" name="product_model" value="{{$data->product_model}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="font-size: 12px;">Serial</label>
                                            <input type="text" class="form-control input-sm" name="product_serial" value="{{$data->product_serial}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="font-size: 12px;">Capacity</label>
                                            <input type="text" class="form-control input-sm" name="product_capacity" value="{{$data->product_capacity}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 20px; padding-top: 20px; border-top: 1px dashed #ddd;">
                            <div class="col-md-6">
                                <div class="form-group" style="background: #eff7ff; padding: 15px; border-radius: 4px; border: 1px solid #d2e8ff;">
                                    <label for="service" style="color: #004a99;">Select Service Package *</label>
                                    <select name="service" id="service" class="form-control select2" style="width: 100%;">
                                        <option value="">Search for package...</option>
                                        @foreach (\App\Models\Service::select('id','name')->get() as $service)
                                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="padding: 15px;">
                                    <label for="product">Include Additional Product</label>
                                    <select name="product" id="product" class="form-control select2" style="width: 100%;">
                                        <option value="">Search for product...</option>
                                        @foreach (\App\Models\Product::select('id','productname')->get() as $product)
                                            <option value="{{ $product->id }}">{{ $product->productname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="box box-default box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Service Package List</h3>
                    </div>

                    <table class="table table-hover" id="servicetable">
                        <thead>
                            <tr>
                                <th class="text-center">Service Name</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Unit Price</th>
                                <th class="text-center">Total Price</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody id="inner">
                            @foreach ($data->order->orderdetails as $mainservice)
                            <tr>
                                <td class="text-center">
                                    <input type="text" id="servicename" name="servicename[]" 
                                        value="{{$mainservice->service->name}}" class="form-control" readonly>
                                    <input type="hidden" id="service_id" name="service_id[]" 
                                        value="{{$mainservice->service->id}}" class="form-control ckservice_id" readonly>

                                    <input type="hidden" id="order_detail_id" name="order_detail_id[]" 
                                        value="{{$mainservice->id}}" class="form-control" readonly>
                                </td>
                                <td class="text-center">
                                    <input type="number" id="quantity" name="quantity[]" 
                                        value="{{$mainservice->quantity}}" min="1" class="form-control quantity">
                                </td>
                                <td class="text-center">
                                    <input type="number" id="unit_price" name="unit_price[]" 
                                        value="{{$mainservice->sellingprice}}" class="form-control unit-price">
                                </td>
                                <td class="text-center">
                                    <input type="text" id="total_amount" name="total_amount[]" 
                                        value="{{$mainservice->total_amount}}" class="form-control servicetotal" readonly>
                                </td>
                                <td class="text-center">
                                    <div style="
                                        color: white; 
                                        user-select: none; 
                                        padding: 5px; 
                                        background: red; 
                                        width: 45px; 
                                        display: flex; 
                                        align-items: center; 
                                        margin-right: 5px; 
                                        justify-content: center; 
                                        border-radius: 4px;
                                        left: 4px;
                                        top: 81px;" 
                                        onclick="removeRow(event)">
                                        X
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>


                </div>
                <div class="box box-default box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Service Product List</h3>
                    </div>

                    <table class="table table-hover" id="serviceproductTable">
                        <thead>
                            <tr>
                                <th class="text-center">Product Name</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Available Stock</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody id="productinner">

                            @foreach ($data->serviceRequestProduct as $serviceRequestProduct)
                            <tr>
                                <td class="text-center">
                                    <input type="text" class="form-control" name="spproductname[]" value="{{$serviceRequestProduct->product->productname}}"><input type="hidden" class="form-control" name="spproduct_id[]" value="{{$serviceRequestProduct->product_id}}"><input type="hidden" class="form-control" name="servicedtlid[]" value="{{$serviceRequestProduct->service_id}}">
                                </td>
                                <td class="text-center">
                                     <input type="number" class="form-control" name="spquantity[]" value="{{$serviceRequestProduct->quantity}}">
                                </td>
                                <td class="text-center">
                                </td>
                                <td class="text-center">
                                    <div style="
                                        color: white; 
                                        user-select: none; 
                                        padding: 5px; 
                                        background: red; 
                                        width: 45px; 
                                        display: flex; 
                                        align-items: center; 
                                        margin-right: 5px; 
                                        justify-content: center; 
                                        border-radius: 4px;
                                        left: 4px;
                                        top: 81px;" 
                                        onclick="removeRow(event)">
                                        X
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                            

                        </tbody>
                    </table>
                </div>

                <div class="box box-default box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Additional Product List</h3>
                    </div>

                    <table class="table table-hover" id="adProductTable">
                        <thead>
                            <tr>
                                <th class="text-center">Product Name</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Purchase price per unit</th>
                                <th class="text-center">Total Purchase Price</th>
                                <th class="text-center">Selling Price</th>
                                <th class="text-center">Selling Price Total</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody id="additionalitem">

                            @foreach ($data->order->serviceAdditionalProduct as $serviceAdditionalProduct)
                            <tr>
                                <td class="text-center">
                                    <input type="text" id="name" name="additional_product_name[]" 
                                        value="{{$serviceAdditionalProduct->product->productname}}" class="form-control" readonly>
                                    <input type="hidden" id="product_id" name="approduct_id[]" 
                                        value="{{$serviceAdditionalProduct->product_id}}" class="form-control ckproduct_id" readonly>
                                </td>
                                <td class="text-center">
                                    <input type="number" id="quantity" name="apquantity[]" 
                                        value="{{$serviceAdditionalProduct->quantity}}" min="1" class="form-control apquantity">
                                </td>
                                <td class="text-center">
                                    <input type="number" id="unit_price" name="apunit_price[]" 
                                        value="{{$serviceAdditionalProduct->purchase_price_per_unit}}" class="form-control apunit-price">
                                </td>
                                <td class="text-center">
                                    <input type="number" id="total_amount" name="aptotal_amount[]" 
                                        value="{{$serviceAdditionalProduct->total_purchase_price}}" class="form-control aptotal" readonly>
                                </td>
                                
                                <td class="text-center">
                                    <input type="number" id="selling_price" name="apselling_price_unit[]" 
                                        value="{{$serviceAdditionalProduct->selling_price_per_unit}}" class="form-control apsellingprice" required>
                                </td>
    
                                <td class="text-center">
                                    <input type="number" id="selling_price" name="apselling_price[]" 
                                        value="{{$serviceAdditionalProduct->total_selling_price}}" class="form-control apsellingtotal" readonly>
                                </td>
    
                                <td class="text-center">
                                    <div style="
                                        color: white; 
                                        user-select: none; 
                                        padding: 5px; 
                                        background: red; 
                                        width: 45px; 
                                        display: flex; 
                                        align-items: center; 
                                        margin-right: 5px; 
                                        justify-content: center; 
                                        border-radius: 4px;
                                        left: 4px;
                                        top: 81px;" 
                                        onclick="removeRow(event)">
                                        X
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                            

                        </tbody>
                    </table>
                </div>

                <div class="box box-default box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Billing Description</h3>
                    </div>

                    <div class="box-body ir-table">
                        <div class="form-row">

                            <div class="form-group col-md-12">
                                <label for="subject">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject" value="{{$data->order->subject}}">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="bill_body">Body</label>
                                <textarea name="bill_body" id="bill_body" cols="30" rows="5" class="form-control">
                                    @if ($data->order->body)
                                        {!! $data->order->body !!} 
                                        
                                    @else
                                        <p class="MsoNormal" style="margin-bottom: 0.0001pt;"><b>N.B:<o:p></o:p></b></p><p class="MsoNormal" style="margin-bottom: 0.0001pt;">1.&nbsp; This billing amount Excluded of VAT &amp; TAX.<b><o:p></o:p></b></p><p class="MsoNormal" style="margin-bottom: 0.0001pt;">2.&nbsp; Payment will be made in favor of&nbsp;<b>“Green Technology”.<o:p></o:p></b></p><p class="MsoNormal" style="margin-bottom: 0.0001pt;"><b>&nbsp;</b></p><p class="MsoNormal" style="margin-bottom: 0.0001pt;"><b><u>Warranty:</u></b><u><o:p></o:p></u></p><p class="MsoNormal" style="margin-bottom: 0.0001pt;">01.<u>&nbsp;Service Warranty -3 years.<o:p></o:p></u></p><p class="MsoNormal" style="margin-bottom: 0.0001pt;">02.<u>&nbsp;Compressor Warranty – 5 years.</u></p><p class="MsoNormal" style="margin-bottom: 0.0001pt;">03.&nbsp;<u>Spare Parts Warranty -2 year.</u></p>
                                    @endif
                                    
                                
                                </textarea>
                            </div>


                        </div>

                    </div>

                    
                </div>

            </div>

            <div class="col-md-3">
                <div class="box box-widget widget-user-2">
                    <div class="widget-user-header">
                        <h3 class="widget-user-username">
                            <a href="{{ route('admin.orderproduct', $data->id) }}" class="btn btn-primary btn-md">
                                <i class="fa fa-product-hunt"></i> Order Product
                            </a>

                            <a href="{{ route('admin.assignStaff', $data->id) }}" class="btn btn-primary btn-md">
                                <i class="fa fa-product-hunt"></i> Staff
                            </a>

                        </h3>
                    </div>
                    <div class="box-body">

                        <div class="form-group row">
                            <label for="grand_total" class="col-sm-6 col-form-label">Item Total Amount</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="grand_total" name="grand_total" readonly value="{{$data->order->grand_total}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="discount" class="col-sm-6 col-form-label">Discount</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="discount" name="discount"  value="{{$data->order->discount}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="vat_percent" class="col-sm-6 col-form-label">Vat Percent</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="vat_percent" name="vat_percent" min="0" value="{{$data->order->vatpercentage}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="total_vat_amount" class="col-sm-6 col-form-label">Vat Amount</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="total_vat_amount" name="total_vat_amount" readonly value="{{$data->order->vatamount}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="additional_sales" class="col-sm-6 col-form-label">Additional Sales</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="additional_sales" name="additional_sales" readonly value="">
                            </div>
                        </div>

                        

                        
                        <div class="form-group row">
                            <label for="net_amount" class="col-sm-6 col-form-label">Net Amount</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="net_amount" name="net_amount" readonly value="{{$data->order->net_total}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="adv_amount" class="col-sm-6 col-form-label">Advance Received</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="adv_amount" name="adv_amount" value="{{$data->order->adv_amount}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cash_amount" class="col-sm-6 col-form-label">Cash Received Amount</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="cash_amount" name="cash_amount" value="{{$data->order->cash_amount}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bank_amount" class="col-sm-6 col-form-label">Bank Received Amount</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="bank_amount" name="bank_amount" value="{{$data->order->bank_amount}}">
                            </div>
                        </div>

                        <div class="form-group row d-none">
                            <label for="paid_amount" class="col-sm-6 col-form-label">Received Amount</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="paid_amount" name="paid_amount" value="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="due_amount" class="col-sm-6 col-form-label">Due Amount</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="due_amount" name="due_amount" min="0" readonly value="{{$data->order->due}}">
                            </div>
                        </div>

                        <div class="form-group row d-none">
                            <label for="due_amount" class="col-sm-6 col-form-label">Return Amount</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="return_amount" name="return_amount" min="0" readonly>
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <label for="due_amount" class="col-sm-6 col-form-label">Change Status</label>
                            <div class="col-sm-6">
                                <select name="service_status" id="service_status" class="form-control">
                                    <option value="">Select</option>
                                    <option value="0" {{ $data->status == '0' ? 'selected' : '' }}>Pending</option>
                                    <option value="1" {{ $data->status == '1' ? 'selected' : '' }}>Processing</option>
                                    <option value="4" {{ $data->status == '4' ? 'selected' : '' }}>Pre Completed</option>
                                    <option value="3" {{ $data->status == '3' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                        </div> --}}

                        <div class="form-group row">
                            <div class="col-sm-12">
                                {{-- <input class="form-check-input" type="checkbox" value="1" id="reduceQty" checked name="reduceQty">
                                <label class="form-check-label" for="reduceQty">
                                    Reduce from stock
                                </label> --}}
                                
                                <div class="ermsg"></div>
                                <div class="button-container" style="display: flex; justify-content: center; gap: 10px; margin-top: 10px;">

                                    @if ($data->status != '2')
                                        <button class="btn btn-success btn-md btn-submit" id="processBtn" type="submit" data-sts="1">
                                        <i class="fa fa-plus-circle"></i> Processing
                                        </button>

                                        <button class="btn btn-success btn-md btn-submit" id="pcomBtn" type="submit" data-sts="4">
                                            <i class="fa fa-plus-circle"></i> Pre-Complete
                                        </button>
                                    @endif
                                    
                                    
                                </div>
                                <div class="button-container" style="display: flex; justify-content: center; gap: 10px; margin-top: 10px;">

                                    
                                    <button type="button" class="btn btn-success btn-md " id="printBgBtn" data-sts="4">
                                        <span title="Print Invoice"><i class="fa fa-print"></i> Print BG</span>
                                    </button>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@include('admin.salesService.partials.modal')

@endsection

@section('script')



<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

<script>
    $(document).ready(function() {
        $('#bill_body').summernote({
            height: 200, // Set the height of the editor
            placeholder: 'Write something here...',
            toolbar: [
                // Customize your toolbar
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
<script>
    function removeRow(event) {
        event.target.parentElement.parentElement.remove();
        calculation();
    }
</script>

<script>


    function calculation() {
            
        var itemTotalAmount = 0;
        var addtionalitemPurchaseAmount = 0;
        var addtionalitemSellingAmount = 0;
        var discount = parseFloat($('#discount').val()) || 0;
        var vat_percent = parseFloat($('#vat_percent').val()) || 0;
        // var total_vat_amount = parseFloat($('#total_vat_amount').val()) || 0;

        $('#servicetable tbody tr').each(function() {
            var quantity = parseFloat($(this).find('input.quantity').val()) || 0;
            var unit_price = parseFloat($(this).find('input.unit-price').val()) || 0;
            var totalPrice = (quantity * unit_price).toFixed(2);
            $(this).find('input.servicetotal').val(totalPrice);
            var rateunittotal = parseFloat($(this).find('input.servicetotal').val()) || 0;
            itemTotalAmount += parseFloat(rateunittotal) || 0;
        });

        // console.log("itemTotalAmount:" + itemTotalAmount);

        $('#adProductTable tbody tr').each(function() {
            var apquantity = parseFloat($(this).find('input.apquantity').val()) || 0;
            var apunit_price = parseFloat($(this).find('input.apunit-price').val()) || 0;
            var apsellingprice = parseFloat($(this).find('input.apsellingprice').val()) || 0;
            var addtotalPrice = (apquantity * apunit_price).toFixed(2);
            var addsellingPrice = (apquantity * apsellingprice).toFixed(2);
            $(this).find('input.aptotal').val(addtotalPrice);
            $(this).find('input.apsellingtotal').val(addsellingPrice);
            var additionalPurchasePrice = parseFloat($(this).find('input.aptotalpPrice').val()) || 0;
            var additionalsalesPrice = parseFloat($(this).find('input.apsellingtotal').val()) || 0;
            addtionalitemPurchaseAmount += parseFloat(additionalPurchasePrice) || 0;
            addtionalitemSellingAmount += parseFloat(additionalsalesPrice) || 0;
            // console.log("addtionalamount:" + addsellingPrice);
        });

        var grand_total = itemTotalAmount;
        var total_vat = (itemTotalAmount * vat_percent) / 100;
        var net_amount = addtionalitemSellingAmount + itemTotalAmount + total_vat - discount;
        $('#grand_total').val(grand_total.toFixed(2));
        $('#total_vat_amount').val(total_vat.toFixed(2));
        $('#additional_sales').val(addtionalitemSellingAmount.toFixed(2));
        $('#net_amount').val(net_amount.toFixed(2));
        var bank_amount = parseFloat($("#bank_amount").val()) || 0;
        var cash_amount = parseFloat($("#cash_amount").val()) || 0;
        var adv_amount = parseFloat($("#adv_amount").val()) || 0;
        var net_amount = parseFloat($("#net_amount").val()) || 0;
        var due_amount = net_amount - (cash_amount + bank_amount + adv_amount);
        $("#due_amount").val(due_amount.toFixed(2));

    }


    $(document).ready(function() {


        // header for csrf-token is must in laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // 

        var urlbr = "{{URL::to('/admin/getservice')}}";
        $("#service").change(function() {
            event.preventDefault();
            var service = $(this).val();


            var service_id = $("input[name='service_id[]']")
                .map(function() {
                    return $(this).val();
                }).get();

            service_id.push(service);
            seen = service_id.filter((s => v => s.has(v) || !s.add(v))(new Set));

            
            if (Array.isArray(seen) && seen.length) {
                $(".ermsg").html("<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Duplicate service found..!</b></div>");
                return;
            }


            $.ajax({
                url: urlbr,
                method: "POST",
                data: {
                    service: service
                },

                success: function(d) {
                    if (d.status == 303) {

                    } else if (d.status == 300) {
                        var markup = `
                        <tr>
                            <td class="text-center">
                                <input type="text" id="servicename" name="servicename[]" 
                                    value="${d.name}" class="form-control" readonly>
                                <input type="hidden" id="service_id" name="service_id[]" 
                                    value="${d.service_id}" class="form-control ckservice_id" readonly>
                            </td>
                            <td class="text-center">
                                <input type="number" id="quantity" name="quantity[]" 
                                    value="1" min="1" class="form-control quantity">
                            </td>
                            <td class="text-center">
                                <input type="number" id="unit_price" name="unit_price[]" 
                                    value="${d.price}" class="form-control unit-price">
                            </td>
                            <td class="text-center">
                                <input type="text" id="total_amount" name="total_amount[]" 
                                    value="${d.price}" class="form-control servicetotal" readonly>
                            </td>
                            <td class="text-center">
                                <div style="
                                    color: white; 
                                    user-select: none; 
                                    padding: 5px; 
                                    background: red; 
                                    width: 45px; 
                                    display: flex; 
                                    align-items: center; 
                                    margin-right: 5px; 
                                    justify-content: center; 
                                    border-radius: 4px;
                                    left: 4px;
                                    top: 81px;" 
                                    onclick="removeRow(event)">
                                    X
                                </div>
                            </td>
                        </tr>`;

                        $("table #inner ").append(markup);
                        $("table #productinner").append(d.serviceDtl);
                        calculation();

                    }
                },
                error: function(d) {
                    console.log(d);
                }
            });

        });


        var apurl = "{{URL::to('/admin/getproduct')}}";
        $("#product").change(function() {
            event.preventDefault();
            var product = $(this).val();


            var product_id = $("input[name='product_id[]']")
                .map(function() {
                    return $(this).val();
                }).get();

                product_id.push(product);
            seen = product_id.filter((s => v => s.has(v) || !s.add(v))(new Set));

            // console.log("product: " + product, product_id);
            if (Array.isArray(seen) && seen.length) {
                $(".ermsg").html("<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Duplicate product found..!</b></div>");
                return;
            }


            $.ajax({
                url: apurl,
                method: "POST",
                data: {
                    product: product
                },

                success: function(d) {
                    if (d.status == 303) {

                    } else if (d.status == 300) {

                        // console.log(d);

                        var markup = `
                        <tr>
                            <td class="text-center">
                                <input type="text" id="name" name="additional_product_name[]" 
                                    value="${d.productname}" class="form-control" readonly>
                                <input type="hidden" id="product_id" name="approduct_id[]" 
                                    value="${d.product_id}" class="form-control ckproduct_id" readonly>
                            </td>
                            <td class="text-center">
                                <input type="number" id="quantity" name="apquantity[]" 
                                    value="1" min="1" class="form-control apquantity">
                            </td>
                            <td class="text-center">
                                <input type="number" id="unit_price" name="apunit_price[]" 
                                    value="${d.price}" class="form-control apunit-price">
                            </td>
                            <td class="text-center">
                                <input type="number" id="total_amount" name="aptotal_amount[]" 
                                    value="" class="form-control aptotal" readonly>
                            </td>
                            
                            <td class="text-center">
                                <input type="number" id="selling_price" name="apselling_price_unit[]" 
                                    value="" class="form-control apsellingprice" required>
                            </td>

                            <td class="text-center">
                                <input type="number" id="selling_price" name="apselling_price[]" 
                                    value="" class="form-control apsellingtotal" readonly>
                            </td>

                            <td class="text-center">
                                <div style="
                                    color: white; 
                                    user-select: none; 
                                    padding: 5px; 
                                    background: red; 
                                    width: 45px; 
                                    display: flex; 
                                    align-items: center; 
                                    margin-right: 5px; 
                                    justify-content: center; 
                                    border-radius: 4px;
                                    left: 4px;
                                    top: 81px;" 
                                    onclick="removeRow(event)">
                                    X
                                </div>
                            </td>
                        </tr>`;

                        $("table #additionalitem ").append(markup);
                        calculation();

                    }
                },
                error: function(d) {
                    console.log(d);
                }
            });

        });

        $(document).on('input', '#adProductTable input.apquantity, #adProductTable input.apunit-price, #adProductTable input.apsellingprice', function() {
            calculation();
        });

        $(document).on('input', '#servicetable input.quantity, #servicetable input.unit-price, #servicetable input.servicetotal', function() {
            calculation();
        });


        // cash_amount , bank_amount
        $("#cash_amount").on('keyup change input', function() {
            calculation();
        });

        $("#bank_amount").on('keyup change input', function() {
            calculation();
        });

        $("#adv_amount").on('keyup change input', function() {
            calculation();
        });


        // Listen for changes in the VAT percentage input
        $("#vat_percent").on('keyup change input', function() {
            calculation();
        });

        // Listen for changes in the VAT percentage input
        $("#discount").on('keyup change input', function() {
            calculation();
        });

        // submit to sales 
        
        $("body").on("click", "#salesBtn, #processBtn, #pcomBtn, #printBgBtn", function(event) {
            event.preventDefault();

            $(this).find('.fa-spinner').remove();
            $(this).prepend('<i class="fa fa-spinner fa-spin"></i>');
            $(this).attr("disabled", "disabled");

            var status = $(this).data('sts');
            var bill_body = $('#bill_body').summernote('code');

            var formData = new FormData($('#serviceRequestForm')[0]);
            formData.append('service_status', status);
            formData.append('bill_body', bill_body);

            $.ajax({
                url: '{{ route("admin.ServiceSales.update") }}',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {


                    if (response.status == 400) {
                        $(".ermsg").html(response.message);
                    } else {
                        if ($(this).attr('id') === 'printBgBtn') {
                            window.open("{{ route('customer.invoice.bgprint', $data->id) }}", '_blank');
                            $(".ermsg").html(response.message);
                        } else {
                            $(".ermsg").html(response.message);
                            setTimeout(function() {
                                window.location.href = "{{ route('admin.home') }}";
                            }, 2000);
                        }
                    }

                }.bind(this), // Bind `this` to maintain context
                error: function(xhr, status, error) {
                    console.log(xhr.responseJSON.message);
                },
                complete: function() {
                    $('#loader').hide();
                    $('#salesBtn, #processBtn, #pcomBtn, #printBgBtn').attr('disabled', false);
                }
            });
        });
        // submit to sales end
      
    });
</script>



@endsection