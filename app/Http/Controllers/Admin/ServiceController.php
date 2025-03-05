<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Branch;
use App\Models\Service;
use App\Models\ServiceDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function addService()
    {
        $products = Product::where('branch_id', Auth::user()->branch_id)->orderby('id','DESC')->get();
        $branches = Branch::where('id', Auth::user()->branch_id)->get();
        return view('admin.service.create', compact('products', 'branches'));
    }


    public function storeService(Request $request)
    {
        if(empty($request->name)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Name\" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

            try{
                $service = new Service();
                $service->code = $request->code;
                $service->name = $request->name;
                $service->price = $request->price;
                $service->capacity = $request->capacity;
                $service->created_by= Auth::user()->id;

            if ($service->save()) {

                if (isset($request->product_id)) {

                    foreach($request->input('product_id') as $key => $value)
                    {

                        $purchasehistry = new ServiceDetail();
                        $purchasehistry->branch_id = Auth::user()->branch_id;
                        $purchasehistry->service_id = $service->id;
                        $purchasehistry->product_id = $request->get('product_id')[$key];
                        $purchasehistry->quantity = $request->get('quantity')[$key];
                        $purchasehistry->save();

                    }
                }

                

                $message ="<div class='alert alert-success' style='color:white'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Service Create Successfully.</b></div>";
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

    public function allService()
    {
        $data = Service::with('serviceDetail')->orderby('id', 'DESC')->get();
        // dd($data);
        return view('admin.service.manageall', compact('data'));
    }

    public function serviceEdit($id)
    {
        $products = Product::where('branch_id', Auth::user()->branch_id)->orderby('id','DESC')->get();
        $branches = Branch::where('id', Auth::user()->branch_id)->get();
        
        $data = Service::with('serviceDetail')->where('id', $id)->first();
        return view('admin.service.edit', compact('products', 'branches','data'));
    }

    public function updateService(Request $request)
    {
        if(empty($request->name)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Name\" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

            try{
                $service = Service::find($request->service_id);
                $service->code = $request->code;
                $service->name = $request->name;
                $service->price = $request->price;
                $service->capacity = $request->capacity;
                $service->created_by= Auth::user()->id;

            if ($service->save()) {

                if (isset($request->product_id)) {

                    foreach($request->input('product_id') as $key => $value)
                    {
                        $existingOrderDetails = $service->serviceDetail->pluck('id')->toArray();
                        $requestOrderDetails = $request->input('service_detail_id', []); 

                        $toDelete = array_diff($existingOrderDetails, $requestOrderDetails);
                        if (!empty($toDelete)) {
                            ServiceDetail::whereIn('id', $toDelete)->delete();
                        }

                        if (isset($request->input('service_detail_id')[$key])) {
                            $purchasehistry = ServiceDetail::find($request->input('service_detail_id')[$key]);
                            $purchasehistry->branch_id = Auth::user()->branch_id;
                            $purchasehistry->service_id = $service->id;
                            $purchasehistry->product_id = $request->get('product_id')[$key];
                            $purchasehistry->quantity = $request->get('quantity')[$key];
                            $purchasehistry->save();
                        } else {
                            $purchasehistry = new ServiceDetail();
                            $purchasehistry->branch_id = Auth::user()->branch_id;
                            $purchasehistry->service_id = $service->id;
                            $purchasehistry->product_id = $request->get('product_id')[$key];
                            $purchasehistry->quantity = $request->get('quantity')[$key];
                            $purchasehistry->save();
                        }
                        

                        

                    }
                }

                

                $message ="<div class='alert alert-success' style='color:white'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Service Create Successfully.</b></div>";
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



}
