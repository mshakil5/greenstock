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

    <div class="row ">
        <div class="container-fluid">
            <div class="col-md-5">
                
                <div class="box box-default box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Role and Permission</h3> 
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body ir-table">
                        
                        

                        <table  class="table table-hover table-responsive " width="100%" id="supplierTBL">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th><i class=""></i> Action</th>
                                </tr>
                            </thead>
                            <tbody>
       
                                @if(Auth::user()->role_id == 1)
                                    @php
                                    $roles = \App\Models\Role::query()
                                        ->where('id', '!=', 1)
                                        ->get();
                                    @endphp
                                @else
                                @php
                                    $roles = \App\Models\Role::query()
                                        ->where('created_by', Auth::user()->id)
                                        ->where('id', '!=', 1)
                                        ->get();
                                    @endphp
                                @endif                           

                                @foreach ($roles as $data)
                                    <tr>
                                        <td>{{ $data->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.roleedit', $data->id)}}" class="btn btn-success btn-sm" ><i class='fa fa-pencil'></i> Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        
                        </table>

                        
                    </div>
                </div>
                <!-- /.box-body -->
                <!-- /.box -->
            </div>
            <div class="col-md-7">
                <div class="box box-default box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Create Role</h3>
                        <!-- /.box-tools -->
                    </div>
                    <div class="ermsg"></div>
                    <!-- /.box-header -->
                    <div class="box-body ir-table">

                        <form action="" method="post" id="permissionForm" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col-md-1">
                                    <table class="table table-hover">
                                    </table>
                                </div>
                                <div class="col-md-10">
                                    <table class="table table-hover">
                                        <tr>
                                            <td><label class="control-label">Role Name</label></td>
                                            <td>
                                                <input name="name" id="name" type="text" class="form-control" maxlength="50px" required="required"/>
                                            </td>
                                        </tr>
                                    </table>

                                    @php
                                        $permissions = json_decode(auth()->user()->role->permission, true);
                                    @endphp

                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-hover">
                                                
                                                @if (in_array(36, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Dashboard</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p36" name="permission[]" type="checkbox" value="36"><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(1, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Create Product</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p1" name="permission[]" type="checkbox" value="1"><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif
        
                                                @if (in_array(2, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Manage Product</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p2" name="permission[]" type="checkbox" value="2" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(37, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Product Code, Brand, Group</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p37" name="permission[]" type="checkbox" value="37"><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif
        
                                                @if (in_array(5, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Create Purchase</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p5" name="permission[]" type="checkbox" value="5" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(21, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Stock List</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p21" name="permission[]" type="checkbox" value="21" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif
        
                                                @if (in_array(6, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Edit Purchase</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p6" name="permission[]" type="checkbox" value="6" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif
        
                                                @if (in_array(7, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Stock Transfer</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p7" name="permission[]" type="checkbox" value="7" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(18, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Transfer History</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p18" name="permission[]" type="checkbox" value="18" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif
                                            
                                                @if (in_array(19, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Return History</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p19" name="permission[]" type="checkbox" value="19" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(38, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Damaged Products</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p38" name="permission[]" type="checkbox" value="38" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(3, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Create Sales</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p3" name="permission[]" type="checkbox" value="3" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif
        
                                                @if (in_array(4, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Edit Sales</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p4" name="permission[]" type="checkbox" value="4" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(9, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Create Quotation</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p9" name="permission[]" type="checkbox" value="9" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif
        
                                                @if (in_array(10, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Edit Quotation</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p10" name="permission[]" type="checkbox" value="10" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                
                                                @if (in_array(11, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Create Delivery Note</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p11" name="permission[]" type="checkbox" value="11" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif
        
                                                @if (in_array(12, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Edit Delivery Note</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p12" name="permission[]" type="checkbox" value="12" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(13, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Sales Return</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p13" name="permission[]" type="checkbox" value="13" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                
                                                @if (in_array(14, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Supplier</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p14" name="permission[]" type="checkbox" value="14" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-hover">


                                                @if (in_array(15, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Customer</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p15" name="permission[]" type="checkbox" value="15" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(16, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Branch</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p16" name="permission[]" type="checkbox" value="16" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(24, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Chart of Accounts</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p24" name="permission[]" type="checkbox" value="24" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(25, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Income</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p25" name="permission[]" type="checkbox" value="25" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                            @if (in_array(26, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Expense</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p26" name="permission[]" type="checkbox" value="26" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(27, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Assets</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p27" name="permission[]" type="checkbox" value="27" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(28, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Liabilities</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p28" name="permission[]" type="checkbox" value="28" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(29, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Equity</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p29" name="permission[]" type="checkbox" value="29" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(30, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Ledger</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p30" name="permission[]" type="checkbox" value="30" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(31, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Day Book</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p31" name="permission[]" type="checkbox" value="31" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(32, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Financial Statement</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p32" name="permission[]" type="checkbox" value="32" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(33, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Share Holders</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p33" name="permission[]" type="checkbox" value="33" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(23, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Reports</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p23" name="permission[]" type="checkbox" value="23" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(8, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Manage Admin</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p8" name="permission[]" type="checkbox" value="8" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(39, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Manage Employee</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p39" name="permission[]" type="checkbox" value="39" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(40, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Manage Role</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p40" name="permission[]" type="checkbox" value="40" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(17, $permissions))
                                                <tr style="display: none;">
                                                    <td><label class="control-label">Sales Module</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p17" name="permission[]" type="checkbox" value="17" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(20, $permissions))
                                                <tr style="display: none;">
                                                    <td><label class="control-label">Manage Product</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p20" name="permission[]" type="checkbox" value="20" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(22, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Payment Method</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p22" name="permission[]" type="checkbox" value="22" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif



                                                

                                                @if (in_array(34, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Switch Branch</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p34" name="permission[]" type="checkbox" value="34" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif

                                                @if (in_array(35, $permissions))
                                                <tr>
                                                    <td><label class="control-label">Company Details</label></td>
                                                    <td>
                                                        <label style="margin-top: -9px" class="switch"><input id="p35" name="permission[]" type="checkbox" value="35" ><span class="slider round"></span></label>
                                                    </td>
                                                </tr>
                                                @endif


                                            </table>
                                            
                                        </div>
                                    </div>
                                    
                                    <br>
                                    <button class="btn btn-success btn-md center-block" id="submitBtn" type="submit"><i class="fa fa-plus-circle"></i> Submit </button>

                                </div>

                                <div class="col-md-1">
                                    <table class="table table-hover">
                                    </table>
                                </div>


                                {{-- end  --}}
                            </div>
                        </form>
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
    $(document).ready(function () {

        // header for csrf-token is must in laravel
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        // 


        // submit to purchase 
         var url = "{{URL::to('/admin/role')}}";
        $("body").delegate("#submitBtn","click",function(event){
                event.preventDefault();

                var name = $("#name").val();
                var permission = $("input:checkbox:checked[name='permission[]']")
                    .map(function(){return $(this).val();}).get();

                    console.log(permission);

                $.ajax({
                    url: url,
                    method: "POST",
                    data: {name,permission},

                    success: function (d) {
                        if (d.status == 303) {
                            $(".ermsg").html(d.message);
                            pagetop();
                        }else if(d.status == 300){
                            $(".ermsg").html(d.message);
                            pagetop();
                            window.setTimeout(function(){location.reload()},2000)
                            
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
    