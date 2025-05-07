<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssignStaff;
use App\Models\CompanyProduct;
use App\Models\Order;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;

class ServiceSalesController extends Controller
{
    public function salesService()
    {
        return view('admin.salesService.create');
    }

    public function generateInvoiceNumber()
    {
        // Get the current year and month
        $year = Carbon::now()->format('y');
        $month = str_pad(Carbon::now()->month, 2, '0', STR_PAD_LEFT);

        // Define the prefix
        $prefix = "GT/{$year}_{$month}_";

        // Get the last invoice number for the current year and month
        $lastInvoice = DB::table('orders')
            ->where('invoiceno', 'LIKE', "{$prefix}%")
            ->orderBy('invoiceno', 'desc')
            ->first();

        // Extract the last number and increment it
        $lastNumber = $lastInvoice ? (int)substr($lastInvoice->invoiceno, -5) : 0;
        $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

        // Combine prefix with the new number
        return $prefix . $newNumber;
    }

    public function salesServiceRequest()
    {
        
        $invoiceNo = $this->generateInvoiceNumber();
        return view('admin.salesService.request', compact('invoiceNo'));
    }

    public function processingServiceRequest($id)
    {
        $serviceRequest = ServiceRequest::with('order')->where('id', $id)->first();
        return view('admin.salesService.processing', compact('serviceRequest'));
    }

    public function getservice(Request $request)
    {
        $serviceDtl = Service::where('id', '=', $request->service)->first();

        if(empty($serviceDtl)){
            return response()->json(['status'=> 303,'message'=>"No data found"]);
        }else{
            $serviceProducts = ServiceDetail::where('service_id', $serviceDtl->id)->get();

            $prop = '';

            foreach ($serviceProducts as $rate){
                // <!-- Single Property Start -->
                $prop.= '<tr>
                            <td class="text-center">
                                <input type="text" class="form-control" name="spproductname[]" value="'.$rate->product->productname.'"><input type="hidden" class="form-control" name="spproduct_id[]" value="'.$rate->product_id.'"<input type="hidden" class="form-control" name="servicedtlid[]" value="'.$rate->id.'">
                            </td>
                            <td class="text-center">
                                 <input type="number" class="form-control" name="spquantity[]" value="'.$rate->quantity.'">
                            </td>
                            <td class="text-center">
                                <div style="
                                    color: white; 
                                    user-select: none; 
                                    padding: 5px; 
                                    background: red; 
                                    width: 45px; 
                                    display: flex; 
                                    align-items: center; 
                                    margin-right: 5px; 
                                    justify-content: center; 
                                    border-radius: 4px;
                                    left: 4px;
                                    top: 81px;" 
                                    onclick="removeRow(event)">
                                    X
                                </div>
                            </td>
                        </tr>';
            }



            return response()->json(['status'=> 300,'name'=>$serviceDtl->name,'service_id'=>$serviceDtl->id, 'price'=>$serviceDtl->price, 'serviceDtl'=>$prop]);
            
        }

    }

    public function generateInvoiceNo()
    {
        // Get the current year and month
        $yearMonth = date('Ym'); // e.g., 202412

        // Get the last invoice for the current year and month
        $lastInvoice = DB::table('service_requests')
            ->where('invoice_no', 'like', $yearMonth . '%') // Filter invoices of the current year and month
            ->orderBy('invoice_no', 'desc')
            ->first();

        // Determine the next sequence number
        $newSequence = $lastInvoice
            ? intval(substr($lastInvoice->invoice_no, -4)) + 1 // Extract last 4 digits and increment
            : 1;

        // Format the sequence as a 4-digit number
        $formattedSequence = str_pad($newSequence, 4, '0', STR_PAD_LEFT); // e.g., 0001

        // Combine year, month, and sequence
        $invoiceNo = $yearMonth . $formattedSequence;

        return $invoiceNo; // Example output: 2024120001
    }

    public function salesServiceRequestStore(Request $request)
    {
        

        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'staff' => 'required|string|max:255',
            'document' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            $errorMessage = "<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>" . implode("<br>", $validator->errors()->all()) . "</b></div>";
            return response()->json(['status' => 400, 'message' => $errorMessage]);
        }

