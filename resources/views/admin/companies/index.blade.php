@extends('admin.layouts.master')
@section('content')


<?php
$user_id = Session::get('categoryEmployId');
$branch_id = Session::get('brnach_id');
?>
<meta name="csrf-token" content="{{ csrf_token() }}"/>

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
<div class="row">
    <div class="col-md-12">
        @component('components.widget')
            @slot('title')
                Manage Company
                    <button class="btn btn-lg btn-success pull-right" data-toggle="modal"
                            data-target="#customerModal"
                            data-purpose="0">+
                        Add New Company
                    </button>
            @endslot
            @slot('description')
            Company information
            @endslot
            @slot('body')
                @component('components.table')
                    @slot('tableID')
                        customerTBL
                    @endslot
                    @slot('head')
                        <th>ID</th>
                        <th>Name</th>
                        <th><i class=""></i> Action</th>
                    @endslot
                @endcomponent
            @endslot
        @endcomponent
    </div>
</div>


<div class="modal fade" id="customerModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Company Details</h4>
            </div>
            <form class="form-horizontal" id="customer-form">
                <div class="modal-body">
                    {{csrf_field()}}

                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Name*</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control" id="name"
                                   placeholder="" required>
                        </div>
                    </div>
                    
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary submit-btn save-btn"> Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script>
    
    var customerurl = "{{URL::to('/admin/company')}}";
    var customerTBL = $('#customerTBL').DataTable({
        processing: true,
        serverSide: true,
        ajax: customerurl,
        deferRender: true,
        // searching:false,
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                    let button = `<button type="button" class="btn btn-warning btn-xs edit-btn" data-toggle="modal" data-target="#customerModal" value="${row.id}" title="Edit" data-purpose='1'><i class="fa fa-edit" aria-hidden="true"></i> Edit</button>`;
                    if (row.amount < 0) {
                        // button += `<button type="button" class="btn btn-success btn-xs omit-btn" value="${row.id}" title="Omitting Due Amount"><i class="fa fa-heart" aria-hidden="true"></i> Ommit Due</button>`;
                    }
                    return button;
                }
            },
        ]
    });

    // setInterval(customer_load,10000);

    $(document).on('click', '.mstatus-btn', function () {
        let confirmation = confirm("Are you sure to change the Membership status?");
        if (confirmation) {
            let id = $(this).val();
            console.log(id);
            $.ajax({
                url: '/customer/' + id + '/member-status',
                type: 'GET',
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (response) {
                    showSnakBar('Membership Status Changed Successfully');
                    customerTBL.draw();
                },
                error: function (err) {
                    console.log(err);
                    alert("Something Went Wrong, Please check again");
                }
            });
        }
    });

    $(document).on('click', '.status-btn', function () {
        let confirmation = confirm("Are you sure to change the status?");
        if (confirmation) {
            let id = $(this).val();
            console.log(id);
            $.ajax({
                url: customerurl + '/' + id + '/change-status',
                type: 'GET',
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (response) {
                    showSnakBar('Status Changed Successfully');
                    customerTBL.draw();
                },
                error: function (err) {
                    console.log(err);
                    alert("Something Went Wrong, Please check again");
                }
            });
        }
    });

    $(document).on('click', '.omit-btn', function () {
        let confirmation = confirm("Are you sure to change the status?");
        if (confirmation) {
            let id = $(this).val();
            console.log(id);
            $.ajax({
                url: '/customer/' + id + '/due-omit',
                type: 'GET',
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (response) {
                    showSnakBar('Due successfully Cleared');
                    customerTBL.draw();
                },
                error: function (err) {
                    console.log(err);
                    alert("Something Went Wrong, Please check again");
                }
            });
        }
    });

    $('#customerModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        let purpose = button.data('purpose');
        var modal = $(this);
        if (purpose) {
            let id = button.val();
            console.log(id);
            $.ajax({
                url: customerurl +'/' + id,
                type: 'GET',
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (response) {
                    modal.find('#name').val(response.customername);
                    

                    $('#customerModal .submit-btn').removeClass('save-btn').addClass('update-btn').text('Update').val(id);
                }
            });
        } else {
            $('#customer-form').trigger('reset');
            $('#customer-form textarea').text('');
            $('#customerModal .submit-btn').removeClass('update-btn').addClass('save-btn').text('Save').val("");
        }
    });

    $('#customerInvoiceModal').on('show.bs.modal', function (event) {
        let id = $(event.relatedTarget).val();
        $.ajax({
            url: '/customer/' + id + '/invoices',
            type: 'GET',
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function (response) {
                let ctp = $('#customerInvoiceTBL').DataTable();
                ctp.clear().draw(true);
                $.each(response.invoices, function (i, invoice) {
                    let button = `<button type="button" class="btn btn-primary btn-xs view-btn" data-toggle="modal" data-target="#product-details" value="${invoice.invoiceid}"><i class="fa fa-eye" aria-hidden="true"></i> View</button>`;
                    due = invoice.due;
                    if (due > 0) {
                        if (invoice.due_omitted) {
                            due = `<del>${due}</del>`;
                        }
                        due = `<span class="label-danger"  title="Due Omitted"> ${due} </span>`;
                    }
                    ctp.row.add([
                        invoice.invoiceid,
                        invoice.qty,
                        invoice.totalamount,
                        invoice.vatamount,
                        invoice.offeramount,
                        invoice.discount,
                        invoice.rebate,
                        due,
                        button
                    ]).draw(true);
                });
            }
        });
    });
    // save button event

    $(document).on('click', '.save-btn', function () {

        let name = $('#name').val().trim();

        if (name === '') {
            alert("Name field is required.");
            return;
        }
        let formData = $('#customer-form').serialize();
        // console.log(customerurl);
        $.ajax({
            url: customerurl,
            type: 'POST',
            data: formData,
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function (response) {
                $('#customerModal').modal('toggle');
                showSnakBar('Added Successfully');
                customerTBL.draw();
            },
            error: function (err) {
                console.log(err);
                alert("Something Went Wrong, Please check again");
            }
        });
    });

    // update button event

    $(document).on('click', '.update-btn', function () {

        let name = $('#name').val().trim();

        if (name === '') {
            alert("Name field is required.");
            return;
        }

        console.log($('#name').val());

        let formData = $('#customer-form').serialize();
        let id = $(this).val();
        if (!id) {
            alert("Something went wrong, Please try again");
            return;
        }
        $.ajax({
            url: customerurl + '/' + id,
            type: 'POST',
            data: formData,
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function (response) {
                $('#customerModal').modal('toggle');
                showSnakBar("Updated Successfully");
                customerTBL.draw();
            },
            error: function (err) {
                console.log(err);
                alert("Something Went Wrong, Please check again");
            }
        });
    });

    // Deposit event
    $(document).on('click', ' .deposite-btn', function () {
        let id = $(this).val();
        let confirmation = confirm("Are you sure to deposite an amount?");
        if (confirmation) {
            let amount = prompt("How much do you want to deposite?");
            amount = parseInt(amount);
            if(!amount){
                return ;
            }
            $.ajax({
                url: '/customer/' + id + '/deposite',
                type: 'POST',
                data: {'amount': amount},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (response) {
                    showSnakBar('Deposited Successfully');
                    customerTBL.draw();
                },
                error: function (err) {
                    console.log(err);
                    alert("Something Went Wrong, Please check again");
                }
            });
        }
    });
</script>






@endsection
    
@section('script')


@endsection