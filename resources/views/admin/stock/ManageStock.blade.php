@extends('admin.layouts.master')
@section('content')



@if (session('message'))
<div class="alert alert-success">
    {{ session('message') }}
</div>
@endif
<?php
echo Session::put('message', '');
?>
@if (session('info'))
<div class="alert alert-danger">
    {{ session('info') }}
</div>
@endif
<?php
echo Session::put('info', '');
?>
<style>
/*.stock-alert{
  color: red;
  font-weight: bold;
}*/
.transferProduct .select2-container--default {
    width: 100% !important;
    text-align: left;
}

.transferProduct .row {
    text-align: center;
    margin: 10px 0px;
}

.stock-alert {
    font-weight: bold;
    animation-duration: 1200ms;
    animation-name: blink;
    animation-iteration-count: infinite;
    animation-direction: alternate;
    -webkit-animation: blink 1200ms infinite; /* Safari and Chrome */
}

@keyframes blink {
    from {
        background-color: red;
        color: white;
    }
    to {
        background-color: white;
        color: red;
    }
}

@-webkit-keyframes blink {
    from {
        background-color: red;
        color: white;
    }
    to {
        background-color: white;
        color: red;
    }
}
</style>

{{-- <div class="row">
<div class="conainer-fluid">
    <div class="col-md-12">
        <div class="overview">
            <div class="alert alert-danger h4  d-none"> Manage Stock(All Branch) - Show all products purchase
                details and transfer products to branches.
            </div>
            <div id="ermsg" class="ermsg"></div>
        </div>
    </div>
</div>
</div> --}}

{{-- <div class="row well d-none">
    <form class="form-horizontal" role="form" method="POST" action="{{ route('managestock.search') }}">
        {{ csrf_field() }}

        <div class="col-md-4">
            <label class="label label-primary">Branch</label>
            <select class="form-control select2" name="branch_id">
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}" {{ request()->input('branch_id') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <br>
            <button type="submit" class="btn btn-primary btn-sm">Search</button>
        </div>
    </form>
</div> --}}

