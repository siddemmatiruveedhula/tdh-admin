<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;
// use Response;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class LeaveTypeController extends Controller
{
    public function LeaveTypeAll()
    {
        $leavetypes = LeaveType::latest()->get();
        return view('backend.configuration.leavetype_all', compact('leavetypes'));
    } // End Method 



    public function LeaveTypeAdd()
    {
        return view('backend.configuration.leavetype_add');
    } // End Method 

    public function LeaveTypeStore(Request $request)
    {

        $validator = FacadesValidator::make(
            $request->all(),
            [
                'leave_type' => Rule::unique('leave_types')
            ],
            [
                'leave_type.unique' => trans('Leave Type has already been taken')
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        } else {

            LeaveType::insert([
                'leave_type' => $request->leave_type,
                'status' => $request->status,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),

            ]);
            return Response::json(true);
           
        }
    } // End Method 


    public function LeaveTypeEdit($id)
    {

        $leavetype = LeaveType::findOrFail($id);
        
        return view('backend.configuration.leavetype_edit', compact('leavetype'));
    } // End Method 


    public function LeaveTypeUpdate(Request $request)
    {

        $leavetype_id = $request->id;
        $validator = FacadesValidator::make(
            $request->all(),
            [
                'leave_type' => Rule::unique('leave_types')->ignore($leavetype_id)
            ],
            [
                'leave_type.unique' => trans('Leave Type has already been taken')
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        } else {


            LeaveType::findOrFail($leavetype_id)->update([
                'leave_type' => $request->leave_type,
                'status' => $request->status,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),

            ]);

            return Response::json(true);
        }
    } // End Method 

    public function changeStatus(Request $request, $id)
    {

        $state = LeaveType::findOrFail($id);
        $message = "Updated Successfully";

        if ($state->status == 1) {
            $state->status = 0;
            $state->save();
            $message = "Inactive Successfully";
        } else {
            $state->status = 1;
            $state->save();
            $message = "Active Successfully";
        }

        return response()->json($message);
    }
}
