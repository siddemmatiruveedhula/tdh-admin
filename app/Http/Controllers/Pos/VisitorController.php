<?php

namespace App\Http\Controllers\Pos;

use Auth;
use App\Models\Storage;
use App\Models\Vehicle;
use App\Models\Visitor;
use App\Models\Supplier;
use App\Models\StorageType;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class VisitorController extends Controller
{
    public function All()
    {
        $visitors = Visitor::latest()->get();
        return view('backend.visitors.visitor_all', compact('visitors'));
    } // End Method 



    public function changeStatus(Request $request, $id)
    {

        $vehicle = Visitor::findOrFail($id);
        // $message = "Updated Successfully";

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
    public function Edit($id)
    {

        $visitor = Visitor::findOrFail($id);
        return view('backend.visitors.visitor_edit', compact('visitor'));
    } // End Method 

    public function Update(Request $request)
    {

        $visitor_id = $request->id;

        $visitor = Visitor::findOrFail($visitor_id);
        $visitor->visitor_name       = $request->visitor_name;
        $visitor->visitor_phone      = $request->visitor_phone;
        $visitor->visitor_city      = $request->visitor_city;
        $visitor->card_no      = $request->card_no;
        $visitor->card_submit      = $request->card_submit;
        $visitor->visitor_from      = $request->visitor_from;
        $visitor->agenda      = $request->agenda;
        $visitor->whom_to_meet      = $request->whom_to_meet;
        $visitor->check_out_time      = $request->check_out_time;
        $visitor->check_in_time      = $request->check_in_time;
        if ($request->check_in_date) {
            $checkInTime = Carbon::parse($request->check_in_date)->format("Y-m-d");
            $visitor->check_in_date = $checkInTime;
        } else {
            $visitor->check_in_date = $request->check_in_date;
        }
        if ($request->check_out_date) {
            $checkOutTime = Carbon::parse($request->check_out_date)->format("Y-m-d H:i");
            $visitor->check_out_date = $checkOutTime;
        } else {
            $visitor->check_out_date = $request->check_out_date;
        }
        $visitor->created_by = Auth::user()->id;

        $visitor->save();


        $notification = array(
            'message' => 'Visitor Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('visitor.all')->with($notification);
    }
}
