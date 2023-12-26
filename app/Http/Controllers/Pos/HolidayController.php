<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HolidayController extends Controller
{
    public function index()
    {
        $holidays = Holiday::orderBy('id', 'DESC')->get();

        return view('backend.holiday.index', compact('holidays'));
    }

    public function create()
    {
        return view('backend.holiday.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'from_date' => 'required|unique:holidays',
            'to_date' => 'required|unique:holidays|after_or_equal:from_date',
        ];
        $customMessages = [
            'from_date.unique' => trans('From Date already exist'),
            'to_date.unique' => trans('To Date already exist'),
            'to_date.after_or_equal' => trans('To Date must grater than From date'),

        ];
        $this->validate($request, $rules, $customMessages);
         $add_ipayment  = new Holiday();
         $add_ipayment->from_date  =  $request->from_date;
         $add_ipayment->to_date  =  $request->to_date;
         $add_ipayment->reason  =  $request->reason;
         $add_ipayment->created_by = Auth::user()->id;
         $add_ipayment->save();
 
         $notification = array(
             'message' => 'Holiday Added Successfully',
             'alert-type' => 'success'
         );
 
         return redirect()->route('holiday.index')->with($notification);
        
    }

    public function edit($id)
    {
        $holiday = Holiday::findOrFail($id);
         return view('backend.holiday.edit', compact('holiday'));
    }

    public function update(Request $request,$id)
     {
        $rules = [
            'from_date' => 'required|unique:holidays,from_date,' . $id,
            'to_date' => 'required|unique:holidays,from_date,' . $id .'|after_or_equal:from_date',

        ];
        $customMessages = [
            'from_date.unique' => trans('From Date already exist'),
            'to_date.unique' => trans('To Date already exist'),
            'to_date.after_or_equal' => trans('To Date must grater than From date'),

        ];

        $this->validate($request, $rules, $customMessages);
         $holiday_update  = Holiday::findOrFail($id);
         $holiday_update->from_date  =  $request->from_date;
         $holiday_update->to_date  =  $request->to_date;
         $holiday_update->reason  =  $request->reason;
         $holiday_update->updated_by = Auth::user()->id;
         $holiday_update->save();
 
         $notification = array(
             'message' => 'Holiday Updated Successfully',
             'alert-type' => 'success'
         );
 
         return redirect()->route('holiday.index')->with($notification);
    }
}
