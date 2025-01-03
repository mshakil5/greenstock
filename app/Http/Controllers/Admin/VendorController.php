<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Vendor;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public function add_vendor()
    {
        
        return view('admin.vendor.form');
    }

    public function save_type(Request $request)
    {
        $data = new Type;
        $data->name = $request->type;
        $data->save();
    }

    public function save_vendor(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'nullable|max:14',
        ]);
        $data = new Vendor;
        $data['branch_id'] = Auth::user()->branch_id;
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['vat_reg'] = $request->vat_reg;
        $data['address'] = $request->address;
        $data['companyinfo'] = $request->company;
        $data->save();

        Session::put('success', 'Vendor Information Has Been Saved Successfully !');
        return back();
    }

    public function update_vendor(Request $request)
    {

        $request->validate([
            'vendorname' => 'required',
            'vendoremail' => 'required',
            'vendorphone' => 'nullable|max:14',
        ]);
        $data = Vendor::find($request->vendorid);
        $data['name'] = $request->vendorname;
        $data['email'] = $request->vendoremail;
        $data['phone'] = $request->vendorphone;
        $data['vat_reg'] = $request->vendorvatreg;
        $data['address'] = $request->vendoraddress;
        $data['companyinfo'] = $request->vendorcinfo;
        $data->save();

        Session::put('success', 'Vendor Information Has Been Updated Successfully !');
        return back();
    }

    
}
