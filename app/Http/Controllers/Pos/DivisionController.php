<?php

namespace App\Http\Controllers\Pos;

use App\Models\Beat;
use App\Models\Customer;
use App\Models\Division;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisions = Division::latest()->get();
        // dd($beats);
        return view('backend.configuration.division.index', compact('divisions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $departments = Department::active()->orderBy('name')->get();
        return view('backend.configuration.division.create', compact('departments'));
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
            'name' => Rule::unique('divisions')->where(function ($query) use ($request) {
                return $query->where('department_id', $request->department_id);
            }),
        ];
        $customMessages = [
            'name.required' => trans('Name  is required'),
            'name.unique' => trans('Name  already taken'),
        ];
        $this->validate($request, $rules, $customMessages);

        $department  = new Division();
        $department->name  =  $request->name;
        $department->department_id  =  $request->department_id;
        $department->status  =  $request->status;

        $department->save();

        $notification = array(
            'message' => 'Division Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('division.index')->with($notification);
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
        $departments = Department::active()->orderBy('name')->get();
        $division = Division::findOrFail($id);
        return view('backend.configuration.division.edit', compact('departments', 'division'));
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
            'name' => Rule::unique('divisions')->where(function ($query) use ($request) {
                return $query->where('department_id', $request->department_id);
            })->ignore($id),
        ];
        $customMessages = [
            'name.required' => trans('Name is required'),
            'name.unique' => trans('Name already taken'),
        ];
        $this->validate($request, $rules, $customMessages);

        $department = Division::findOrFail($id);
        $department->name  =  $request->name;
        $department->department_id  =  $request->department_id;
        $department->status  =  $request->status;

        $department->save();

        $notification = array(
            'message' => 'Division Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('division.index')->with($notification);
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

        $department = Division::findOrFail($id);
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
