<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Beat;
use App\Models\Customer;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::latest()->get();
        return view('backend.configuration.department.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.configuration.department.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:departments,name',    
        ];
        $customMessages = [
            'name.required' => trans('Name  is required'),
            'name.unique' => trans('Name  already taken'),
        ];
        $this->validate($request, $rules, $customMessages);

        $department  = new Department();
        $department->name  =  $request->name;
        $department->status  =  $request->status;

        $department->save();

        $notification = array(
            'message' => 'Department Added Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('department.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('backend.configuration.department.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|unique:departments,name,' . $id,    
        ];
        $customMessages = [
            'name.required' => trans('Name is required'),
            'name.unique' => trans('Name already taken'),
        ];
        $this->validate($request, $rules, $customMessages);

        $department = Department::findOrFail($id);
        $department->name  =  $request->name;
        $department->status  =  $request->status;

        $department->save();

        $notification = array(
            'message' => 'Department Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('department.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function changeStatus(Request $request, $id)
    {

        $department = Department::findOrFail($id);
        $message = "Updated Successfully";

        if ($department->status == 1) {
            $department->status = 0;
            $department->save();
            $message = "Inactive Successfully";
        } else {
            $department->status = 1;
            $department->save();
            $message = "Active Successfully";
        }
        return response()->json($message);
    }
}
