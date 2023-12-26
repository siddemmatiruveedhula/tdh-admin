<?php

namespace App\Http\Controllers\Pos;

use Carbon\Carbon;
use App\Models\Area;
use App\Models\Variant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VariantController extends Controller
{
    public function All()
    {
        $variants = Variant::latest()->get();
        return view('backend.configuration.variant_all', compact('variants'));
    } // End Method


    public function changeStatus(Request $request, $id)
    {

        $Variant = Variant::findOrFail($id);
        $message = "Updated Successfully";

        if ($Variant->status == 1) {
            $Variant->status = 0;
            $Variant->save();
            $message = "Inactive Successfully";
        } else {
            $Variant->status = 1;
            $Variant->save();
            $message = "Active Successfully";
        }
        return response()->json($message);
    }

    public function Add()
    {
        return view('backend.configuration.variant_add');
    } // End Method 



    public function Store(Request $request)
    {

        $rules = [
            'name' => 'required|unique:variants,name',
        ];
        $customMessages = [
            'name.required' => trans('Name is required'),
            'name.unique' => trans('Name already taken'),
        ];
        $this->validate($request, $rules, $customMessages);

        Variant::insert([
            'name' => $request->name,
            'status' => $request->status,
            // 'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Variant Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('variant.all')->with($notification);
    } // End Method 


    public function Edit($id)
    {

        $variant = Variant::findOrFail($id);
        return view('backend.configuration.variant_edit', compact('variant'));
    } // End Method 


    public function Update(Request $request)
    {

        $area_id = $request->id;

        $rules = [
            'name' => 'required|unique:variants,name,' . $area_id,
        ];
        $customMessages = [
            'name.required' => trans('Name is required'),
            'name.unique' => trans('Name already taken'),
        ];
        $this->validate($request, $rules, $customMessages);

        Variant::findOrFail($area_id)->update([
            'name' => $request->name,
            'status' => $request->status,
            // 'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Variant Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('variant.all')->with($notification);
    } // End Method 
}