        $imagePath = null;
        if ($request->hasFile('document')) {
            $image = $request->file('document');
            $randomName = mt_rand(10000000, 99999999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/document'), $randomName);
            $imagePath = $randomName;
        }

        $invoiceNo = $this->generateInvoiceNumber();
        try{

                $service = new ServiceRequest();
                $service->customer_name = $request->customer_name;
                $service->company_id = $request->company_id;
                $service->bill_no = $request->bill_no;
                $service->invoice_no = $invoiceNo;
                $service->customer_phone = $request->customer_phone;
                $service->address = $request->address;
                $service->product_desc = $request->product_desc;
                $service->date = $request->date;
                $service->user_id = $request->staff;
                $service->warranty = $request->warranty;
                $service->product_model = $request->product_model;
                $service->product_serial = $request->product_serial;
                $service->product_capacity = $request->product_capacity;
                $service->inputer = Auth::user()->id;
                $service->branch_id = Auth::user()->branch_id;
                $service->document = $imagePath;
                $service->created_by= Auth::user()->id;

                if ($service->save()) {

                    $order = new Order();
                    $order->bill_no = $request->bill_no;
                    $order->invoiceno = $request->invoice_no;
                    $order->service_request_id = $service->id;
                    $order->save();
                    
                    $message ="<div class='alert alert-success' style='color:white'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Request assign Successfully.</b></div>";
                    return response()->json(['status'=> 300,'message'=>$message]);
                }

        }catch (\Exception $e) {

            return response()->json([
                'status' => 500, 
                'message' => 'Server Error!!',
                'error' => $e->getMessage() 
            ], 500);
        }

    }

    public function getServiceRequest(Request $request)
    {

        if ($request->ajax()) {
            $allInvoice = ServiceRequest::where('branch_id', auth()->user()->branch_id)->get();

        return Datatables::of($allInvoice)
            ->addIndexColumn()
            ->editColumn('assign_staff', function ($invoice) {
                return $invoice->user->name ?? 'N/A';
            })
            ->addColumn('company', function ($invoice) {
                return $invoice->company->name ?? 'N/A';
            })
            ->editColumn('status', function ($invoice) {
                $statuses = [
                    0 => 'Pending',
                    1 => 'Processing',
                    2 => 'Completed',
                    3 => 'Cancelled'
                ];
            
                $options = '';
                foreach ($statuses as $key => $label) {
                    $selected = $invoice->status == $key ? 'selected' : '';
                    $disabled = $invoice->status == 2 ? 'disabled' : '';
                    $options .= "<option value='{$key}' {$selected} {$disabled}>{$label}</option>";
                }
            
                return "<select class='form-control status-dropdown' data-order-id='{$invoice->id}' {$disabled}>$options</select>";
            })
            ->addColumn('created_at', function ($invoice) {
                return "<span data-title='" . Carbon::parse($invoice->created_at)->format('h:m A') . "'>" . Carbon::parse($invoice->created_at)->format('d M Y') . "</span>";
            })
            ->addColumn('action', function ($invoice) {
                $btn = '<div class="table-actions text-center">';

                    $btn .= '<a href="' . route('admin.serviceSales.edit', $invoice->id) . '"  class="btn btn-warning btn-xs ms-1" style="margin: 2px;">
                        <span title="View">View</span>
                    </a>';

                    $btn .= '<a href="' . route('customer.invoice.print', $invoice->id) . '" class="btn btn-success btn-xs print-window" target="_blank">
                        <span title="Print Invoice">Print</span>
                    </a>';

                    $btn .= '<a href="' . route('admin.orderproduct', $invoice->id) . '" class="btn btn-primary btn-xs print-window" target="_blank">
                                <span title="Order">Order</span>
                            </a>';


                    $btn .= '<button type="button" class="btn btn-info btn-xs reviewModal" data-toggle="modal" data-target="#reviewModal" data-serviceid="' . $invoice->id . '">
                                <span title="Show Review">Review</span>
                            </button>';




                    // if($invoice->status == 1){
                    //     $btn .= '<a href="' . route('admin.processingService', $invoice->id) . '" class="btn btn-primary btn-xs print-window" target="_blank">
                    //         <span title="View">View</span>
                    //     </a>';
                    // }

                    

                
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['created_at', 'action','status'])
            ->make(true);
        }
        
        $data = ServiceRequest::orderby('id', 'DESC')->get();
        return view('admin.salesService.allrequest',compact('data'));
    }

    // onchange change status Service Request

    public function changeServiceStatus(Request $request)
    {
        $serviceRequest = ServiceRequest::find($request->orderId);
        $serviceRequest->status = $request->status;
        $serviceRequest->save();

        $data = new AssignStaff();
        $data['service_request_id'] = $request->orderId;
        $data['user_id'] = Auth::user()->id;
        $data['note'] = $request->note;
        $data['review'] = $request->note;
        $data['status'] = $request->status;
        $data['date'] = date('Y-m-d');
        $data->save();

        return response()->json(['status' => 200, 'message' => 'Status updated successfully']);
    }

    public function getServiceStaffReview(Request $request)
    {
        $serviceRequest = ServiceRequest::find($request->serviceid);
        $data = AssignStaff::where('service_request_id', $request->serviceid)->get();
        return response()->json(['status' => 200, 'message' => 'Status updated successfully', 'data' => $data, 'serviceRequest' => $serviceRequest]);
    }

    

    public function orderNewProduct($id)
    {
        $serviceRequest = ServiceRequest::where('id', $id)->first();
        return view('admin.salesService.orderproduct', compact('serviceRequest'));
    }

    public function orderNewProductStore(Request $request)
    {
        $request->validate([
            'service_request_id' => 'required',
            'name' => 'required',
            'quantity' => 'required',
            'date' => 'required',
        ]);
        $data = new CompanyProduct();
        $data['service_request_id'] = $request->service_request_id;
        $data['name'] = $request->name;
        $data['quantity'] = $request->quantity;
        $data['date'] = $request->date;
        $data['status'] = $request->status;
        $data['note'] = $request->note;
        $data->save();

        Session::put('success', 'Data Saved Successfully !');
        return back();
    }

    public function orderNewProductUpdate(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'quantity' => 'required',
            'date' => 'required',
        ]);
        $data = CompanyProduct::find($request->requestid);
        $data['name'] = $request->name;
        $data['quantity'] = $request->quantity;
        $data['date'] = $request->date;
        $data['status'] = $request->status;
        $data['note'] = $request->note;
        $data->save();

