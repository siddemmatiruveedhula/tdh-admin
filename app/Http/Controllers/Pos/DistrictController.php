<?php

namespace App\Http\Controllers\Pos;

use Carbon\Carbon;
use App\Models\State;
use App\Models\Country;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DistrictController extends Controller
{
    public function DistrictAll()
    {
        $districts = District::latest()->get();
        return view('backend.configuration.district_all', compact('districts'));
    } // End Method


    public function changeStatus(Request $request, $id)
    {

        $district = District::findOrFail($id);
        $message = "Updated Successfully";

        if ($district->status == 1) {
            $district->status = 0;
            $district->save();
            $message = "Inactive Successfully";
        } else {
            $district->status = 1;
            $district->save();
            $message = "Active Successfully";
        }

        return response()->json($message);
    }

    public function DistrictAdd()
    {
        $countries = Country::active()->orderBy('name', 'asc')->get();
        $states = State::active()->orderBy('name', 'asc')->get();
        return view('backend.configuration.district_add', compact('states', 'countries'));
    } // End Method 



    public function DistrictStore(Request $request)
    {
        // Validator::make([
        //     'name' => ['request', 'string', 'name', Rule::unique('districts')->where(function ($query) use ($request) {
        //         return $query->where('state_id', $request->state_id);
        //     })],
        // ]);

        $rules = [
            'name' => Rule::unique('districts')->where(function ($query) use ($request) {
                return $query->where('state_id', $request->state_id);
            })
        ];
        $customMessages = [
            'name.unique' => trans('Name has already been taken')

        ];

        $this->validate($request, $rules, $customMessages);

        District::insert([
            'name' => $request->name,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'status' => $request->status,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'District Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('district.all')->with($notification);
    } // End Method 
    public function DistrictEdit($id)
    {
        $district = District::findOrFail($id);
        $countries = Country::orderBy('name', 'asc')->get();
        $states = State::orderBy('name', 'asc')->get();
        return view('backend.configuration.district_edit', compact('district', 'countries','states'));
    } // End Method 

    public function DistrictUpdate(Request $request)
    {

        $district_id = $request->id;

        $rules = [
            'name' => Rule::unique('districts')->ignore($district_id)->where(function ($query) use ($request) {
                return $query->where('state_id', $request->state_id);
            })
        ];

        // $rules = [

        //     'name' => 'unique:districts,name,' . $district_id,

        // ];
        $customMessages = [
            'name.unique' => trans('Name has already been taken')

        ];

        $this->validate($request, $rules, $customMessages);

        District::findOrFail($district_id)->update([
            'name' => $request->name,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'status' => $request->status,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'District Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('district.all')->with($notification);
    } // End Method 

}
