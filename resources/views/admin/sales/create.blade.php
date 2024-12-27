@extends('admin.layouts.master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!-- Summernote CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
<!-- Summernote JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>

<div class="row ">
    <div class="container-fluid">

        <form id="salesForm">

            <div class="col-md-12">
                <div class="box box-default box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Sales</h3>
                    </div>
                    <div class="ermsg responsemsg"></div>
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
                                <label for="date">Invoice Date *</label>
                                <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d') }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="invoiceno">Invoice No *</label>
                                <input type="text" class="form-control" id="invoiceno" name="invoiceno" value="{{ $invoiceNo }}" readonly>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="date">Payment Type *</label>
                                <select name="salestype" id="salestype" class="form-control">
                                    <option value="Cash">Cash</option>
                                    <option value="Bank">Bank</option>
                                    <option value="Credit">Credit</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="customer_id">Customer *</label>
                                <select name="customer_id" id="customer_id" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach (\App\Models\Customer::where('branch_id', Auth::user()->branch_id)->where('status','1')->get() as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}-{{ $customer->phone }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-1">
                                <label for=""> New</label>
                                <a class="btn btn-primary btn-sm btn-return" data-toggle="modal" data-target="#newCustomerModal">
                                    <i class='fa fa-plus'></i> Add
                                </a>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="product">Product *</label>
                                <select name="product" id="product" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach (\App\Models\Product::select('id','productname','part_no')->where('branch_id', Auth::user()->branch_id)->get() as $product)
                                    <option value="{{ $product->id }}">{{ $product->productname }}-{{ $product->part_no }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- <div class="form-group col-md-4">
                                <label for="ref">Ref</label>
                                <input type="text" class="form-control" id="ref" name="ref">
                            </div> --}}

                            <div class="form-group col-md-6">
                                <label for="service">Select Package</label>
                                <select name="service" id="service" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach (\App\Models\Service::select('id','name','code')->get() as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                    </div>


                </div>

                <div class="box box-default box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Product List</h3>
                    </div>

                    <table class="table table-hover" id="protable">
                        <thead>
                            <tr>
                                <th class="text-center">Product Name</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Capacity</th>
                                <th class="text-center">Origin</th>
                                <th class="text-center">Power</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Unit Price</th>
                                <th class="text-center">Total Price</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody id="inner">
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-8">
                
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

                        <tbody id="serviceinner">
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
                                <input type="text" class="form-control" id="subject" name="subject">
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
            <div class="col-md-4">
                <div class="box box-widget widget-user-2">
                    <div class="widget-user-header">
                        <h3 class="widget-user-username"></h3>
                    </div>
                    <div class="box-body">

                        <div class="form-group row">
                            <label for="grand_total" class="col-sm-6 col-form-label">Item Total Amount</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="grand_total" name="grand_total" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="discount" class="col-sm-6 col-form-label">Discount</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="discount" name="discount">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="vat_percent" class="col-sm-6 col-form-label">Vat Percent</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="vat_percent" name="vat_percent" min="0">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="total_vat_amount" class="col-sm-6 col-form-label">Vat Amount</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="total_vat_amount" name="total_vat_amount" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="net_amount" class="col-sm-6 col-form-label">Net Amount</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="net_amount" name="net_amount" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="paid_amount" class="col-sm-6 col-form-label">Received Amount</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="paid_amount" name="paid_amount">
                            </div>
                        </div>

                        {{-- <div class="form-group row">
                            <label for="due_amount" class="col-sm-6 col-form-label">Due Amount</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="due_amount" name="due_amount" min="0" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="due_amount" class="col-sm-6 col-form-label">Return Amount</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="return_amount" name="return_amount" min="0" readonly>
                            </div>
                        </div> --}}

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <div class="responsemsg"></div>
                                {{-- <input class="form-check-input" type="checkbox" value="1" id="partnoshow" checked>
                                <label class="form-check-label" for="partnoshow">
                                    Show Part Number in PDF.
                                </label> --}}
                                {{-- <div class="button-container" style="display: flex; justify-content: center; gap: 10px; margin-top: 10px;">
                                    <button class="btn btn-success btn-md btn-submit" id="quotationBtn" type="submit">
                                        <i class="fa fa-plus-circle"></i> Quotation
                                    </button>
                                    <button class="btn btn-success btn-md btn-submit" id="deliveryBtn" type="submit">
                                        <i class="fa fa-plus-circle"></i> Delivery Note
                                    </button>
                                </div> --}}
                                <div class="button-container" style="display: flex; justify-content: center; gap: 10px; margin-top: 10px;">
                                    <button class="btn btn-success btn-md btn-submit" id="salesBtn" type="submit">
                                        <i class="fa fa-plus-circle"></i> Sales
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

<div class="modal fade" id="newCustomerModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header alert alert-success" style="text-align: left;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">#Add New Customer</h4>
            </div>
            <div class="modal-body">
                <div class="customermsg"></div>
                <form class="form-custom" id="customer-form" method="POST" action="{{ route('admin.saveCustomer') }}">
                    @csrf
                    <div class="col-sm-12">
                        

                        <div class="form-group col-sm-6">
                            <div class="row">
                                <div class="col-sm-4 text-left">
                                    <label for="name">Name: *</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="" required style="width: 100%;">
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <div class="row">
                                <div class="col-sm-4 text-left">
                                    <label for="email">Email:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="email" name="email" class="form-control" id="email" placeholder="" style="width: 100%;" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <div class="row">
                                <div class="col-sm-4 text-left">
                                    <label for="phone">Phone:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="phone" class="form-control" id="phone" placeholder="" style="width: 100%;">
                                </div>
                            </div>
                        </div>


                        <div class="form-group col-sm-6">
                            <div class="row">
                                <div class="col-sm-4 text-left">
                                    <label for="address">Address:</label>
                                </div>
                                <div class="col-sm-8">
                                    <textarea class="form-control" id="address" rows="3" placeholder="" name="address" style="width: 100%;"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-sm save-btn"><i class="fa fa-save"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
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
    $(document).ready(function() {
        $('.select2').select2();
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
        
        var serviceItemTotalAmount = 0;
        var mainProductTotalAmount = 0;
        var discount = parseFloat($('#discount').val()) || 0;
        var vat_percent = parseFloat($('#vat_percent').val()) || 0;
        // var total_vat_amount = parseFloat($('#total_vat_amount').val()) || 0;

        $('#servicetable tbody tr').each(function() {
            var quantity = parseFloat($(this).find('input.quantity').val()) || 0;
            var unit_price = parseFloat($(this).find('input.unit-price').val()) || 0;
            var totalPrice = (quantity * unit_price).toFixed(2);
            $(this).find('input.servicetotal').val(totalPrice);
            var rateunittotal = parseFloat($(this).find('input.servicetotal').val()) || 0;
            serviceItemTotalAmount += parseFloat(rateunittotal) || 0;
        });

        $('#protable tbody tr').each(function() {
            var apquantity = parseFloat($(this).find('input.quantity').val()) || 0;
            var apunit_price = parseFloat($(this).find('input.unit-price').val()) || 0;
            var apsellingprice = parseFloat($(this).find('input.total').val()) || 0;
            var addtotalPrice = (apquantity * apunit_price).toFixed(2);
            $(this).find('input.total').val(addtotalPrice);
            var mainProductTotalPrice = parseFloat($(this).find('input.total').val()) || 0;
            mainProductTotalAmount += parseFloat(mainProductTotalPrice) || 0;
            // console.log("amount:" + mainProductTotalAmount);
        });

        var grand_total = serviceItemTotalAmount + mainProductTotalAmount;
        var total_vat = (serviceItemTotalAmount * vat_percent) / 100;
        var net_amount = mainProductTotalAmount + serviceItemTotalAmount + total_vat - discount;
        $('#grand_total').val(grand_total.toFixed(2));
        $('#total_vat_amount').val(total_vat.toFixed(2));
        $('#mainProduct').val(mainProductTotalAmount.toFixed(2));
        $('#net_amount').val(net_amount.toFixed(2));

    }



    $(document).ready(function() {


        // header for csrf-token is must in laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // 

        var urlbr = "{{URL::to('/admin/getproduct')}}";
        $("#product").change(function() {
            event.preventDefault();
            var product = $(this).val();

            var product_id = $("input[name='product_id[]']")
                .map(function() {
                    return $(this).val();
                }).get();

            product_id.push(product);
            seen = product_id.filter((s => v => s.has(v) || !s.add(v))(new Set));

            if (Array.isArray(seen) && seen.length) {
                $(".ermsg").html("<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Duplicate product found..!</b></div>");
                return;
            }


            $.ajax({
                url: urlbr,
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
                                <input type="text" id="productname" name="productname[]" 
                                    value="${d.productname}" class="form-control" readonly>
                                <input type="hidden" id="product_id" name="product_id[]" 
                                    value="${d.product_id}" class="form-control ckproduct_id" readonly>
                            </td>

                            <td class="text-center">
                                <input type="text" id="type" name="type[]" class="form-control type">
                            </td>
                            <td class="text-center">
                                <input type="text" id="capacity" name="capacity[]" class="form-control capacity">
                            </td>
                            <td class="text-center">
                                <input type="text" id="origin" name="origin[]" class="form-control origin">
                            </td>
                            <td class="text-center">
                                <input type="text" id="power" name="power[]" class="form-control power">
                            </td>

                            <td class="text-center">
                                <input type="number" id="quantity" name="quantity[]" 
                                    value="1" min="1" class="form-control quantity">
                            </td>
                            <td class="text-center">
                                <input type="number" id="unit_price" name="unit_price[]" 
                                    value="${d.sellingprice}" class="form-control unit-price">
                            </td>
                            <td class="text-center">
                                <input type="text" id="total_amount" name="total_amount[]" 
                                    value="${d.sellingprice}" class="form-control total" readonly>
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
                        calculation();

                    }
                },
                error: function(d) {
                    console.log(d);
                }
            });

        });


        var serviceurlbr = "{{URL::to('/admin/getservice')}}";
        $("#service").change(function() {
            event.preventDefault();
            var service = $(this).val();


            var service_id = $("input[name='service_id[]']")
                .map(function() {
                    return $(this).val();
                }).get();

            service_id.push(service);
            seen = service_id.filter((s => v => s.has(v) || !s.add(v))(new Set));

            // console.log("servie: " + service, service_id);
            if (Array.isArray(seen) && seen.length) {
                $(".ermsg").html("<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Duplicate service found..!</b></div>");
                return;
            }


            $.ajax({
                url: serviceurlbr,
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
                                <input type="number" id="quantity" name="service_quantity[]" 
                                    value="1" min="1" class="form-control quantity">
                            </td>
                            <td class="text-center">
                                <input type="number" id="unit_price" name="service_unit_price[]" 
                                    value="${d.price}" class="form-control unit-price">
                            </td>
                            <td class="text-center">
                                <input type="text" id="total_amount" name="service_total_amount[]" 
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

                        $("table #serviceinner ").append(markup);
                        $("table #productinner").append(d.serviceDtl);
                        calculation();

                    }
                },
                error: function(d) {
                    console.log(d);
                }
            });

        });



        $(document).on('input', '#protable input.quantity, #protable input.unit-price, #protable input.total', function() {
            calculation();
        });


        $(document).on('input', '#servicetable input.quantity, #servicetable input.unit-price, #servicetable input.servicetotal', function() {
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

            var formData = new FormData($('#salesForm')[0]);

            $.ajax({
                url: '{{ route("admin.sales.store") }}',
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
                        $(".responsemsg").html(response.message);
                    } else {
                        // console.log(response);
                        $(".responsemsg").html(response.message);
                        window.setTimeout(function(){location.reload()},2000)
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

            // var data = {
            //     invoiceno: $("#invoiceno").val(),
            //     date: $("#date").val(),
            //     customer_id: $("#customer_id").val(),
            //     ref: $("#ref").val(),
            //     salestype: $("#salestype").val(),
            //     grand_total: $("#grand_total").val(),
            //     discount: $("#discount").val(),
            //     vat_percent: $("#vat_percent").val(),
            //     total_vat_amount: $("#total_vat_amount").val(),
            //     net_amount: $("#net_amount").val(),
            //     paid_amount: $("#paid_amount").val(),
            //     due_amount: $("#due_amount").val(),
            //     partnoshow: $("#partnoshow").val(),
            //     return_amount: $("#return_amount").val(),
            //     product_id: $("input[name='product_id[]']").map(function() {
            //         return $(this).val();
            //     }).get(),
            //     quantity: $("input[name='quantity[]']").map(function() {
            //         return $(this).val();
            //     }).get(),
            //     unit_price: $("input[name='unit_price[]']").map(function() {
            //         return $(this).val();
            //     }).get()
            // };
            // $.ajax({
            //     url: salesStoreurl,
            //     method: "POST",
            //     data: data,

            //     success: function(d) {
            //         $("#loader").removeClass('fa fa-spinner fa-spin');
            //         $(".btn-submit").removeAttr("disabled", true);
            //         if (d.status == 303) {
            //             $(".ermsg").html(d.message);
            //             pagetop();
            //         } else if (d.status == 300) {
            //             $(".ermsg").html(d.message);
            //             pagetop();
            //             window.setTimeout(function() {
            //                 location.reload()
            //             }, 2000)

            //         }
            //     },
            //     error: function(xhr, status, error) {
            //         $("#loader").removeClass('fa fa-spinner fa-spin');
            //         $(".btn-submit").removeAttr("disabled", true);
            //         console.error(xhr.responseText);
            //     }
            // });

        });
        // submit to sales end


    });
</script>

 {{-- customer add  --}}
<script>
    $(document).on('click', '.save-btn', function(event) {
        event.preventDefault();

        var name = $('#name').val().trim();

        if (name === '') {
            alert("Name field is required.");
            return;
        }
        // console.log('clicked');

        var form = $('#customer-form');
        var actionUrl = form.attr('action');
        var formData = form.serialize();

        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    var newOption = new Option(response.customer.name, response.customer.id, true, true);
                    $('#customer_id').append(newOption).trigger('change');

                    $('#newCustomerModal').modal('hide');

                    alert('Customer added successfully!');
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
</script>

@endsection