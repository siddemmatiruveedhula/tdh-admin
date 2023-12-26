<?php

namespace App\Http\Controllers\Pos;


use Carbon\Carbon;
use App\Models\Beat;
use App\Models\Employee;
use App\Models\AssignPjp;
use App\Models\AssignPjpMultiBeat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use  Yajra\DataTables\Facades\DataTables;


class AssignPjpController extends Controller
{
    public function index()
    {

        if (request()->ajax()) {

            $data =  AssignPjp::select('*')->orderBy('id', 'DESC');
            return datatables()->of($data)->addIndexColumn()
                ->addColumn('action', function ($data) {

                    $btn = '<a href="assign_pjp-edit/' . $data->id . '"title="Edit Data" class="btn btn-info sm"><i class="fas fa-edit"></i></a>';
                    return $btn;
                })
                ->addColumn('emp_name', function ($data) {
                    if ($data->employee->name) {
                        $employee_name = $data->employee->name;
                    } else {
                        $employee_name = '';
                    }
                    return $employee_name;
                })
                // ->addColumn('beat_name', function ($data) {

                //     if ($data->employee->name) {
                //         $beat_name = $data->beat->name;
                //     } else {
                //         $beat_name = '';
                //     }
                //     return $beat_name;
                // })
                ->editColumn('date', function ($data) {
                    if ($data->date) {
                        $check_attd = Carbon::parse($data->date)->format("d-m-Y");
                    } else {
                        $check_attd = '...';
                    }
                    return $check_attd;
                })
                ->addColumn('status', function ($data) {

                    if ($data->status == 1) {
                        $status = '<div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" checked
                            onchange="changeAssignPjpStatus(' . $data->id . ')">
                    </div>';
                    } else {
                        $status = '<div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox"
                            onchange="changeAssignPjpStatus(' . $data->id . ')">
                    </div>';
                    }

                    return $status;
                })

                ->rawColumns(['emp_name', 'action', 'status'])->make(true);
        }

        // return view('admin.newsletter_subscription.index');
        return view('backend.assign_pjp.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::orderBy('name', 'asc')->get();
        $beats = Beat::active()->orderBy('name', 'asc')->get();
        $date = date('Y-m-d');
        return view('backend.assign_pjp.create', compact('date', 'employees', 'beats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $rules = [

        //     'employee_id' => Rule::unique('assign_pjps')->where(function ($query) use ($request) {
        //         return $query->where('date', $request->date);
        //     }),
        //     'beat_id' => Rule::unique('assign_pjps')->where(function ($query) use ($request) {
        //         return $query->where('date', $request->date);
        //     })
        // ];
        $rules = [

            'beat_id' => 'required',
        ];
        $customMessages = [
            'beat_id.required' => trans('Please Select Beat'),

        ];
        $this->validate($request, $rules, $customMessages);

        $assign_pjp  = new AssignPjp();
        $assign_pjp->date  =  $request->date;
        $assign_pjp->employee_id  =  $request->employee_id;
        $assign_pjp->status  =  $request->status;
        $assign_pjp->created_by = Auth::user()->id;

        $assign_pjp->save();

        $beat_ids = $request->beat_id;
        if ($beat_ids > 0) {
            foreach ($beat_ids as $beat_id) {
                if (!empty($beat_id)) {
                    AssignPjpMultiBeat::create([
                        'assign_pjp_id' => $assign_pjp->id,
                        'beat_id'   => $beat_id,
                        'created_at' => Carbon::now(),
                    ]);
                }
            }
        }

        $notification = array(
            'message' => 'Assign Pjp Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('assign_pjp.index')->with($notification);
    }


    public function edit($id)
    {
        $assign_pjp = AssignPjp::findOrFail($id);
        $employees = Employee::orderBy('name', 'asc')->get();
        $beats = Beat::orderBy('name', 'asc')->get();
        $assign_beats = AssignPjpMultiBeat::where('assign_pjp_id', $id)->get();
        foreach ($assign_beats as $assign_beat) {
            if (!empty($assign_beat)) {
                $beat_id[]=$assign_beat->beat_id;
            }
        }
        $beat_ids=implode(',', $beat_id);
        // dd($beat_id);
        
        return view('backend.assign_pjp.edit', compact('assign_pjp', 'employees', 'beats','beat_ids'));
    }


    public function update(Request $request, $id)
    {
        // $rules = [
        //     'employee_id' => Rule::unique('assign_pjps')->ignore($id)->where(function ($query) use ($request) {
        //         return $query->where('date', $request->date);
        //     }),
        //     'beat_id' => Rule::unique('assign_pjps')->ignore($id)->where(function ($query) use ($request) {
        //         return $query->where('date', $request->date);
        //     })

        // ];
        // $customMessages = [
        //     'employee_id.unique' => trans('employee has already been taken for this date'),
        //     'beat_id.unique' => trans('Beat has already been taken for this date')
        // ];
        // $this->validate($request, $rules, $customMessages);

        $rules = [

            'beat_id' => 'required',
        ];
        $customMessages = [
            'beat_id.required' => trans('Please Select Beat'),

        ];
        $this->validate($request, $rules, $customMessages);

        $assign_pjp  = AssignPjp::findOrFail($id);
        $assign_pjp->date  =  $request->date;
        $assign_pjp->employee_id  =  $request->employee_id;
        $assign_pjp->status  =  $request->status;
        $assign_pjp->save();

        AssignPjpMultiBeat::where('assign_pjp_id', $id)->delete();

        $beat_ids = $request->beat_id;
        if ($beat_ids > 0) {
            foreach ($beat_ids as $beat_id) {
                if (!empty($beat_id)) {
                    AssignPjpMultiBeat::create([
                        'assign_pjp_id' => $assign_pjp->id,
                        'beat_id'   => $beat_id,
                        'created_at' => Carbon::now(),
                    ]);
                }
            }
        }

        $notification = array(
            'message' => 'Assign Pjp Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('assign_pjp.index')->with($notification);
    }


    public function changeStatus(Request $request, $id)
    {

        $area = AssignPjp::findOrFail($id);
        $message = "Updated Successfully";

        if ($area->status == 1) {
            $area->status = 0;
            $area->save();
            $message = "Inactive Successfully";
        } else {
            $area->status = 1;
            $area->save();
            $message = "Active Successfully";
        }
        return response()->json($message);
    }
}
