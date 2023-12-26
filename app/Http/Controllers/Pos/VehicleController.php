<?php

namespace App\Http\Controllers\Pos;

use Auth;
use App\Models\Storage;
use App\Models\Vehicle;
use App\Models\Supplier;
use App\Models\StorageType;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use App\Models\Transportation;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class VehicleController extends Controller
{
    public function All()
    {
        $vehicles = Vehicle::latest()->get();
        return view('backend.vehicles.vehicle_all', compact('vehicles'));
    } // End Method 



    public function changeStatus(Request $request, $id)
    {

        $vehicle = Vehicle::findOrFail($id);

        if ($vehicle->status == 1) {
            $vehicle->status = 0;
            $vehicle->save();
            $message = "Inactive Successfully";
        } else {
            $vehicle->status = 1;
            $vehicle->save();
            $message = "Active Successfully";
        }
        return response()->json($message);
    }

    public function Add()
    {
        $vehicleTypes = VehicleType::active()->latest()->get();
        return view('backend.vehicles.vehicle_add', compact('vehicleTypes'));
    } // End Method 

    public function Store(Request $request)
    {


        $vehicle = new Vehicle();
        $vehicle->vehicle_type_id   = $request->vehicle_type_id;
        $vehicle->driver_name       = $request->driver_name;
        $vehicle->driver_phone      = $request->driver_phone;
        $vehicle->check_in_time     = $request->check_in_time;

        $vehicle->save();


        $notification = array(
            'message' => 'Vehicle Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('vehicle.all')->with($notification);
    } // End Method 


    public function Edit($id)
    {
        $vehicleTypes = VehicleType::active()->latest()->get();
        $transportations = Transportation::active()->latest()->get();
        $vehicle = Vehicle::findOrFail($id);
        // dd($vehicle);
        return view('backend.vehicles.vehicle_edit', compact('vehicle', 'vehicleTypes','transportations'));
    } // End Method 

    public function Update(Request $request)
    {

        $vehicle_id = $request->id;


        $vehicle = Vehicle::findOrFail($vehicle_id);
        $vehicle->vehicle_type_id   = $request->vehicle_type_id;
        $vehicle->transportation_id   = $request->transportation_id;
        $vehicle->vehicle_number    = $request->vehicle_number;
        $vehicle->driver_name       = $request->driver_name;
        $vehicle->driver_phone      = $request->driver_phone;
        $vehicle->check_out_time      = $request->check_out_time;
        $vehicle->check_in_time      = $request->check_in_time;
        $checkInTime                = Carbon::parse($request->check_in_date)->format("Y-m-d");
        $vehicle->check_in_date     = $checkInTime;
        $checkOutTime               = Carbon::parse($request->check_out_date)->format("Y-m-d");
        $vehicle->check_out_date    = $checkOutTime;
        $vehicle->created_by        = Auth::user()->id;
        $vehicle->save();


        $notification = array(
            'message' => 'Vehicle Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('vehicles.all')->with($notification);
    } // End Method 


    public function Delete($id)
    {

        Storage::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Storage Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method 


}