        Session::put('success', 'Data Has Been Updated Successfully !');
        return back();
    }

    public function orderAssignStaff($id)
    {
        $data = AssignStaff::where('service_request_id', $id)->get();
        $serviceRequest = ServiceRequest::where('id', $id)->first();

        $users = User::where('type', 1)->get();
        return view('admin.salesService.assignStaff', compact('data','serviceRequest','users'));
    }

    public function orderAssignStaffStore(Request $request)
    {
        
        $request->validate([
            'service_request_id' => 'required',
            'user_id' => 'required',
            'note' => 'required',
            'date' => 'required|date',
        ], [
            'service_request_id.required' => 'The service request ID is mandatory.',
            'user_id.required' => 'The staff name field is required.',
            'note.required' => 'Please provide a working details.',
            'date.required' => 'The date is required.',
            'date.date' => 'Please provide a valid date.',
        ]);



        $data = new AssignStaff();
        $data['user_id'] = $request->user_id;
        $data['service_request_id'] = $request->service_request_id;
        $data['date'] = $request->date;
        $data['note'] = $request->note;
        $data['review'] = $request->note;
        $data->save();

        Session::put('success', 'Data Saved Successfully !');
        return back();
    }

    public function assignStaffUpdate(Request $request)
    {

        $request->validate([
            'note' => 'required',
            'date' => 'required|date',
        ], [
            'note.required' => 'Please provide a working details.',
            'date.required' => 'The date is required.',
            'date.date' => 'Please provide a valid date.',
        ]);

        $data = AssignStaff::find($request->requestid);
        $data['date'] = $request->date;
        $data['user_id'] = $request->user_id;
        $data['note'] = $request->note;
        $data->save();

        Session::put('success', 'Data Has Been Updated Successfully !');
        return back();
    }



}
