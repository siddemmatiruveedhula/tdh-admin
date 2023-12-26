<?php

namespace App\Http\Controllers\Pos;

use Carbon\Carbon;
use App\Models\StorageType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StorageTypeController extends Controller
{
    public function All()
    {
        $storageTypes = StorageType::latest()->get();
        return view('backend.configuration.storage_type_all', compact('storageTypes'));
    } // End Method


    public function changeStatus(Request $request, $id)
    {

        $storageType = StorageType::findOrFail($id);
        // $message = "Updated Successfully";

        if ($storageType->status == 1) {
            $storageType->status = 0;
            $storageType->save();
            $message = "Inactive Successfully";
        } else {
            $storageType->status = 1;
            $storageType->save();
            $message = "Active Successfully";
        }
        return response()->json($message);
    }
    public function Add(){
        return view('backend.configuration.storage_type_add');
    } // End Method 



     public function Store(Request $request){

        $rules = [
            'name' => 'required|unique:storage_types',
            
        ];
        $customMessages = [
            'name.required' => trans('Storage Type is required'),
            'name.unique' => trans('Storage Type already exist'),
        ];
        $this->validate($request, $rules, $customMessages);
        StorageType::insert([
            'name' => $request->name, 
            'created_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => 'Storage Type Inserted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('storage-type.all')->with($notification);

    } // End Method 


    public function Edit($id){

          $storage_type = StorageType::findOrFail($id);
        return view('backend.configuration.storage_type_edit',compact('storage_type'));

    }// End Method 


    public function Update(Request $request){

        $storage_types_id = $request->id;
        $rules = [
            'name' => 'required|unique:storage_types,name,'.$storage_types_id,
            
        ];
        $customMessages = [
            'name.required' => trans('Storage Type is required'),
            'name.unique' => trans('Storage Type already exist'),
        ];
        $this->validate($request, $rules, $customMessages);
        StorageType::findOrFail($storage_types_id)->update([
            'name' => $request->name, 
            'updated_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => 'Storage Type Updated Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('storage-type.all')->with($notification);

    }// End Method 
   
}
