@extends('admin.layouts.master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />

<div class="row ">
    <div class="container-fluid">

        <div class="col-md-1"></div>
        <div class="col-md-10 mx-auto">
            <div class="box box-default box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Create new service request</h3>
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

                    <form id="createThisForm">

                        <div class="form-row">

                            <div class="form-group col-md-2">
                                <label for="date">Date *</label>
                                <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d') }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="bill_no">Bill Number</label>
                                <input type="number" class="form-control" id="bill_no" name="bill_no">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="invoice_no">Our Invoice Number</label>
                                <input type="text" class="form-control" value="{{$invoiceNo}}" id="invoice_no" name="invoice_no" readonly>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="warranty">Warranty Status</label>
                                <select name="warranty" id="warranty" class="form-control">
                                    <option value="">Please Select</option>
                                    <option value="Full Warranty">Full Warranty</option>
                                    <option value="Service Only">Service Only</option>
                                    <option value="Parts Only">Parts Only</option>
                                    <option value="Out of Warranty">Out of Warranty</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="staff">Assign to staff</label>
                                <select name="staff" id="staff" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach (\App\Models\User::where('branch_id', Auth::user()->branch_id)->where('role_id','4')->get() as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="company_id">Company</label>
                                <select name="company_id" id="company_id" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach (\App\Models\Company::all() as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="product_type">Product type</label>
                                <input type="text" class="form-control" id="product_type" name="product_type" placeholder="Ac, Fridge, TV etc">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="customer_name">Customer Name</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name">
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="customer_phone">Customer Phone</label>
                                <input type="text" class="form-control" id="customer_phone" name="customer_phone">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="address">Customer Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="document">Document</label>
                                <input type="file" class="form-control" id="document" name="document">
                            </div>

                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <div class="button-container" style="display: flex; justify-content: center; gap: 10px; margin-top: 10px;">
                                    <button class="btn btn-success btn-md btn-submit" id="requestBtn" type="submit">
                                        <i class="fa fa-plus-circle"></i> Create a new Request 
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
        
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


        // header for csrf-token is must in laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // 

        // submit to quotation 

        $("body").delegate("#requestBtn", "click", function(event) {
            event.preventDefault();

            $(this).find('.fa-spinner').remove();
            $(this).prepend('<i class="fa fa-spinner fa-spin"></i>');
            $(this).attr("disabled", 'disabled');

            
            var formData = new FormData($('#createThisForm')[0]);

            $.ajax({
                url: '{{ route("salesServiceRequestStore") }}',
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(d) {
                    console.log(d);
                    $("#loader").removeClass('fa fa-spinner fa-spin');
                    $(".btn-submit").removeAttr("disabled", true);

                    if (d.status == 400) {
                        $(".ermsg").html(d.message);
                    } else {
                        $(".ermsg").html(d.message);
                        window.setTimeout(function(){location.reload()},2000)
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