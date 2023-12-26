<?php

namespace App\Http\Controllers\Pos;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Models\Area;
use App\Models\State;
use App\Models\Country;
use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;

use Response;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class AreaController extends Controller
{
    public function AreaAll()
    {
        $areas = Area::latest()->get();
        return view('backend.configuration.area_all', compact('areas'));
    } // End Method

    
    public function changeStatus(Request $request, $id)
    {

        $area = Area::findOrFail($id);
        $message = "Updated Successfully";
    
        if ($area->status == 1) {
            $area->status = 0;
            $area->save();
             $message = "Inactive Successfully";
           
        } else {
            $area->status = 1;
            $area->save();
             $message = "Active Successfully";
            
        }
        return response()->json($message);
    }

    public function AreaAdd(){
        $countries = Country::active()->orderBy('name', 'asc')->get();
        $states = State::active()->orderBy('name', 'asc')->get();
        $districts = District::active()->orderBy('name', 'asc')->get();
        $cities=City::active()->orderBy('name', 'asc')->get();
        return view('backend.configuration.area_add', compact('countries','states','districts','cities'));
    } // End Method 



     public function AreaStore(Request $request){

        // $rules = [

        //     'name' => 'unique:areas,name',
        // ];

        // $rules = [
        //     'name' => Rule::unique('areas')->where(function ($query) use ($request) {
        //         return $query->where('state_id', $request->state_id);
        //     })
        // ];
        // $customMessages = [
        //     'name.unique' => trans('Name has already been taken')

        // ];
        // $this->validate($request, $rules, $customMessages);

        $validator = FacadesValidator::make(
            $request->all(),
            [
                'name' => Rule::unique('areas')->where(function ($query) use ($request) {
                    return $query->where('state_id', $request->state_id)->where('district_id', $request->district_id)->where('city_id', $request->city_id);
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
        }

        Area::insert([
            'name' => $request->name, 
            'country_id'=>$request->country_id,
            'state_id' => $request->state_id,
            'district_id'=>$request->district_id,
            'city_id'=>$request->city_id,
            'status' => $request->status, 
   
            'created_at' => Carbon::now(), 

        ]);

        return Response::json(true);
       
    } // End Method 


    public function AreaEdit($id){

          $area = Area::findOrFail($id);
          $countries = Country::active()->orderBy('name', 'asc')->orWhere('id', '=', $area['country_id'])->get();
          $states = State::active()->orderBy('name', 'asc')->orWhere('id', '=', $area['state_id'])->get();
          $districts = District::active()->where("state_id", $area['state_id'])->orWhere('id', '=', $area['district_id'])->get();
          $cities=City::active()->where("district_id", $area['district_id'])->orderBy('name', 'asc')->orWhere('id', '=', $area['city_id'])->get();
        return view('backend.configuration.area_edit',compact('area','countries','states','districts','cities'));

    }// End Method 


    public function AreaUpdate(Request $request){

        $area_id = $request->id;

        $validator = FacadesValidator::make(
            $request->all(),
            [
                'name' => Rule::unique('areas')->ignore($area_id)->where(function ($query) use ($request) {
                    return $query->where('state_id', $request->state_id)->where('district_id', $request->district_id)->where('city_id', $request->city_id);
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
        }
        Area::findOrFail($area_id)->update([
            'name' => $request->name, 
            'status' => $request->status, 
            'country_id'=>$request->country_id,
            'state_id' => $request->state_id,
            'district_id'=>$request->district_id,
            'city_id'=>$request->city_id,
            'updated_at' => Carbon::now(), 

        ]);

        return Response::json(true);

    }// End Method 
}
