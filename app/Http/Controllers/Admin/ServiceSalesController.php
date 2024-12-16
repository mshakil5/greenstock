<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ServiceSalesController extends Controller
{
    public function salesService()
    {
        return view('admin.salesService.create');
    }

    public function salesServiceRequest()
    {
        return view('admin.salesService.request');
    }

    public function processingServiceRequest($id)
    {
        
        $serviceRequest = ServiceRequest::where('id', $id)->first();
        return view('admin.salesService.processing', compact('serviceRequest'));
    }

    public function getservice(Request $request)
    {
        $serviceDtl = Service::where('id', '=', $request->service)->first();

        if(empty($serviceDtl)){
            return response()->json(['status'=> 303,'message'=>"No data found"]);
        }else{
            
            return response()->json(['status'=> 300,'name'=>$serviceDtl->name,'product_id'=>$serviceDtl->id, 'price'=>$serviceDtl->price]);
            
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

        $invoiceNo = $this->generateInvoiceNo();
        
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
                $service->customer_phone = $request->customer_phone;
                $service->address = $request->address;
                $service->date = $request->date;
                $service->payment_type = $request->salestype;
                $service->user_id = $request->staff;
                $service->warranty = $request->warranty;
                $service->inputer = Auth::user()->id;
                $service->branch_id = Auth::user()->branch_id;
                $service->invoice_no = $invoiceNo;
                $service->document = $imagePath;
                $service->created_by= Auth::user()->id;

                if ($service->save()) {
                    
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

    public function getServiceRequest()
    {
        
        $data = ServiceRequest::orderby('id', 'DESC')->get();
        return view('admin.salesService.allrequest',compact('data'));
    }
}
