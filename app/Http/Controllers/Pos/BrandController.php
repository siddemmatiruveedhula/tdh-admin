<?php

namespace App\Http\Controllers\Pos;

use Carbon\Carbon;
use App\Models\Area;
use App\Models\Brand;
use App\Models\Variant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    public function All()
    {
        $brands = Brand::latest()->get();
        return view('backend.configuration.brand_all', compact('brands'));
    } // End Method


    public function changeStatus(Request $request, $id)
    {

        $brand = Brand::findOrFail($id);
        $message = "Updated Successfully";

        if ($brand->status == 1) {
            $brand->status = 0;
            $brand->save();
            $message = "Inactive Successfully";
        } else {
            $brand->status = 1;
            $brand->save();
            $message = "Active Successfully";
        }
        return response()->json($message);
    }

    public function Add()
    {
        return view('backend.configuration.brand_add');
    } // End Method 



    public function Store(Request $request)
    {

        $rules = [
            'name' => 'required|unique:brands,name',
        ];
        $customMessages = [
            'name.required' => trans('Name is required'),
            'name.unique' => trans('Name already taken'),
        ];
        $this->validate($request, $rules, $customMessages);

        Brand::insert([
            'name' => $request->name,
            'status' => $request->status,
            // 'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Brand Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('brand.all')->with($notification);
    } // End Method 


    public function Edit($id)
    {

        $brand = Brand::findOrFail($id);
        return view('backend.configuration.brand_edit', compact('brand'));
    } // End Method 


    public function Update(Request $request)
    {

        $brand_id = $request->id;
        $rules = [
            'name' => 'required|unique:brands,name,' . $brand_id,
        ];
        $customMessages = [
            'name.required' => trans('Name is required'),
            'name.unique' => trans('Name already taken'),
        ];
        $this->validate($request, $rules, $customMessages);

        Brand::findOrFail($brand_id)->update([
            'name' => $request->name,
            'status' => $request->status,
            // 'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Brand Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('brand.all')->with($notification);
    } // End Method 
}
