<?php

namespace App\Http\Controllers\Pos;

use Carbon\Carbon;
use App\Models\Area;
use App\Models\Variant;
use App\Models\StorageType;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehicleTypeController extends Controller
{
    public function All()
    {
        $vehicleTypes = VehicleType::latest()->get();
        return view('backend.configuration.vehicle_type_all', compact('vehicleTypes'));
    } // End Method


    public function changeStatus(Request $request, $id)
    {

        $vehicleType = VehicleType::findOrFail($id);
        // $message = "Updated Successfully";

        if ($vehicleType->status == 1) {
            $vehicleType->status = 0;
            $vehicleType->save();
            $message = "Inactive Successfully";
        } else {
            $vehicleType->status = 1;
            $vehicleType->save();
            $message = "Active Successfully";
        }
        return response()->json($message);
    }
    public function Add()
    {
        return view('backend.configuration.vehicle_type_add');
    } // End Method 



    public function Store(Request $request)
    {

        $rules = [
            'name' => 'required|unique:vehicle_types,name',
        ];
        $customMessages = [
            'name.required' => trans('Vehicle Type is required'),
            'name.unique' => trans('Vehicle Type already taken'),
        ];
        $this->validate($request, $rules, $customMessages);

        VehicleType::insert([
            'name' => $request->name,
            'status' => $request->status,
            // 'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Vehicle Type Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('vehicle.all')->with($notification);
    } // End Method 


    public function Edit($id)
    {

        $vehicleType = VehicleType::findOrFail($id);
        return view('backend.configuration.vehicle_type_edit', compact('vehicleType'));
    } // End Method 


    public function Update(Request $request)
    {

        $vehicle_id = $request->id;

        $rules = [
            'name' => 'required|unique:vehicle_types,name,' . $vehicle_id,
        ];
        $customMessages = [
            'name.required' => trans('Vehicle Type is required'),
            'name.unique' => trans('Vehicle Type already taken'),
        ];
        $this->validate($request, $rules, $customMessages);

        $vehicleType = VehicleType::findOrFail($vehicle_id);
        $vehicleType->name  =  $request->name;
        $vehicleType->status  =  $request->status;

        $vehicleType->save();
        $notification = array(
            'message' => 'Vehicle Type Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('vehicle.all')->with($notification);
    } // End Method 

}
