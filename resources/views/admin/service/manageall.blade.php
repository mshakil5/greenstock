@extends('admin.layouts.master')
@section('content')



<div class="row">
<div class="col-md-12">
    <div class="box box-widget">
        <div class="box-body">
            <table id="stockTBL" class="table table-striped stckTbl">
                <thead>
                <tr>
                    <th><i class="icon-sort"></i>Service Name</th>
                    <th class="text-center"><i class="icon-sort"></i>Code</th>
                    <th class="text-center"><i class="icon-sort"></i>Service Product</th>
                    <th class="text-center"><i class="icon-sort"></i>Sell price</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($data as $data)
                        <tr>
                            <td>
                                {{ $data->name }}
                            </td>
                            <td class="text-center">{{ $data->code }}</td>
                            <td class="text-center"> 
                                @if (isset($data->serviceDetail))
                                    @foreach ($data->serviceDetail as $item)
                                        <p>Product Name: {{$item->product->productname ?? " "}}, <br> Qty: {{$item->quantity ?? " "}} </p>
                                    @endforeach
                                @endif
                                
                            </td>
                            <td class="text-center">{{ $data->price }}</td>
                            <td class="text-center"> </td>
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


</script>

@endsection
    
@section('script')

@endsection