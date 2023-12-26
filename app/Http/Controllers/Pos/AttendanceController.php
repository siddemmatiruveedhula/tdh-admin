<?php

namespace App\Http\Controllers\Pos;

use DateTime;
use Carbon\Carbon;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Latetime;
use App\Models\Attendance;
use App\Models\Department;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceEmp;
use App\Models\Holiday;
use App\Models\Leave;
use Illuminate\Support\Facades\Hash;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {

        if (request()->ajax()) {

            if (!empty($request->from_date)) {

                $attendance_date = Carbon::parse($request->from_date)->format("Y-m-d");

                if (!empty($request->department_id) && !empty($request->division_id)) {
                    $attendanceSql = "SELECT * FROM (SELECT e.id,e.status estatus, e.name,r.name role_name,d.id deptid,d.name department_name,div1.id divid,div1.name division_name,
                     a.attendance_time, clockout_time ,a.status attendance_status FROM employees e
                     left join roles r on r.id = e.role_id
                    --  left join suppliers s on s.id = e.supplier_id
                     left join divisions div1 on div1.id = e.division_id
                     left join departments d on d.id = div1.department_id
                     left join attendances a on e.id = a.employee_id and a.attendance_date = '$attendance_date') d where deptid = '$request->department_id' and divid = '$request->division_id' and estatus=1";

                    $data = DB::select($attendanceSql);
                } else if (!empty($request->department_id)) {
                    $attendanceSql = "SELECT * FROM (SELECT e.id,e.status estatus, e.name,r.name role_name,d.id deptid,d.name department_name,div1.name division_name,
                     a.attendance_time, clockout_time ,a.status attendance_status FROM employees e
                     left join roles r on r.id = e.role_id
                    --  left join suppliers s on s.id = e.supplier_id
                     left join divisions div1 on div1.id = e.division_id
                     left join departments d on d.id = div1.department_id
                     left join attendances a on e.id = a.employee_id and a.attendance_date = '$attendance_date') d where deptid = '$request->department_id' and estatus=1";

                    $data = DB::select($attendanceSql);
                } else if (!empty($request->division_id)) {
                    $attendanceSql = "SELECT * FROM (SELECT e.id,e.status estatus, e.name,r.name role_name,d.name department_name,div1.id divid,div1.name division_name,
                    a.attendance_time, clockout_time ,a.status attendance_status FROM employees e
                    left join roles r on r.id = e.role_id
                    -- left join suppliers s on s.id = e.supplier_id
                    left join divisions div1 on div1.id = e.division_id
                    left join departments d on d.id = div1.department_id
                    left join attendances a on e.id = a.employee_id and a.attendance_date = '$attendance_date') v where divid = '$request->division_id' and estatus=1";

                    $data = DB::select($attendanceSql);
                } else {
                    $attendanceSql = "SELECT e.id,e.status, e.name,r.name role_name,d.id deptid,d.name department_name,div1.name division_name,
                     a.attendance_time, clockout_time ,a.status attendance_status FROM employees e
                     left join roles r on r.id = e.role_id
                    --  left join suppliers s on s.id = e.supplier_id
                     left join divisions div1 on div1.id = e.division_id
                     left join departments d on d.id = div1.department_id
                     left join attendances a on e.id = a.employee_id and a.attendance_date = '$attendance_date' where e.status=1";
                    $data = DB::select($attendanceSql);
                }
            }
            else {

                $date_picker = \Carbon\Carbon::now()->format('Y-m-d');

                $attendanceSql = "SELECT e.id,e.status, e.name,r.name role_name,d.id deptid,d.name department_name,div1.name division_name,
                a.attendance_time, clockout_time ,a.status attendance_status FROM employees e
                left join roles r on r.id = e.role_id
                -- left join suppliers s on s.id = e.supplier_id
                left join divisions div1 on div1.id = e.division_id
                left join departments d on d.id = div1.department_id
                left join attendances a on e.id = a.employee_id and a.attendance_date = '$date_picker' where e.status=1";

                $data = DB::select($attendanceSql);
            }

            if (!empty($request->from_date)) {
                $date_picker=Carbon::parse($request->from_date)->format("Y-m-d");
            }else{
                $date_picker = \Carbon\Carbon::now()->format('Y-m-d');
            }
            
            return datatables()->of($data)->addIndexColumn()
                ->addColumn('attendance_status', function ($data) use ($date_picker) {
                    
                    $newDate = date('l', strtotime($date_picker));
                    $holiday_check = Holiday::query()
                        ->whereRaw('"' . $date_picker . '" between `from_date` and `to_date`')->get();
                    $leave_check = Leave::query()
                        ->where('employee_id', $data->id)
                        ->where('date', $date_picker)
                        ->where('status', 'approved')
                        ->get();

                        if($newDate=='Sunday'){
                            if ($data->attendance_status == 1) {
                                $status = '<b><i class="fas text-primary">HP</i></b>';
                            } else {
                                $status = '<b><i class="fas text-primary">H</i></b>';
                            }
                        }elseif(count($holiday_check)){
                            if ($data->attendance_status == 1) {
                                $status = '<b><i class="fas text-primary">HP</i></b>';
                            } else {
                                $status = '<b><i class="fas text-primary">H</i></b>';
                            }
                        }elseif(count($leave_check)){
                            if ($data->attendance_status == 1) {
                                $status = '<b><i class="fas text-warning">LP</i></b>';
                            } else {
                                $status = '<b><i class="fas text-warning">L</i></b>';
                            }
                        }else{
                            if ($data->attendance_status == 1) {
                                $status = '<b><i class="fas text-success">P</i></b>';
                            }else {
                                $status = '<b><i class="fas text-danger">A</i></b>';
                            }

                        }
                     
                    return $status;
                })
                ->editColumn('attendance_time', function ($data) {
                    if ($data->attendance_time) {
                        $check_attd = Carbon::parse($data->attendance_time)->format("H:i");
                    } else {
                        $check_attd = '...';
                    }
                    return $check_attd;
                })
                ->editColumn('clockout_time', function ($data) {
                    if ($data->clockout_time) {
                        $check_attd = Carbon::parse($data->clockout_time)->format("H:i");
                    } else {
                        $check_attd = '...';
                    }
                    return $check_attd;
                })
                ->rawColumns(['attendance_status'])
                ->make(true);
        }
        $current_date = Carbon::parse($request->from_date)->format("d-M-Y");
        $departments = Department::active()->orderBy('name')->get();
        $divisions = Division::active()->orderBy('name')->get();
        // $employees = Division::all();
        return view('backend.attendance.index', compact('current_date', 'departments', 'divisions'));
    }
}
