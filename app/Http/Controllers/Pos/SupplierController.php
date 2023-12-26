<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Auth;
use Illuminate\Support\Carbon;

class SupplierController extends Controller
{
    public function SupplierAll()
    {
        // $suppliers = Supplier::all();
        $suppliers = Supplier::latest()->get();
        return view('backend.supplier.supplier_all', compact('suppliers'));
    } // End Method 


    public function SupplierAdd()
    {
        return view('backend.supplier.supplier_add');
    } // End Method 


    public function SupplierStore(Request $request)
    {

        $rules = [
            'name' => 'required|unique:suppliers',
            'email' => 'required|unique:suppliers',
        ];
        $customMessages = [
            'name.unique' => trans('Name Already exist'),
            'email.unique' => trans('Email Already exist'),

        ];

        $this->validate($request, $rules, $customMessages);

        Supplier::insert([
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'address' => $request->address,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Organization Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('supplier.all')->with($notification);
    } // End Method 


    public function SupplierEdit($id)
    {

        $supplier = Supplier::findOrFail($id);
        return view('backend.supplier.supplier_edit', compact('supplier'));
    } // End Method 

    public function SupplierUpdate(Request $request)
    {

        $sullier_id = $request->id;

        $rules = [
            'name' => 'required|unique:suppliers,name,' . $sullier_id,
            'email' => 'required|unique:suppliers,email,' . $sullier_id,
        ];
        $customMessages = [
            'name.unique' => trans('Name Already exist'),
            'email.unique' => trans('Email Already exist'),

        ];

        $this->validate($request, $rules, $customMessages);

        Supplier::findOrFail($sullier_id)->update([
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'address' => $request->address,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Organization Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('supplier.all')->with($notification);
    } // End Method 


    public function SupplierDelete($id)
    {

        Supplier::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Organization Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method 

    public function changeStatus(Request $request, $id)
    {

        $supplier = Supplier::findOrFail($id);
        $message = "Updated Successfully";

        if ($supplier->status == 1) {
            $supplier->status = 0;
            $supplier->save();
            $message = "Inactive Successfully";
        } else {
            $supplier->status = 1;
            $supplier->save();
            $message = "Active Successfully";
        }

        return response()->json($message);
    }
}
