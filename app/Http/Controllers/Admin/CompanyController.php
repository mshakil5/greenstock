<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Company::orderBy('id', 'desc')
               ->get();
            return Datatables::of($data)->make(true);
        }
        return view('admin.companies.index');
    }

    public function store(Request $request)
    {

        if (empty($request->name)) {
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Name Field Is Required..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
  
          }

    
        $request->validate([
            'name' => 'required',
        ]);
        $customer = new Company();
        $customer->name = $request->name;
        $customer->save();

        return response()->json([
            'status' => 201,
            'message' => 'Customer created successfully.',
            'data' => $customer
        ], 201);


    }

    public function edit($id)
    {
        $customerDtl = Company::where('id', '=', $id)->first();
        if(empty($customerDtl)){
            return response()->json(['status'=> 303,'message'=>"No data found"]);
        }else{
            return response()->json(['status'=> 300,'customername'=>$customerDtl->name]);
        }
    }

    public function update(Request $request, $id)
    {
        $customer = Company::find($id);
        $request->validate([
            'name' => 'required',
        ]);
        $customer->name = $request->name;
        $customer->save();
        return response()->json([
            'status' => 200,
            'message' => 'Customer updated successfully.',
            'data' => $customer
        ], 200);
    }

    public function changeStatus($id)
    {
        $customer = Company::find($id);
        if($customer->status){
            $customer->status = 0;
        }else{
            $customer->status=1;
        }
        $customer->save();
        return $customer;
    }

    public function activeCustomer(){
        $data = Company::where('status',1)->get();
        return $data;
    }
}
