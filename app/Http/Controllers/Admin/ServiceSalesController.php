<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
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

        try{

                $service = new ServiceRequest();
                $service->customer_name = $request->customer_name;
                $service->company_id = $request->company_id;
                $service->bill_no = $request->bill_no;
                $service->invoice_no = $request->invoice_no;
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
            ->addColumn('status', function ($invoice) {
                if($invoice->status == 0){
                    return 'Pending';
                }elseif($invoice->status == 1){
                    return 'Processing';
                }elseif($invoice->status == 2){
                    return 'Completed';
                }elseif($invoice->status == 3){
                    return 'Cancelled';
                }
            })
            ->addColumn('created_at', function ($invoice) {
                return "<span data-title='" . Carbon::parse($invoice->created_at)->format('h:m A') . "'>" . Carbon::parse($invoice->created_at)->format('d M Y') . "</span>";
            })
            ->addColumn('action', function ($invoice) {
                $btn = '<div class="table-actions text-center">';

                    $btn .= '<a href="#" class="btn btn-warning btn-xs ms-1" style="margin: 2px;">
                        <i class="fa fa-pencil" aria-hidden="true"></i><span title="Edit">Edit</span>
                    </a>';

                    $btn .= '<a href="' . route('customer.invoice.print', $invoice->id) . '" class="btn btn-success btn-xs print-window" target="_blank">
                        <span title="Print Invoice">Print</span>
                    </a>';

                    if($invoice->status == 1){
                        $btn .= '<a href="' . route('admin.processingService', $invoice->id) . '" class="btn btn-primary btn-xs print-window" target="_blank">
                            <span title="View">View</span>
                        </a>';
                    }

                    

                
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['created_at', 'action'])
            ->make(true);
        }
        
        $data = ServiceRequest::orderby('id', 'DESC')->get();
        return view('admin.salesService.allrequest',compact('data'));
    }
}
