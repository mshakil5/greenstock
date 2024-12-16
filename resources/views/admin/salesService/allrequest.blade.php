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
                    
                    

                    <table  id="" class="table table-hover table-responsive " width="100%">
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
                                <th><i class=""></i> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($data as $key => $item)
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
                                <td></td>
                            </tr>
                            @endforeach
                    
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
        $(".date input").val('');


    });
</script>



@endsection