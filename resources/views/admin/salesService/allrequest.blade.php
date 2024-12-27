@extends('admin.layouts.master')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}" />
<?php
$user_id = Session::get('categoryEmployId');
?>
{{-- <div id="loader"></div> --}}
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
// echo Session::put('info', '');
?>
<div class="">
    <div class="container-fluid">
        <div class="display-item">
            <div class="row">
                <div class="col-md-12">
                    
                    

                    <table  id="allinvoiceTBL" class="table table-hover table-responsive " width="100%">
                        <thead>
                        
                            <tr>
                                <th>Id</th>
                                <th>Invoice No</th>
                                <th>Bill No</th>
                                <th>Date</th>
                                <th>Customer Name</th>
                                <th>Customer Phone</th>
                                <th>Customer Address</th>
                                <th>Assign Staff</th>
                                <th>Company Name</th>
                                <th>Status</th>
                                <th><i class=""></i> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            {{-- @foreach ($data as $key => $item)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$item->invoice_no}}</td>
                                <td>{{$item->bill_no}}</td>
                                <td>{{$item->date}}</td>
                                <td>{{$item->customer_name}}</td>
                                <td>{{$item->customer_phone}}</td>
                                <td>{{$item->address}}</td>
                                <td>{{$item->user->name}}</td>
                                <td>{{$item->company->name}}</td>
                                
                                <td>{{$item->status}}</td>

                                <td>
                                    <div class="table-actions"><a href="{{route('admin.processingService', $item->id)}}" class="btn btn-sm btn-primary"><span title="View"><i class="fa fa-eye"></i>View</span></a></div>
                                </td>
                            </tr>
                            @endforeach --}}
                    
                        </tbody>
                    
                    </table>
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
        

        $('#allinvoiceTBL').DataTable({
            processing: true,
            serverSide: true,
            dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<"dt-filter-spacer"f><ip>',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            ajax: {
                url: '{{ route("admin.getServiceRequest") }}',
                data: function(d) {
                    console.log(d);
                },
                error: function(xhr, error, code) {
                    console.log("AJAX Error");
                    console.log("Status Code:", xhr.status); // HTTP status code
                    console.log("Response Text:", xhr.responseText); // Full response
                    console.log("Error Thrown:", error); // Error thrown
                    console.log("Error Code:", code); // Error code
                }
            },
            deferRender: true,
            order: [
                [0, "desc"]
            ],
            // searching:false,
            columns: [
                // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'invoice_no',
                    name: 'invoice_no'
                },
                {
                    data: 'bill_no',
                    name: 'bill_no'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'customer_name',
                    name: 'customer_name'
                },
                {
                    data: 'customer_phone',
                    name: 'customer_phone'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'assign_staff',
                    name: 'assign_staff'
                },
                {
                    data: 'company',
                    name: 'company'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });


    });
</script>



@endsection