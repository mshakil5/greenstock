@extends('admin.layouts.master')
@section('content')


@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    @if ($errors->any())
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (Session::has('success'))
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <p>{{ Session::get('success') }}</p>
        </div>
        {{ Session::forget('success') }}
    @endif

    <div class="row">

        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    @component('components.widget')
                        @slot('title')
                            New Order Product for Order Number: {{$serviceRequest->invoice_no}}
                        @endslot
                        @slot('description')
                            
                        @endslot
                        @slot('body')

                        <table  class="table table-hover table-responsive " width="100%" id="supplierTBL">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Note</th>
                                    <th>Status</th>
                                    <th><i class=""></i> Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach (\App\Models\CompanyProduct::where('service_request_id', $serviceRequest->id)->get() as $data)
                                    <tr>
                                        <td>{{ $data->date}}</td>
                                        <td>{{ $data->name}}</td>
                                        <td>{{ $data->quantity}}</td>
                                        <td>{{ $data->note}}</td>
                                        <td>
                                            <span class="badge badge-info">
                                                @switch($data->status)
                                                    @case(1)
                                                        Ordered
                                                        @break
                                                    @case(2)
                                                        Processing
                                                        @break
                                                    @case(3)
                                                        On the way
                                                        @break
                                                    @case(4)
                                                        Received
                                                        @break
                                                    @case(5)
                                                        Return
                                                        @break
                                                    @case(6)
                                                        Cancel
                                                        @break
                                                    @default
                                                        Unknown
                                                @endswitch
                                            </span>
                                        </td>
                                        <td>
                                            <span class="btn btn-success btn-sm editThis" id="editThis" vid="{{$data->id}}" code="{{$data->id}}" name="{{$data->name}}" quantity="{{$data->quantity}}" date="{{$data->date}}" note="{{$data->note}}" status="{{$data->status}}" > <i class='fa fa-pencil'></i> Edit </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            
                            </tfoot>
                        
                        </table>

                        @endslot
                    @endcomponent
                </div>
            </div>
           
        </div>



        <div class="col-md-4">
            @component('components.widget')
                @slot('title')
                    Information
                @endslot
                @slot('body')
                    <hr/>
                    <div class="col-sm-12" id="createDiv">
                        <form class="form-horizontal" action="{{ route('admin.orderNewProductStore')}}" method="POST">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="hidden" name="service_request_id" value="{{$serviceRequest->id}}">
                                <label class="col-sm-3 control-label">Product Name<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Date<span
                                class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="date" name="date" class="form-control" required>
                                </div>
                                @if ($errors->has('date'))
                                    <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Quantity</label>
                                <div class="col-sm-9">
                                    <input type="number" name="quantity" class="form-control" required>
                                </div>
                                @if ($errors->has('quantity'))
                                    <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $errors->first('quantity') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-3 control-label">Status</label>
                                <div class="col-sm-9">
                                    <select name="status" class="form-control" required>
                                        <option value="1">Ordered</option>
                                        <option value="2">Processing</option>
                                        <option value="3">On the way</option>
                                        <option value="4">Received</option>
                                        <option value="5">Return</option>
                                        <option value="6">Cancel</option>
                                    </select>
                                </div>
                                @if ($errors->has('status'))
                                    <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Company Information and Note</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" rows="3" placeholder="" name="note"></textarea>
                                </div>
                                @if ($errors->has('note'))
                                    <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $errors->first('note') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary center-block"><i class="fa fa-save"></i> Save</button>

                        </form>
                    </div>

                    <div class="col-sm-12" id="editDiv">
                        <form class="form-horizontal" action="{{ route('admin.orderNewProductUpdate')}}" method="POST" id="editForm">
                            {{csrf_field()}}
                            <div class="form-group d-none">
                                <label for="" class="col-sm-3 control-label">Code</label>
                                <div class="col-sm-9">
                                    <input type="hidden" name="requestid" class="form-control" id="requestid">
                                </div>
                                @if ($errors->has('code'))
                                    <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Product Name<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Date<span
                                class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="date" name="date" id="date" class="form-control" required>
                                </div>
                                @if ($errors->has('date'))
                                    <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Quantity</label>
                                <div class="col-sm-9">
                                    <input type="number" name="quantity" id="quantity" class="form-control" required>
                                </div>
                                @if ($errors->has('quantity'))
                                    <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $errors->first('quantity') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-3 control-label">Status</label>
                                <div class="col-sm-9">
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="1">Ordered</option>
                                        <option value="2">Processing</option>
                                        <option value="3">On the way</option>
                                        <option value="4">Received</option>
                                        <option value="5">Return</option>
                                        <option value="6">Cancel</option>
                                    </select>
                                </div>
                                @if ($errors->has('status'))
                                    <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Company Information and Note</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" rows="3" id="note" name="note" ></textarea>
                                </div>
                                @if ($errors->has('note'))
                                    <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $errors->first('note') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
                                <input type="button" class="btn btn-warning" id="FormCloseBtn" value="Close">
                            </div>

                        </form>
                    </div>
                @endslot
            @endcomponent
        </div>
        
    </div>
    <script>
        $(document).ready(function () {
            $('.select2').select2();
            $('#supplierTBL').DataTable({
                'paging': true,
                'lengthChange': true,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': true
            });

        });
    </script>


@endsection
    
@section('script')
<script>
    $(document).ready(function () {

        
        
        $("#editDiv").hide();
        $("#FormCloseBtn").click(function(){
            $("#editDiv").hide();
            $("#createDiv").show();
            $('#editForm').trigger("reset");
        });


        // header for csrf-token is must in laravel
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        // 



        // return stock
        $("#supplierTBL").on('click','#editThis', function(){
            $("#editDiv").show();
            $("#createDiv").hide();
            requestid = $(this).attr('vid');
            name = $(this).attr('name');
            quantity = $(this).attr('quantity');
            note = $(this).attr('note');
            date = $(this).attr('date');
            status = $(this).attr('status');
            $('#requestid').val(requestid);
            $('#name').val(name);
            $('#quantity').val(quantity);
            $('#date').val(date);
            $('#status').val(status);
            $('#note').val(note);
            
                
        });
        // return stock end



        // submit to purchase 
        var purchasereturnurl = "{{URL::to('/admin/purchase-return')}}";

            $("body").delegate("#purchasereturnBtn","click",function(event){
                event.preventDefault();

                
                var branch_id = $("#branch_id").val();
                var purchase_id = $("#purchase_id").val();
                var reason = $("#reason").val();
                var date = $("#date").val();
                
                var product_id = $("input[name='product_id[]']")
                    .map(function(){return $(this).val();}).get();
                    
                var quantity = $("input[name='quantity[]']")
                    .map(function(){return $(this).val();}).get();

                    
                var purchase_his_id = $("input[name='purchase_his_id[]']")
                    .map(function(){return $(this).val();}).get();


                $.ajax({
                    url: purchasereturnurl + '/' + purchase_id,
                    method: "POST",
                    data: {branch_id,date,reason,product_id,purchase_his_id,quantity},

                    success: function (d) {
                        if (d.status == 303) {
                            $(".ermsg").html(d.message);
                            pagetop();
                        }else if(d.status == 300){
                            $(".ermsg").html(d.message);
                            pagetop();
                            window.setTimeout(function(){location.href = "{{ route('admin.product.purchasehistory')}}"},2000)
                            
                        }
                    },
                    error: function (d) {
                        console.log(d);
                    }
                });

        });
        // submit to purchase end

















    });  
    </script>

@endsection
    