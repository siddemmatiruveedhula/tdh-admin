<?php

namespace App\Http\Controllers\Pos;

use DateTime;
use App\Models\Beat;
use App\Models\Customer;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Latetime;
use App\Models\Attendance;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceEmp;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class CheckController extends Controller
{
    // public function index()
    // {
    //     return view('admin.check')->with(['employees' => Employee::all()]);
    // }

    // public function CheckStore(Request $request)
    // {
    //     if (isset($request->attd)) {
    //         foreach ($request->attd as $keys => $values) {
    //             foreach ($values as $key => $value) {
    //                 if ($employee = Employee::whereId(request('employee_id'))->first()) {
    //                     if (
    //                         !Attendance::whereAttendance_date($keys)
    //                             ->whereEmp_id($key)
    //                             ->whereType(0)
    //                             ->first()
    //                     ) {
    //                         $data = new Attendance();

    //                         $data->employee_id = $key;
    //                         $emp_req = Employee::whereId($data->employee_id)->first();
    //                         $data->attendance_time = date('H:i:s', strtotime($emp_req->schedules->first()->time_in));
    //                         $data->attendance_date = $keys;

    //                         $emps = date('H:i:s', strtotime($employee->schedules->first()->time_in));
    //                         if (!($emps > $data->attendance_time)) {
    //                             $data->status = 0;

    //                         }
    //                         $data->save();
    //                     }
    //                 }
    //             }
    //         }
    //     }
    //     if (isset($request->leave)) {
    //         foreach ($request->leave as $keys => $values) {
    //             foreach ($values as $key => $value) {
    //                 if ($employee = Employee::whereId(request('emp_id'))->first()) {
    //                     if (
    //                         !Leave::whereLeave_date($keys)
    //                             ->whereEmp_id($key)
    //                             ->whereType(1)
    //                             ->first()
    //                     ) {
    //                         $data = new Leave();
    //                         $data->emp_id = $key;
    //                         $emp_req = Employee::whereId($data->emp_id)->first();
    //                         $data->leave_time = $emp_req->schedules->first()->time_out;
    //                         $data->leave_date = $keys;
    //                         if ($employee->schedules->first()->time_out <= $data->leave_time) {
    //                             $data->status = 1;

    //                         }

    //                         $data->save();
    //                     }
    //                 }
    //             }
    //         }
    //     }
    //     flash()->success('Success', 'You have successfully submited the attendance !');
    //     return back();
    // }
    public function sheetReport(Request $request)
    {
        $department_id='';
        $division_id='';
        if ($request->month) {

            $employees = Employee::active()->orderBy('name', 'asc')->get();
            if (!empty($request->department_id) && !empty($request->division_id)) {
                $employees = Employee::active()->where('department_id', $request->department_id)->where('division_id', $request->division_id)->get();
                // return view('backend.attendance.sheet-report', compact('employees', 'month', 'departments', 'divisions'));
            } else if (!empty($request->department_id)) {
                $employees = Employee::active()->where('department_id', $request->department_id)->get();
                // return view('backend.attendance.sheet-report', compact('employees', 'month', 'departments', 'divisions'));
            } else if (!empty($request->division_id)) {
                $employees = Employee::active()->where('division_id', $request->division_id)->get();
                // return view('backend.attendance.sheet-report', compact('employees', 'month', 'departments', 'divisions'));
            }
            $department_id=$request->department_id;
            $division_id=$request->division_id;
            $departments = Department::active()->orderBy('name')->get();
            $divisions = Division::active()->orderBy('name')->get();
            $month = Carbon::parse($request->month)->format("Y-m-d h:m:s");
            return view('backend.attendance.sheet-report', compact('employees', 'month', 'departments', 'divisions','department_id','division_id'));
        }
        $employees = Employee::active()->orderBy('name', 'asc')->get();
        $departments = Department::active()->orderBy('name')->get();
        $divisions = Division::active()->orderBy('name')->get();
        return view('backend.attendance.sheet-report', compact('employees', 'departments', 'divisions','department_id','division_id'));
    }
}
