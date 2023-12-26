<?php

namespace App\Http\Controllers\Pos;

use Auth;
use App\Models\City;
use App\Models\Unit;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\CustomerType;

class CustomerTypeController extends Controller
{
    public function CustomerTypeAll()
    {

        $customerTypes = CustomerType::orderBy('custom_order','asc')->get();
        return view('backend.configuration.customer_type_all', compact('customerTypes'));
    } // End Method
    

    public function changeStatus(Request $request, $id)
    {

        $customerType = CustomerType::findOrFail($id);
        $message = "Updated Successfully";
    
        if ($customerType->status == 1) {
            $customerType->status = 0;
            $customerType->save();
             $message = "Inactive Successfully";
           
        } else {
            $customerType->status = 1;
            $customerType->save();
             $message = "Active Successfully";
            
        }
       
        return response()->json($message);
    }



}
