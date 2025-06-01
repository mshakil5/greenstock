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
                            
                            
                    
                        </tbody>
                    
                    </table>
                </div>




            </div>
        </div>

    </div>
</div>

<!-- Modal for adding a note -->
<div class="modal fade" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="noteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="noteModalLabel">Add Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="noteForm">
                <div class="modal-body">
                    <input type="hidden" name="order_id" value="">
                    <input type="hidden" name="status" value="">
                    <div class="form-group">
                        <label for="note">Note</label>
                        <textarea name="note" class="form-control" rows="4" placeholder="Enter your note here"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="changeStatus" class="btn btn-primary">Save Note</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal for viewing all reviews -->
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">Staff Reviews</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Review</th>
                        </tr>
                    </thead>
                    <tbody id="reviewTableBody">
                        <!-- Reviews will be dynamically loaded here -->
                        
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                url: '{{ route("admin.getServiceRequestProcessing") }}',
                data: function(d) {
                    // console.log(d);
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

<script>
    $(document).ready(function() {
        $(document).on('change', '.status-dropdown', function() {
            var status = $(this).val();
            var orderId = $(this).data('order-id');

            // Open a modal with a note field
            var modal = $('#noteModal');
            modal.find('textarea[name="note"]').val(''); // Clear the note field
            modal.find('input[name="order_id"]').val(orderId); // Set the order ID in the modal
            modal.find('input[name="status"]').val(status); // Set the order ID in the modal
            modal.modal('show');
        });

        $(document).on('click', '#changeStatus', function() {
            

            var note = $('#noteForm').find('textarea[name="note"]').val();
            var orderId = $('#noteForm').find('input[name="order_id"]').val();
            var status = $('#noteForm').find('input[name="status"]').val();


            console.log(status, orderId);
            $.ajax({
                url: '{{ route("admin.updateStatus") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status,
                    orderId: orderId,
                    note: note
                },
                success: function(response) {

                    console.log(response);
                    if (response.status == 200) {
                        alert('Status updated successfully');
                        $('#noteModal').modal('hide');
                        $('#allinvoiceTBL').DataTable().ajax.reload();
                    } else {
                        alert('Failed to update status');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('An error occurred while updating status');
                }
            });
        });


        $(document).on('click', '.reviewModal', function() {
            var serviceid = $(this).data('serviceid');

            console.log(serviceid);
            $.ajax({
            url: '{{ route("admin.getStaffReviews") }}',
            method: 'GET',
            data: {
                serviceid: serviceid
            },
            success: function(response) {

                console.log(response);
                if (response.status == 200) {
                var reviews = response.data;
                var reviewTableBody = $('#reviewTableBody');
                reviewTableBody.empty();

                reviews.forEach(function(review) {
                    reviewTableBody.append(`
                    <tr>
                        <td>${review.date}</td>
                        <td>${review.review}</td>
                    </tr>
                    `);
                });

                $('#reviewModal').modal('show');
                } else {
                alert('Failed to fetch reviews');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('An error occurred while fetching reviews');
            }
            });
        });
    });
</script>

@endsection