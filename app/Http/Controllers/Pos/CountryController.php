<?php

namespace App\Http\Controllers\Pos;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    public function CountryAll()
    {

        $countries = Country::orderBy('id', 'desc')->get();
        return view('backend.configuration.country_all', compact('countries'));
    } // End Method 

    public function changeStatus(Request $request, $id)
    {

        $countrie = Country::findOrFail($id);
        $message = "Updated Successfully";
    
        if ($countrie->status == 1) {
            $countrie->status = 0;
            $countrie->save();
             $message = "Inactive Successfully";
           
        } else {
            $countrie->status = 1;
            $countrie->save();
             $message = "Active Successfully";
            
        }
       
        return response()->json($message);
    }


    public function CountryAdd(){
        return view('backend.configuration.country_add');
    } // End Method 



     public function CountryStore(Request $request){

        $rules = [
            'countryCode' => 'required|unique:countries',
            'name' => 'required|unique:countries',
            
        ];
        $customMessages = [
            'countryCode.required' => trans('Country Code is required'),
            'countryCode.unique' => trans('Country Code already exist'),
            'name.required' => trans('Country Name is required'),
            'name.unique' => trans('Country Name already exist'),
        ];
        $this->validate($request, $rules, $customMessages);
        Country::insert([
            'countryCode' => $request->countryCode, 
            'name' => $request->name, 
            'created_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => 'Country Inserted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('country.all')->with($notification);

    } // End Method 


    public function CountryEdit($id){

          $country = Country::findOrFail($id);
        return view('backend.configuration.country_edit',compact('country'));

    }// End Method 


    public function CountryUpdate(Request $request){

        $country_id = $request->id;
        $rules = [
            'countryCode' => 'required|unique:countries,countryCode,'.$country_id,
            'name' => 'required|unique:countries,name,'.$country_id,
            
        ];
        $customMessages = [
            'countryCode.required' => trans('Country Code is required'),
            'countryCode.unique' => trans('Country Code already exist'),
            'name.required' => trans('Name is required'),
            'name.unique' => trans('Country Name already exist'),
        ];
        $this->validate($request, $rules, $customMessages);
        Country::findOrFail($country_id)->update([
            'countryCode' => $request->countryCode, 
            'name' => $request->name, 
            'updated_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => 'Country Updated Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('country.all')->with($notification);

    }// End Method 

}
