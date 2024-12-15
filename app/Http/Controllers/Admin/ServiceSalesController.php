<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

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
}
