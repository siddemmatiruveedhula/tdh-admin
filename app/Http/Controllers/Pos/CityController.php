<?php

namespace App\Http\Controllers\Pos;

use Auth;
use Response;
use Validator;
use Illuminate\Validation\Rule;
use App\Models\City;
use App\Models\Unit;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class CityController extends Controller
{
    public function CityAll()
    {
        $cities = City::latest()->get();
        return view('backend.configuration.city_all', compact('cities'));
    } // End Method 



    public function CityAdd()
    {
        $countries = Country::active()->orderBy('name', 'asc')->get();
        $states = State::active()->orderBy('name', 'asc')->get();
        $districts = District::active()->orderBy('name', 'asc')->get();
        return view('backend.configuration.city_add', compact('countries', 'states', 'districts'));
    } // End Method 

    public function CityStore(Request $request)
    {

        $validator = FacadesValidator::make(
            $request->all(),
            [
                'name' => Rule::unique('cities')->where(function ($query) use ($request) {
                    return $query->where('state_id', $request->state_id)->where('district_id', $request->district_id);
                })
            ],
            [
                'name.unique' => trans('Name has already been taken')
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        } else {

            City::insert([
                'name' => $request->name,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'district_id' => $request->district_id,
                'status' => $request->status,
                'created_at' => Carbon::now(),

            ]);
            return Response::json(true);
           
        }
    } // End Method 


    public function CityEdit($id)
    {

        $city = City::findOrFail($id);
        $countries = Country::active()->orderBy('name', 'asc')->orWhere('id', '=', $city['country_id'])->get();
        $states = State::active()->orderBy('name', 'asc')->orWhere('id', '=', $city['state_id'])->get();

        $districts = District::active()->orderBy('name', 'asc')->orWhere("id", '=', $city['district_id'])->get();
        return view('backend.configuration.city_edit', compact('city', 'countries', 'states', 'districts'));
    } // End Method 


    public function CityUpdate(Request $request)
    {

        $city_id = $request->id;
        $validator = FacadesValidator::make(
            $request->all(),
            [
                'name' => Rule::unique('cities')->ignore($city_id)->where(function ($query) use ($request) {
                    return $query->where('state_id', $request->state_id)->where('district_id', $request->district_id);
                })
            ],
            [
                'name.unique' => trans('Name has already been taken')
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        } else {


            City::findOrFail($city_id)->update([
                'name' => $request->name,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'district_id' => $request->district_id,
                'status' => $request->status,

            ]);

            return Response::json(true);
        }
    } // End Method 

    public function changeStatus(Request $request, $id)
    {

        $state = City::findOrFail($id);
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



    // public function UnitDelete($id){

    //       Unit::findOrFail($id)->delete();

    //    $notification = array(
    //         'message' => 'Unit Deleted Successfully', 
    //         'alert-type' => 'success'
    //     );

    //     return redirect()->back()->with($notification);

    // } // End Method 



}
