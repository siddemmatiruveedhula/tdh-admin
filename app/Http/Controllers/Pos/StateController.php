<?php

namespace App\Http\Controllers\Pos;

use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class StateController extends Controller
{
    public function StateAll()
    {

        $states = State::orderBy('id', 'desc')->get();
        return view('backend.configuration.state_all', compact('states'));
    } // End Method 

    public function changeStatus(Request $request, $id)
    {

        $state = State::findOrFail($id);
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


    public function StateAdd(){
        $countries = Country::active()->orderBy('name', 'asc')->get();
        return view('backend.configuration.state_add',compact('countries'));
    } // End Method 



     public function StateStore(Request $request){

        $rules = [
            'name' => Rule::unique('states')->where(function ($query) use ($request) {
                return $query->where('country_id', $request->country_id);
            })
        ];
        $customMessages = [
            'name.unique' => trans('Name has already been taken')

        ];

        $this->validate($request, $rules, $customMessages);

        State::insert([
            'name' => $request->name,
            'country_id' => $request->country_id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'State Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('state.all')->with($notification);

    } // End Method 


    public function StateEdit($id){

        $state = State::findOrFail($id);
        $countries = Country::orderBy('name', 'asc')->get();
        return view('backend.configuration.state_edit', compact('countries','state'));

    }// End Method 


    public function StateUpdate(Request $request){

        $state_id = $request->id;

        $rules = [
            'name' => Rule::unique('states')->ignore($state_id)->where(function ($query) use ($request) {
                return $query->where('country_id', $request->country_id);
            })
        ];
        $customMessages = [
            'name.unique' => trans('Name has already been taken')

        ];

        $this->validate($request, $rules, $customMessages);

        State::findOrFail($state_id)->update([
            'name' => $request->name,
            'country_id' => $request->country_id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'State Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('state.all')->with($notification);

    }// End Method 
}
