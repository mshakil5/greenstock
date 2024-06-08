@extends('admin.layouts.master')
@section('content')




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
<!-- get stock alert limit quantity -->


<div class="row">
<div class="col-md-12">
    <div class="box box-widget">
        <div class="box-body">
            <table id="stockTBL" class="table table-striped stckTbl">
                <thead>
                <tr>
                    <th class="text-center"><i class="icon-sort"></i>Date</th>
                    <th><i class="icon-sort"></i>Products</th>
                    <th><i class="icon-sort"></i>Products Code</th>
                    <th><i class="icon-sort"></i>Branch</th>
                    <th><i class="icon-sort"></i>Return Qty</th>
                    <th><i class="icon-sort"></i>Reason</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($histories as $stock)
                        <tr>
                            <td class="text-center">{{ date('d-m-Y', strtotime($stock->created_at))}} </td>
                            <td>{{ $stock->product->productname }} </td>
                            <td>{{ $stock->product->part_no }} </td>
                            <td>{{ \App\Models\Branch::where('id',$stock->branch_id )->first()->name }}</td>
                            <td>{{ $stock->returnqty }}</td>
                            <td>{{ $stock->reason }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>


        </div>
    </div>
</div>
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


function emptyTableData() {
    var table = $(".display tbody");
    table.empty();
}


</script>



@endsection
    
@section('script')

@endsection