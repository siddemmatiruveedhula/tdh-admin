<?php

namespace App\Http\Controllers\Pos;

use App\Models\City;
use App\Models\Unit;
use App\Models\State;
use App\Models\Country;
use App\Models\CustomerType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\CustomerCategoryType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Response;

class CustomerCategoryTypeController extends Controller
{
    public function CustomerCategoryTypeAll()
    {

        $customerCategoryTypes = CustomerCategoryType::latest()->get();
        return view('backend.configuration.customer_category_type_all', compact('customerCategoryTypes'));
    } // End Method 


    public function CustomerCategoryTypeAdd()
    {
        return view('backend.configuration.customer_category_type_add');
    } // End Method 



    public function CustomerCategoryTypeStore(Request $request)
    {

        $validator = FacadesValidator::make(
            $request->all(),
            $rules = [
                'name' => 'required|unique:customer_category_types',
            ],
            $customMessages = [
                'name.required' => trans('Name is required'),
                'name.unique' => trans('Name already exist'),

            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        } else {

            CustomerCategoryType::insert([
                'name' => $request->name,
                // 'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),

            ]);

            return Response::json(true);
        }
    } // End Method 


    public function CustomerCategoryTypeEdit($id)
    {

        $customerCategoryType = CustomerCategoryType::findOrFail($id);
        return view('backend.configuration.customer_category_type_edit', compact('customerCategoryType'));
    } // End Method 


    public function CustomerCategoryTypeUpdate(Request $request)
    {

        $unit_id = $request->id;

        $validator = FacadesValidator::make(
            $request->all(),
            $rules = [
                'name' => 'required|unique:customer_category_types,name,' . $unit_id,
            ],
            $customMessages = [
                'name.required' => trans('Name is required'),
                'name.unique' => trans('Name already exist'),

            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        } else {
            CustomerCategoryType::findOrFail($unit_id)->update([
                'name' => $request->name,
                // 'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),

            ]);

            return Response::json(true);
        }
    } // End Method 

    public function changeStatus(Request $request, $id)
    {

        $customerCategoryType = CustomerCategoryType::findOrFail($id);
        $message = "Updated Successfully";

        if ($customerCategoryType->status == 1) {
            $customerCategoryType->status = 0;
            $customerCategoryType->save();
            $message = "Inactive Successfully";
        } else {
            $customerCategoryType->status = 1;
            $customerCategoryType->save();
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
