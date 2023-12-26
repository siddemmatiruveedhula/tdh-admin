<?php

namespace App\Http\Controllers\Pos;

use Carbon\Carbon;
use App\Models\Area;
use App\Models\Variant;
use App\Models\StorageType;
use Illuminate\Http\Request;
use App\Models\Transportation;
use App\Http\Controllers\Controller;

class TransportationController extends Controller
{
    public function All()
    {
        $transportations = Transportation::latest()->get();
        return view('backend.configuration.transportation_all', compact('transportations'));
    } // End Method


    public function changeStatus(Request $request, $id)
    {

        $transportation = Transportation::findOrFail($id);
        // $message = "Updated Successfully";

        if ($transportation->status == 1) {
            $transportation->status = 0;
            $transportation->save();
            $message = "Inactive Successfully";
        } else {
            $transportation->status = 1;
            $transportation->save();
            $message = "Active Successfully";
        }
        return response()->json($message);
    }
    public function Add()
    {
        return view('backend.configuration.transportation_add');
    } // End Method 



    public function Store(Request $request)
    {

        $rules = [
            'name' => 'required|unique:transportations,name',
        ];
        $customMessages = [
            'name.required' => trans('Transportation name is required'),
            'name.unique' => trans('Transportation name already taken'),
        ];
        $this->validate($request, $rules, $customMessages);

        Transportation::insert([
            'name' => $request->name,
            'status' => $request->status,
            // 'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Transportation Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('transportation.all')->with($notification);
    } // End Method 


    public function Edit($id)
    {

        $transportation = Transportation::findOrFail($id);
        return view('backend.configuration.transportation_edit', compact('transportation'));
    } // End Method 


    public function Update(Request $request)
    {

        $vehicle_id = $request->id;

        $rules = [
            'name' => 'required|unique:transportations,name,' . $vehicle_id,
        ];
        $customMessages = [
            'name.required' => trans('Transportation name is required'),
            'name.unique' => trans('Transportation name already taken'),
        ];
        $this->validate($request, $rules, $customMessages);

        $transportation = Transportation::findOrFail($vehicle_id);
        $transportation->name  =  $request->name;
        $transportation->status  =  $request->status;

        $transportation->save();
        $notification = array(
            'message' => 'Transportation Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('transportation.all')->with($notification);
    } // End Method 

}
