@extends('admin.layouts.master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!-- Summernote CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
<!-- Summernote JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>

<div class="row ">
    <div class="container-fluid">

        <form id="serviceRequestForm">

            <div class="col-md-9">
                <div class="box box-default box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Services</h3>
                    </div>
                    <div class="ermsg"></div>
                    <div>
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                        {{ Session::forget('success') }}
                        @endif
                        @if (Session::has('warning'))
                        <div class="alert alert-warning">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('warning') }}</p>
                        </div>
                        {{ Session::forget('warning') }}
                        @endif
                    </div>

                    <div class="box-body ir-table">

                            <div class="form-row">

                                <div class="form-group col-md-2">
                                    <label for="date">Date *</label>
                                    <p>{{$data->date}}</p>
                                    <input type="hidden" name="serviceRequestID" value="{{$data->id}}">
                                    <input type="hidden" name="orderId" value="{{$data->order->id ?? ''}}">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Bill Number</label>
                                    <p>{{$data->bill_no}}</p>
                                    
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="invoiceno">Our Invoice Number</label>
                                    <p>{{$data->invoice_no}}</p>
                                    
                                </div>

                                {{-- <div class="form-group col-md-4">
                                    <label for="date">Payment Type *</label>
                                    <select name="salestype" id="salestype" class="form-control">
                                        <option value="Cash">Cash</option>
                                        <option value="Bank">Bank</option>
                                        <option value="Credit">Credit</option>
                                    </select>
                                </div> --}}


                                <div class="form-group col-md-1">
                                    <label for=""> Document</label>
                                    <a class="btn btn-primary btn-sm btn-return" data-toggle="modal" data-target="#newCustomerModal">
                                        <i class='fa fa-plus'></i> View
                                    </a>
                                </div>

                                <div class="form-group col-md-12">
                                </div>

                                
                                <div class="form-group col-md-3">
                                    <label for="">Customer Name</label>
                                    <p>{{$data->customer_name}}</p>
                                </div>

                                
                                
                                <div class="form-group col-md-3">
                                    <label for="">Customer Phone</label>
                                    <p>{{$data->customer_phone}}</p>
                                </div>

                                
                                
                                <div class="form-group col-md-3">
                                    <label for="">Address</label>
                                    <p>{{$data->address}}</p>
                                </div>

                                
                                
                                <div class="form-group col-md-3">
                                    <label for="">Warranty Status</label>
                                    <p>{{$data->warranty}}</p>
                                </div>

                                <div class="form-group col-md-12">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="">Work assign to Staff</label>
                                    <p>{{$data->user->name}}</p>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="">Company Name</label>
                                    <p>{{$data->company->name ?? ''}}</p>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="">Product Desc</label>
                                    <p>{{$data->product_desc}}</p>
                                </div>


                                <div class="form-group col-md-4">
                                    <label for="product_model">Product Model</label>
                                    <input type="text" class="form-control" id="product_model" name="product_model" value="{{$data->product_model}}">
                                </div>
    
                                <div class="form-group col-md-4">
                                    <label for="product_serial">Product Serial</label>
                                    <input type="text" class="form-control" id="product_serial" name="product_serial" value="{{$data->product_serial}}">
                                </div>
    
                                <div class="form-group col-md-4">
                                    <label for="product_capacity">Product Capacity</label>
                                    <input type="text" class="form-control" id="product_capacity" name="product_capacity" value="{{$data->product_capacity}}">
                                </div>
    


                                <div class="form-group col-md-6">
                                    <label for="service">Select Package*</label>
                                    <select name="service" id="service" class="form-control select2">
                                        <option value="">Select</option>
                                        @foreach (\App\Models\Service::select('id','name','code')->get() as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                </div>



                                <div class="form-group col-md-6">
                                    <label for="product">Additional Product</label>
                                    <select name="product" id="product" class="form-control select2">
                                        <option value="">Select</option>
                                        @foreach (\App\Models\Product::select('id','productname')->get() as $product)
                                        <option value="{{ $product->id }}">{{ $product->productname }}</option>
                                        @endforeach
                                    </select>

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
                                    <p class="MsoNormal" style="margin-bottom: 0.0001pt;"><b>N.B:<o:p></o:p></b></p><p class="MsoNormal" style="margin-bottom: 0.0001pt;">1.&nbsp; This billing amount Excluded of VAT &amp; TAX.<b><o:p></o:p></b></p><p class="MsoNormal" style="margin-bottom: 0.0001pt;">2.&nbsp; Payment will be made in favor of&nbsp;<b>“Green Technology”.<o:p></o:p></b></p><p class="MsoNormal" style="margin-bottom: 0.0001pt;"><b>&nbsp;</b></p><p class="MsoNormal" style="margin-bottom: 0.0001pt;"><b><u>Warranty:</u></b><u><o:p></o:p></u></p><p class="MsoNormal" style="margin-bottom: 0.0001pt;">01.<u>&nbsp;Service Warranty -3 years.<o:p></o:p></u></p><p class="MsoNormal" style="margin-bottom: 0.0001pt;">02.<u>&nbsp;Compressor Warranty – 5 years.</u></p><p class="MsoNormal" style="margin-bottom: 0.0001pt;">03.&nbsp;<u>Spare Parts Warranty -2 year.</u></p>
                                
                                </textarea>
                            </div>


                        </div>

                    </div>

                    
                </div>

            </div>

            <div class="col-md-3">
                <div class="box box-widget widget-user-2">
                    <div class="widget-user-header">
                        <h3 class="widget-user-username"></h3>
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

                        <div class="form-group row">
                            <div class="col-sm-12">

                                <input class="form-check-input" type="checkbox" value="1" id="reduceQty" checked name="reduceQty">
                                <label class="form-check-label" for="reduceQty">
                                    Reduce from stock
                                </label>
                                
                                <div class="ermsg"></div>

                                <div class="button-container" style="display: flex; justify-content: center; gap: 10px; margin-top: 10px;">
                                    {{-- <button class="btn btn-success btn-md btn-submit" id="quotationBtn" type="submit">
                                        <i class="fa fa-plus-circle"></i> Quotation
                                    </button> --}}
                                    {{-- <button class="btn btn-success btn-md btn-submit" id="deliveryBtn" type="submit">
                                        <i class="fa fa-plus-circle"></i> Delivery Note
                                    </button> --}}
                                    <button class="btn btn-success btn-md btn-submit" id="salesBtn" type="submit">
                                        <i class="fa fa-plus-circle"></i> Submit
                                    </button>
                                </div>
                                <div class="button-container" style="display: flex; justify-content: center; gap: 10px; margin-top: 10px;">
                                    
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>
</div>

<div class="modal fade" id="newCustomerModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header alert alert-success" style="text-align: left;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Document</h4>
            </div>
            <div class="modal-body">
                <div class="row p-3">
                </div>

                <div class="form-group row">
                    <div class="col-sm-12">
                        <div class="button-container" style="display: flex; justify-content: center; gap: 10px; margin-top: 10px;">
                            <img src="{{asset('images/document/'. $data->document)}}" width="450px" alt="">
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

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

                        // console.log(d);

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
        
        $("body").delegate("#salesBtn", "click", function(event) {
            event.preventDefault();

            $(this).find('.fa-spinner').remove();
            $(this).prepend('<i class="fa fa-spinner fa-spin"></i>');
            $(this).attr("disabled", 'disabled');

            var formData = new FormData($('#serviceRequestForm')[0]);

            // console.log(formData);

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

                    console.log(response);
                    if (status == 400) {
                        $(".ermsg").html(response.message);
                    } else {
                        $(".ermsg").html(response.message);
                        setTimeout(function() {
                            window.location.href = "{{ route('admin.home') }}";
                        }, 2000);
                    }

                    
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseJSON.message);
                    // console.error(xhr.responseText);
                },
                complete: function() {
                    $('#loader').hide();
                    $('#addBtn').attr('disabled', false);
                }
            });

        });
        // submit to sales end

        // submit to quotation 
        var quotationStoreurl = "{{URL::to('/admin/quotation-store')}}";

        $("body").delegate("#quotationBtn", "click", function(event) {
            event.preventDefault();

            $(this).find('.fa-spinner').remove();
            $(this).prepend('<i class="fa fa-spinner fa-spin"></i>');
            $(this).attr("disabled", 'disabled');

            var data = {
                invoiceno: $("#invoiceno").val(),
                date: $("#date").val(),
                customer_id: $("#customer_id").val(),
                ref: $("#ref").val(),
                salestype: $("#salestype").val(),
                grand_total: $("#grand_total").val(),
                discount: $("#discount").val(),
                vat_percent: $("#vat_percent").val(),
                total_vat_amount: $("#total_vat_amount").val(),
                net_amount: $("#net_amount").val(),
                paid_amount: $("#paid_amount").val(),
                due_amount: $("#due_amount").val(),
                return_amount: $("#return_amount").val(),
                service_id: $("input[name='service_id[]']").map(function() {
                    return $(this).val();
                }).get(),
                quantity: $("input[name='quantity[]']").map(function() {
                    return $(this).val();
                }).get(),
                unit_price: $("input[name='unit_price[]']").map(function() {
                    return $(this).val();
                }).get()
            };

            // console.log(data);


            $.ajax({
                url: quotationStoreurl,
                method: "POST",
                data: data,

                success: function(d) {
                    $("#loader").removeClass('fa fa-spinner fa-spin');
                    $(".btn-submit").removeAttr("disabled", true);
                    if (d.status == 303) {
                        $(".ermsg").html(d.message);
                        pagetop();
                    } else if (d.status == 300) {
                        $(".ermsg").html(d.message);
                        pagetop();
                        window.setTimeout(function() {
                            location.reload()
                        }, 2000)

                    }
                },
                error: function(xhr, status, error) {
                    $("#loader").removeClass('fa fa-spinner fa-spin');
                    $(".btn-submit").removeAttr("disabled", true);
                    console.error(xhr.responseText);
                }
            });

        });
        // submit to quotation end



    
      
    });
</script>



@endsection