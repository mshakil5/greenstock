<div class="modal fade" id="newCustomerModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header alert alert-success" style="text-align: left;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Document</h4>
            </div>
            <div class="modal-body">
                <div class="row p-3">
                </div>

                <div class="form-group row">
                    <div class="col-sm-12">
                        <div class="button-container" style="display: flex; justify-content: center; gap: 10px; margin-top: 10px;">
                            <img src="{{asset('images/document/'. $data->document)}}" width="450px" alt="">
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="newProductModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header alert alert-success" style="text-align: left;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Ordered Product List</h4>
            </div>
            <div class="modal-body">
                <div class="row p-3">
                </div>

                <div class="form-group row">
                    <div class="col-sm-12">
                        <table  class="table table-hover table-responsive " width="100%" id="supplierTBL">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Note</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($companyProduct as $data)
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
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            
                            </tfoot>
                        
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>