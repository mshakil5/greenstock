@extends('admin.layouts.master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />

<div class="row ">
    <div class="container-fluid">

        <div class="col-md-9">
            <div class="box box-default box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Sales</h3>
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

                    <form>

                        <div class="form-row">

                            <div class="form-group col-md-2">
                                <label for="date">Date *</label>
                                <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d') }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="invoiceno">Job Number</label>
                                <input type="number" class="form-control" id="invoiceno" name="invoiceno">
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
                                <label for="customer_id">Customer</label>
                                <select name="customer_id" id="customer_id" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach (\App\Models\Customer::where('branch_id', Auth::user()->branch_id)->where('status','1')->get() as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
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
                                <label for="service">Service*</label>
                                <select name="service" id="service" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach (\App\Models\Service::select('id','name','code')->get() as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="company_id">Company</label>
                                <select name="company_id" id="company_id" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach (\App\Models\Company::all() as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group col-md-6">
                                <label for="product">Product</label>
                                <select name="product" id="product" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach (\App\Models\Product::select('id','productname')->get() as $product)
                                    <option value="{{ $product->id }}">{{ $product->productname }}</option>
                                    @endforeach
                                </select>

                            </div>


                        </div>

                    </form>
                </div>


            </div>

            <div class="box box-default box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Service List</h3>
                </div>

                <table class="table table-hover" id="protable">
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
                    </tbody>
                </table>


            </div>


            <div class="box box-default box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Product List</h3>
                </div>

                <table class="table table-hover" id="productTable">
                    <thead>
                        <tr>
                            <th class="text-center">New</th>
                            <th class="text-center">Product Name</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Unit Purchase Price</th>
                            <th class="text-center">Unit Selling Price</th>
                            <th class="text-center">Total Price</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody id="productinner">
                    </tbody>
                </table>


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

                    <div class="form-group row">
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
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">

                            <input class="form-check-input" type="checkbox" value="1" id="partnoshow" checked>
                            <label class="form-check-label" for="partnoshow">
                                Reduce from stock
                            </label>

                            <div class="button-container" style="display: flex; justify-content: center; gap: 10px; margin-top: 10px;">
                                <button class="btn btn-success btn-md btn-submit" id="quotationBtn" type="submit">
                                    <i class="fa fa-plus-circle"></i> Quotation
                                </button>
                                <button class="btn btn-success btn-md btn-submit" id="deliveryBtn" type="submit">
                                    <i class="fa fa-plus-circle"></i> Delivery Note
                                </button>
                            </div>
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
                                    <label for="member_id">Member ID:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="member_id" name="member_id" placeholder="" style="width: 100%;" />
                                </div>
                            </div>
                        </div>

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
                                    <label for="vat_number">Vat Number:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="vat_number" class="form-control" id="vat_number" placeholder="" style="width: 100%;">
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

                        <div class="form-group col-sm-6">
                            <div class="row">
                                <div class="col-sm-4 text-left">
                                    <label for="vehicleno">Vehicle No:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="vehicleno" class="form-control" id="vehicleno" placeholder="" style="width: 100%;">
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <div class="row">
                                <div class="col-sm-4 text-left">
                                    <label for="type">Type:</label>
                                </div>
                                <div class="col-sm-8">
                                    <select class="form-control" name="type" style="width: 100%;">
                                        <option value="0">Customer</option>
                                        <option value="1">Distributor</option>
                                    </select>
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
        $('.select2').select2();
    });
</script>



<!-- <script>
    $(document).ready(function() {
        function calculateReturnAmount() {

            let paidAmount = parseFloat($('#paid_amount').val()) || 0;
            let netAmount = parseFloat($('#net_amount').val()) || 0;

            let returnAmount = (paidAmount > netAmount) ? -(paidAmount - netAmount) : 0;

            $('#return_amount').val(returnAmount);
        }

        $('#paid_amount').on('input', calculateReturnAmount);

        calculateReturnAmount();
    });
</script> -->

<script>
    function removeRow(event) {
        event.target.parentElement.parentElement.remove();
        net_total();
        net_total_vat();
    }

    function net_total() {
        var grand_total = 0;
        var total_with_vat = 0;
        var discount = parseFloat($('#discount').val()) || 0;
        $('.total').each(function() {
            grand_total += ($(this).val() - 0);
        })

        $('.totalwithvat').each(function() {
            total_with_vat += ($(this).val() - 0);
        })
        $('#grand_total').val(grand_total.toFixed(2));
        $('#net_amount').val(total_with_vat.toFixed(2));
        $('#due_amount').val(total_with_vat.toFixed(2));
    }

    function net_total_vat() {
        var vat_total = 0;

        $('.totalvat').each(function() {
            vat_total += ($(this).val() - 0);
        })

        $('#total_vat_amount').val(vat_total.toFixed(2));
    }
</script>

<script>
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
                                <input type="text" id="name" name="name[]" 
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
                                    value="${d.price}" class="form-control total" readonly>
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
                        net_total();
                        net_total_vat();

                    }
                },
                error: function(d) {
                    console.log(d);
                }
            });

        });

        // unit price calculation

        $("body").delegate(".unit-price, .quantity", "keyup change", function(event) {
            event.preventDefault();
            var row = $(this).closest('tr');
            var price = row.find('.unit-price').val();
            var qty = row.find('.quantity').val();

            if (isNaN(qty)) {
                qty = 1;
            }
            if (qty < 1) {
                qty = 1;
            }

            var total = price * qty;
            row.find('.total').val(total.toFixed(2));

            // Calculate total amounts
            var grand_total = 0;
            $('.total').each(function() {
                grand_total += ($(this).val() - 0);
            });

            // Get the VAT percent from the input field
            var vat_percent = parseFloat($("#vat_percent").val()) || 0;
            var total_vat = (grand_total * vat_percent) / 100;

            // Update total fields
            $('#total_vat_amount').val(total_vat.toFixed(2));
            $('#grand_total').val(grand_total.toFixed(2));
            $('#net_amount').val((grand_total + total_vat - (parseFloat($('#discount').val()) || 0)).toFixed(2));

            // Update due amount if necessary
            var paid_amount = parseFloat($("#paid_amount").val()) || 0;
            $('#due_amount').val((grand_total + total_vat - paid_amount - (parseFloat($('#discount').val()) || 0)).toFixed(2));

            let return_amount = (paid_amount > net_amount) ? -(paid_amount - net_amount) : 0;
            $('#return_amount').val(return_amount.toFixed(2)); 
        });

        // Listen for changes in the VAT percentage input
        $("#vat_percent").on('keyup change input', function() {
            // Get the current grand total
            var grand_total = parseFloat($("#grand_total").val()) || 0;

            // Get the current VAT percentage
            var vat_percent = parseFloat($(this).val()) || 0;

            // Calculate the total VAT
            var total_vat = (grand_total * vat_percent) / 100;

            // Update the total VAT amount field
            $('#total_vat_amount').val(total_vat.toFixed(2));

            // Calculate the net amount
            // var net_amount = grand_total + total_vat;
            $('#net_amount').val((grand_total + total_vat - (parseFloat($('#discount').val()) || 0)).toFixed(2));

            // Update the net amount field
            // $('#net_amount').val(net_amount.toFixed(2));

            // Update the due amount if necessary
            var paid_amount = parseFloat($("#paid_amount").val()) || 0;
            // $('#due_amount').val((net_amount - paid_amount).toFixed(2));
            $('#due_amount').val((grand_total + total_vat - paid_amount - (parseFloat($('#discount').val()) || 0)).toFixed(2));

            let return_amount = (paid_amount > net_amount) ? -(paid_amount - net_amount) : 0;
            $('#return_amount').val(return_amount.toFixed(2)); 
        });

        // submit to sales 
        var salesStoreurl = "{{URL::to('/admin/sales-store')}}";

        $("body").delegate("#salesBtn", "click", function(event) {
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

            console.log(data);


            $.ajax({
                url: salesStoreurl,
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

        // submit to delivery note 
        var deliverynoteurl = "{{URL::to('/admin/delivery-note-store')}}";

        $("body").delegate("#deliveryBtn", "click", function(event) {
            event.preventDefault();

            // $(".btn-submit").prepend('<i class="fa fa-spinner fa-spin" id="loader"></i>');
            // $(".btn-submit").attr("disabled", 'disabled');
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
                url: deliverynoteurl,
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
        //submit to delivery note  end

        // discount calculation
        $("#discount").on('keyup change input', function() {
            var dInput = this.value;
            var grand_total = parseFloat($("#grand_total").val());
            var total_vat_amount = parseFloat($("#total_vat_amount").val());
            var net_total = grand_total + total_vat_amount - (dInput || 0);

            $('#net_amount').val(net_total.toFixed(2));

            var paid_amount = parseFloat($("#paid_amount").val()) || 0;
            // $('#due_amount').val((net_amount - paid_amount).toFixed(2));
            $('#due_amount').val((grand_total + total_vat_amount - paid_amount - (parseFloat($('#discount').val()) || 0)).toFixed(2));

            let return_amount = (paid_amount > net_total) ? -(paid_amount - net_total) : 0;
            $('#return_amount').val(return_amount.toFixed(2)); 

            // calculateDue();
        });
        // discount calculation end

        $("#paid_amount").on('keyup change input', function() {
            // calculateDue();
        });
        // due calculation
        $("#paid_amount").on('keyup change input', function() {

            let paidInput = parseFloat(this.value) || 0;

            let net_amount = parseFloat($("#net_amount").val()) || 0;

            let due_amount = net_amount - paidInput;

            if (paidInput > net_amount) {
                $('#due_amount').val('');
            } else {
                $('#due_amount').val(due_amount.toFixed(2));
            }

            let returnAmount = (paidInput > net_amount) ? -(paidInput - net_amount) : 0;

            $('#return_amount').val(returnAmount.toFixed(2));
        });
            // due calculation end

        function net_total() {
            var grand_total = 0;
            var total_with_vat = 0;
            $('.total').each(function() {
                grand_total += ($(this).val() - 0);
            })

            $('.totalwithvat').each(function() {
                total_with_vat += ($(this).val() - 0);
            })
            $('#grand_total').val(grand_total.toFixed(2));
            $('#net_amount').val(total_with_vat.toFixed(2));
        }

        function net_total_vat() {
            var vat_total = 0;
            $('.vatamount').each(function() {
                vat_total += ($(this).val() - 0);
            })
            $('#net_vat_amount').val(vat_total.toFixed(2));
        }

    });
</script>

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