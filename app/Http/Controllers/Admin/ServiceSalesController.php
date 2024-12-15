<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function getservice(Request $request)
    {
        $serviceDtl = Service::where('id', '=', $request->service)->first();

        if(empty($serviceDtl)){
            return response()->json(['status'=> 303,'message'=>"No data found"]);
        }else{
            
            return response()->json(['status'=> 300,'name'=>$serviceDtl->name,'product_id'=>$serviceDtl->id, 'price'=>$serviceDtl->price]);
            
        }

    }

    public function salesServiceRequestStore(Request $request)
    {
        // if(empty($request->name)){
        //     $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Name\" field..!</b></div>";
        //     return response()->json(['status'=> 303,'message'=>$message]);
        //     exit();
        // }

        
        $data = $request->all();
        return response()->json(['status'=> 300,'message'=>$data]);

        // try{

        //         $service = new Service();
        //         $service->code = $request->code;
        //         $service->name = $request->name;
        //         $service->price = $request->price;
        //         $service->capacity = $request->capacity;
        //         $service->created_by= Auth::user()->id;

        //         if ($service->save()) {
                    
        //             $message ="<div class='alert alert-success' style='color:white'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Service Create Successfully.</b></div>";
        //             return response()->json(['status'=> 300,'message'=>$message]);
        //         }

        // }catch (\Exception $e) {

        //     return response()->json([
        //         'status' => 500, 
        //         'message' => 'Server Error!!',
        //         'error' => $e->getMessage() 
        //     ], 500);
        // }

    }
}
