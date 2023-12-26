<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function index()
    {
        $leaves = Leave::orderBy('id', 'DESC')->get();

        return view('backend.leave.index', compact('leaves'));
    }
    public function edit($id)
    {
        $leave = Leave::findOrFail($id);
         return view('backend.leave.edit', compact('leave'));
    }
    public function update(Request $request,$id)
     {
        

        
         $holiday_update  = Leave::findOrFail($id);
         $holiday_update->status  =  $request->status;
         $holiday_update->updated_by = Auth::user()->id;
         $holiday_update->save();
 
         $notification = array(
             'message' => 'Leave Updated Successfully',
             'alert-type' => 'success'
         );
 
         return redirect()->route('leave.index')->with($notification);
    }
}

