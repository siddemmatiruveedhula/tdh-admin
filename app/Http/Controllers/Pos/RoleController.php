<?php

namespace App\Http\Controllers\Pos;

use Auth;
use App\Models\City;
use App\Models\Role;
use App\Models\Unit;
use App\Models\State;
use App\Models\Country;
use App\Models\CustomerType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\CustomerCategoryType;

class RoleController extends Controller
{
    public function RoleAll()
    {

        $roles = Role::get();
        return view('backend.configuration.role_all', compact('roles'));
    } // End Method 

    public function changeStatus(Request $request, $id)
    {

        $role = Role::findOrFail($id);
        $message = "Updated Successfully";

        if ($role->status == 1) {
            $role->status = 0;
            $role->save();
            $message = "Inactive Successfully";
        } else {
            $role->status = 1;
            $role->save();
            $message = "Active Successfully";
        }
        return response()->json($message);
    }
    



}
