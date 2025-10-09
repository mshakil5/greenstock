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

        <div class="col-md-6">
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
                                    <th>User</th>
                                    <th>Work details</th>
                                    <th><i class=""></i> Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach (\App\Models\AssignStaff::where('service_request_id', $serviceRequest->id)->get() as $data)
                                    <tr>
                                        <td>{{ $data->date}}</td>
                                        <td>{{ $data->user->name ?? ""}}</td>
                                        <td>{{ $data->note}}</td>
                                        <td>
                                            <span class="btn btn-success btn-sm editThis" id="editThis" vid="{{$data->id}}" code="{{$data->id}}" date="{{$data->date}}" note="{{$data->note}}" user_id="{{$data->user_id}}"> <i class='fa fa-pencil'></i> Edit </span>

                                            <form action="{{ route('admin.assignStaffDelete', $data->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this assignment?');">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </form>


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



        <div class="col-md-6">
            @component('components.widget')
                @slot('title')
                    Information
                @endslot
                @slot('body')
                    <hr/>
                    <div class="col-sm-12" id="createDiv">
                        <form class="form-horizontal" action="{{ route('admin.assignStaffStore')}}" method="POST">
                            {{csrf_field()}}
                            <input type="hidden" name="service_request_id" value="{{$serviceRequest->id}}">
                            
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
                                <label class="col-sm-3 control-label">Staff<span
                                class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <select name="user_id" class="form-control" required>
                                        <option value="">Select Staff</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($errors->has('user_id'))
                                    <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $errors->first('user_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Working details</label>
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
                        <form class="form-horizontal" action="{{ route('admin.assignStaffUpdate')}}" method="POST" id="editForm">
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
                                <label class="col-sm-3 control-label">Staff<span
                                class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <select name="user_id" id="user_id" class="form-control" required>
                                        <option value="">Select Staff</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($errors->has('user_id'))
                                    <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $errors->first('user_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            
                            
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Working details</label>
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
            note = $(this).attr('note');
            user_id = $(this).attr('user_id');
            date = $(this).attr('date');
            $('#requestid').val(requestid);
            $('#date').val(date);
            $('#note').val(note);
            $('#user_id').val(user_id);

            
            
                
        });
        // return stock end





    });  
    </script>

@endsection
    