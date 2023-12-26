<?php

namespace App\Http\Controllers\Pos;

use Auth;
use App\Models\Storage;
use App\Models\Supplier;
use App\Models\StorageType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class StorageController extends Controller
{
    public function All()
    {
        // $suppliers = Supplier::all();
        $storages = Storage::latest()->get();
        return view('backend.storage.storage_all', compact('storages'));
    } // End Method 



    public function changeStatus(Request $request, $id)
    {

        $storage = Storage::findOrFail($id);
        // $message = "Updated Successfully";

        if ($storage->status == 1) {
            $storage->status = 0;
            $storage->save();
            $message = "Inactive Successfully";
        } else {
            $storage->status = 1;
            $storage->save();
            $message = "Active Successfully";
        }
        return response()->json($message);
    }

    public function Add()
    {
        $storageTypes = StorageType::active()->latest()->get();
        return view('backend.storage.storage_add', compact('storageTypes'));
    } // End Method 

    public function Store(Request $request)
    {

        $rules = [
            'name' => Rule::unique('storages')->where(function ($query) use ($request) {
                return $query->where('storage_type_id', $request->storage_type_id);
            }),
        ];
        $customMessages = [
            'name.required' => trans('Name is required'),
            'name.unique' => trans('Name already exist in selected storage type'),
        ];
        $this->validate($request, $rules, $customMessages);

        Storage::insert([
            'name' => $request->name,
            'storage_type_id' => $request->storage_type_id,
            'no_of_products_types' => $request->no_of_products_types,
            'capacity' => $request->capacity,
            'status' => $request->status,
            // 'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Storage Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('storage.all')->with($notification);
    } // End Method 


    public function Edit($id)
    {

        $storage = Storage::findOrFail($id);
        $storageTypes = StorageType::active()->orWhere('id', $storage['storage_type_id'])->latest()->get();
        return view('backend.storage.storage_edit', compact('storage', 'storageTypes'));
    } // End Method 

    public function Update(Request $request)
    {

        $suplier_id = $request->id;

        $rules = [
            'name' => Rule::unique('storages')->where(function ($query) use ($request) {
                return $query->where('storage_type_id', $request->storage_type_id);
            })->ignore($suplier_id),
        ];
        $customMessages = [
            'name.required' => trans('Name is required'),
            'name.unique' => trans('Name already exist in selected storage type'),
        ];
        $this->validate($request, $rules, $customMessages);

        Storage::findOrFail($suplier_id)->update([
            'name' => $request->name,
            'storage_type_id' => $request->storage_type_id,
            'no_of_products_types' => $request->no_of_products_types,
            'capacity' => $request->capacity,
            'status' => $request->status,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Storage Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('storage.all')->with($notification);
    } // End Method 


    public function Delete($id)
    {

        Storage::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Storage Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method 


}
