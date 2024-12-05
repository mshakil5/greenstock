@extends('admin.layouts.master')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />

<script>

</script>
<div class="row ">
    <div class="container-fluid">
        <div class="col-md-12">

        </div>
        <div class="col-md-9">
            <div class="box box-default box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Service</h3>
                    <!-- /.box-tools -->
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

                <!-- /.box-header -->
                <div class="box-body ir-table">

                    <form>

                        

                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="name">Service Name</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="code">Service ID</label>
                                <input type="number" class="form-control" id="code" name="code">
                            </div>

                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="product">Product*</label>
                                <select name="product" id="product" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach (\App\Models\Product::select('id','productname','part_no')->where('branch_id', Auth::user()->branch_id)->get() as $product)
                                    <option value="{{ $product->id }}">{{ $product->productname }}-{{ $product->part_no }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="price">Price</label>
                                <input type="number" class="form-control" id="price" name="price">
                            </div>

                        </div>
                    </form>
                </div>


            </div>

            <div class="box box-default box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Product List</h3>
                    <!-- /.box-tools -->
                </div>

                <table class="table table-hover" id="protable">
                    <thead>
                        <tr>
                            <th class="text-center">Product Name</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Unit Price</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody id="inner">
                    </tbody>
                </table>

                


                <div class="form-row">
                    <div class="form-group row ">
                        <div class="col-md-12">
                            <button class="btn btn-success btn-md center-block btn-submit" id="purchaseBtn" type="submit"><i class="fa fa-plus-circle"></i> Submit </button>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
            <!-- /.box -->
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


<script type="text/javascript">
    function removeRow(event) {
        event.target.parentElement.parentElement.remove();
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

                       $("#product").val('');
                        // console.log(d);

                        var markup = '<tr><td class="text-center"><input type="text" id="productname" name="productname[]" value="' + d.productname + '" class="form-control" readonly><input type="hidden" id="product_id" name="product_id[]" value="' + d.product_id + '" class="form-control ckproduct_id" readonly></td><td class="text-center"><input type="number" id="quantity" name="quantity[]" value="1" min="1" class="form-control quantity" ></td><td class="text-center"><input type="number" id="unit_price" name="unit_price[]" value="" class="form-control unit-price"></td><td class="text-center"><div style="color: white;  user-select:none;  padding: 5px;    background: red;    width: 45px;    display: flex;    align-items: center; margin-right:5px;   justify-content: center;    border-radius: 4px;   left: 4px;    top: 81px;" onclick="removeRow(event)" >X</div></td></tr>';

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






        

        // submit to purchase 
        var purchaseurl = "{{URL::to('/admin/add-services')}}";

        $("body").delegate("#purchaseBtn", "click", function(event) {
            event.preventDefault();

            $(".btn-submit").prepend('<i class="fa fa-spinner fa-spin" id="loader"></i>');
            $(".btn-submit").attr("disabled", 'disabled');

            var code = $("#code").val();
            var name = $("#name").val();
            var price = $("#price").val();

            var product_id = $("input[name='product_id[]']")
                .map(function() {
                    return $(this).val();
                }).get();

            var quantity = $("input[name='quantity[]']")
                .map(function() {
                    return $(this).val();
                }).get();


            $.ajax({
                url: purchaseurl,
                method: "POST",
                data: {
                    code,
                    name,
                    price,
                    product_id,
                    quantity,
                },

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
                    console.error(xhr.responseText);
                }
            });

        });
        // submit to purchase end



        

    });
</script>

@endsection