<div class="row">
<div class="col-md-12">
    <div class="box box-widget">
        <div class="box-body">
            <table id="stockTBL" class="table table-striped stckTbl">
                <thead>
                <tr>
                    <th><i class="icon-sort"></i>Products</th>
                    {{-- <th><i class="icon-sort"></i>Branch</th> --}}
                    <th class="text-center"><i class="icon-sort"></i>Unit</th>
                    <th class="text-center"><i class="icon-sort"></i>Stock QTY</th>
                    <th class="text-center"><i class="icon-sort"></i>Sell price</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($stocks as $stock)
                        <tr>
                            <td>
                                {{ $stock->productname }} ({{ $stock->product_id }})
                            </td>
                            {{-- <td>{{ \App\Models\Branch::where('id',$stock->branch_id)->first()->name }}</td> --}}
                            <td class="text-center">{{ $stock->unit }}</td>
                            <td class="text-center stockQuantity">{{ $stock->quantity }}</td>
                            <td class="text-center">{{ $stock->selling_price }}</td>
                            <td class="text-center">
                                    {{-- <button class="btn btn-success btn-sm" data-toggle="modal"
                                            data-target="#purchaseModal"
                                            onclick="manageStockPurchaseDetails({{ $stock->id }})">
                                        <i class="fa fa-eye"></i> Details
                                    </button> --}}
                                    {{-- @if((Auth::user()->type == '1' || Auth::user()->type == '0') && in_array('7', json_decode(Auth::user()->role->permission)))
                                        <button class="btn btn-primary btn-sm btn-transfer" data-toggle="modal"
                                                data-target="#transferModal" pname="{{ $stock->productname }}" 
                                                bid="{{ $stock->branch_id }}" pid="{{ $stock->product_id }}" 
                                                tstock="{{ $stock->quantity }}" value="{{ $stock->id }}">
                                            <i class="fa fa-arrow-up"></i> Transfer
                                        </button>
                                    @endif --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>


        </div>
    </div>
</div>
</div>

<!----------------------------Stock Purchase Modal ------------------------->
<div class="modal fade" id="purchaseModal">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header alert alert-success" style="text-align: left;">
            <div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                        onclick="emptyTableData()">&times;
                </button>
                <h4 class="modal-title">#Purchase Details</h4>
            </div>
        </div>
        <div class="modal-body">

            <table class="display table table-bordered" style="width: 100%;">
                <thead>
                <tr>
                    <th>Date Time</th>
                    <th>Satus</th>
                    <th>Invoice</th>
                    <th class="text-center">Quantity</th>
                    <th>Purchase Price</th>
                    <th>Product</th>
                    <th>Barcode</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="emptyTableData()">
                Close
            </button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!----------------------------TransferModal ------------------------->
<div class="modal fade transfer-modal" id="transferModal">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header alert alert-success" style="text-align: left;">
            <div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">#Transfer Products</h4>
            </div>
        </div>
        <div class="modal-body transferProduct">
            <div class="row">
                
            <div id="ermsg" class="ermsg"></div>
                <div class="col-sm-6">
                    <label for="productname">Product Name</label>
                    <input type="text" name="productname" id="productname" class="form-control text-center"
                           readonly="">
                    <input type="hidden" name="productid" id="productid">
                    <input type="hidden" name="stockid" id="stockid">
                    <input type="hidden" name="frombranchid" id="frombranchid">
                </div>
                <div class="col-sm-6">
                    <label for="stockQuantity">Stock QTY</label>
                    <input type="text" name="stockQuantity" id="stockQuantity" class="form-control text-center"
                           readonly="">
                </div>
                {{-- <div class="col-sm-3">
                    <label for="branch">Belongs Branch</label>
                    <input type="text" id="belongsBranchName" class="form-control text-center" readonly="">
                    <input type="hidden" name="belongsBranchId" id="belongsBranchId">
                </div> --}}
            </div>
            <hr>
            <div class="row text-left tValues">
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="row">
                        <div class="col-sm-4 text-left">
                            <label for="brnachToTransfer">Transfer To: </label>
                        </div>
                        <div class="col-sm-8">
                            <select name="brnachToTransfer" id="brnachToTransfer" class="form-control select2"
                                    style="width: 100%;">
                                <option value="">Select Branch</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-left">
                            <label for="transferQty">Transfer Quantity: </label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number" class="form-control allownumericwithoutdecimal"
                                   name="transferQty" id="transferQty" style="width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-success" onclick="saveTransfer()"><i
                                class="fa fa-arrow-up"></i> Transfer
                    </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>

<script>
$(function () {
    $('.select2').select2();
});
$(document).ready(function () {
   $('#stockTBL').on( 'page.dt', function () {
   }).dataTable({
        "order": [[ 3, "asc" ]],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                className: 'btn btn-md',
                exportOptions: {
                    columns: [0, 1, 2, 3,4]
                }
            },
            {
                extend: 'csv',
                className: 'btn btn-md',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'pdf',
                className: 'btn btn-md',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
        ]
   });
});

function manageStockPurchaseDetails($barcodeid) {
    let purchaseDetails = null;
    var table = $(".display tbody");
    $.ajax({
        url: '/manage-stock-purchase-details/' + $barcodeid,
        data: {},
        type: 'GET',
        xhrFields: {
            withCredentials: true
        },
        beforeSend: function (request) {
            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
        },
        success: function (data) {
            //console.log(data);

            $.each(data, function (a, b) {
                //table.empty();
                table.append("<tr><td class='text-left'>" + `${moment(b.created_at).format('DD MMMM YYYY hh:mm A')}` + "</td>" +
                    "<td class='text-success text-left'>" + "Purchased" + "</td>" +
                    "<td class='text-left'>" + '<a target="_blank" title="Show Invoice Detail" href="/purchase-invoice/'+ b.get_product_purchase_record[0].purchaseid +'/details">' + "Inv-" + b.get_product_purchase_record[0].purchaseid + "</a></td>" +
                    "<td class='text-center'>" + b.qty + "</td>" +
                    "<td class='text-center'>" + b.purchaseprice + "</td>" +
                    "<td class='text-left'>" + b.products.productname +"(" + b.products.productid + ")" + "</td>" +
                    "<td class='text-left'>" + b.barcodeid + "</td>" +
                    "</tr>");
            });
            $(".display").DataTable();
            //console.log(data);
        },
        error: function (err) {
            console.log(err);
            alert("Something Went Wrong, Please check again");
        }
    });

    return purchaseDetails;
}

function emptyTableData() {
    var table = $(".display tbody");
    table.empty();
}

$(".allownumericwithoutdecimal").on("keypress keyup blur", function (event) {
    $(this).val($(this).val().replace(/[^\d].+/, ""));
    if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
});

$(document).on('click', '.btn-transfer', function () {
    let stockid = $(this).val();
    branchid = $(this).attr('bid');
    productid = $(this).attr('pid');
    pname = $(this).attr('pname');
    totalstock = $(this).attr('tstock');
    $('#transferModal').find('.modal-body #productname').val(pname);
    $('#transferModal').find('.modal-body #productid').val(productid);
    $('#transferModal').find('.modal-body #stockQuantity').val(totalstock);
    $('#transferModal').find('.modal-body #stockid').val(stockid);
    $('#transferModal').find('.modal-body #frombranchid').val(branchid);
});

$('#transferModal').on('show.bs.modal', function (event) {
    var modal = $(this)
    modal.find('.modal-body input').val("");
    modal.find('.modal-body #brnachToTransfer').select2("").trigger('change');
});

        var tranurl = "{{URL::to('/admin/admin-stock-transfer')}}";

        function saveTransfer() {
            if ($('#brnachToTransfer').val() == "") {
                alert("Please select branch to stock transfer!");
            } else if ($('#transferQty').val() == "") {
                alert("Please input quantity to stock transfer!");
            } else if (Number($('#transferQty').val()) <= 0) {
                alert("Quantity should not be zero/negative value!");
            } else if (Number($('#transferQty').val()) > Number($('#stockQuantity').val())) {
                alert("You have not sufficient stock!");
            } else {
                let data = {
                    productid: $('#productid').val(),
                    stockid: $('#stockid').val(),
                    frombranchid: $('#frombranchid').val(),
                    stockQuantity: $('#stockQuantity').val(),
                    brnachToTransfer: $('#brnachToTransfer').val(),
                    transferQty: $('#transferQty').val(),
                };
                console.log(data);
                $.ajax({
                    data: {
                        data: data
                    },
                    url: tranurl,
                    type: 'POST',
                    beforeSend: function (request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                    },
                    success: function (response) {
                        if (response.status == 303) {
                            $(".ermsg").html(response.message);
                        }else if(response.status == 300){
                            $(".ermsg").html(response.message);
                            $("#brnachToTransfer").val("");
                            $("#transferQty").val("");
                            window.setTimeout(function(){location.reload()},2000)
                        }
                    },
                    error: function (data) {
                        var errors = data.responseJSON;
                        $(".ermsg").html(data.message);
                    }

                });
            }
        }


</script>

@endsection
    
@section('script')

@endsection