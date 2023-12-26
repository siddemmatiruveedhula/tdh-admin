<?php

namespace App\Http\Controllers\Pos;

use Auth;
use File;
use Image;
use Response;
use Carbon\Carbon;
use App\Models\City;
use App\Models\Role;
use App\Models\User;
use App\Models\State;
use App\Models\Country;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Supplier;
use App\Models\Department;
use Illuminate\Support\Str;
use App\Models\CustomerType;
use Illuminate\Http\Request;
use App\Models\PaymentDetail;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Imports\EmployeesImport;
use App\Models\CustomerCategoryType;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    public function EmployeeAll()
    {

        $employees = Employee::latest()->get();
        return view('backend.employee.employee_all', compact('employees'));
    } // End Method

    public function changeStatus(Request $request, $id)
    {

        $employee = Employee::findOrFail($id);
        $message = "Updated Successfully";

        if ($employee->status == 1) {
            $employee->status = 0;
            $employee->save();
            $message = "Inactive Successfully";
        } else {
            $employee->status = 1;
            $employee->save();
            $message = "Active Successfully";
        }
        return response()->json($message);
    }

    public function fetchDivision(Request $request)
    {
        $data['divisions'] = Division::active()->where("department_id", $request->department_id)
            ->get(["name", "id"]);


        return response()->json($data);
    }


    public function EmployeeAdd()
    {
        $departments = Department::active()->orderBy('name')->get();
        $roles = Role::active()->where('role_for', 'employee')->orderBy('name', 'asc')->get();
        $employees = Employee::active()->orderBy('name', 'asc')->get();
        return view('backend.employee.employee_add', compact('roles','departments', 'employees'));
    }    // End Method


    public function EmployeeStore(Request $request)
    {

        Validator::extend('without_spaces', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });

        $validator = FacadesValidator::make(
            $request->all(),
            [
                'employee_code' => 'nullable|unique:employees',
                'email' => 'nullable|unique:employees,email',
                'office_email' => 'unique:users,email',
                'office_phone' => 'unique:employees,office_phone',
                'personal_phone' => 'nullable|unique:employees,personal_phone',
                'username' => 'required|unique:users|without_spaces',
            ],
            [
                'employee_code.unique' => trans('Employee ID already exist'),
                'email.unique' => trans('Personal Email ID already exist'),
                'office_email.unique' => trans('Organization Email ID already exist'),
                'office_phone.unique' => trans('Organization Phone Number already exist'),
                'personal_phone.unique' => trans('Personal Phone Number already exist'),
                'username.unique' => trans('User Name already exist'),
                'username.without_spaces' => trans('Whitespace not allowed.'),
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        } else {

            $user = new User();
            $user->name       = $request->name;
            $user->email      = $request->office_email;
            $password =  $request->password;
            $user->password   = Hash::make($password);
            $user->username   = $request->username;
            $user->role_id    = $request->role_id;
            $user->email_verified_at = Carbon::now();
            $user->save();

            $user_id = $user->id;

            $employee = new Employee();
            $employee->id       = $user_id;
            if ($request->image) {
                $extention = $request->image->getClientOriginalExtension();
                $image_name = Str::slug($request->name, '-') . '-' . date('Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
                $image = 'upload/employees/' . $image_name;
                $img = Image::make($request->image);
                $img->resize(200, 200, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path() . '/' . $image);
                $employee->image = $image_name;
            }
            $employee->name           = $request->name;
            $employee->employee_code  = $request->employee_code;
            $employee->email          = $request->email;
            $employee->office_email   = $request->office_email;
            $employee->personal_phone = $request->personal_phone;
            $employee->office_phone   = $request->office_phone;
            $employee->poc_1          = $request->poc_1;
            $employee->poc_2          = $request->poc_2;
            // $employee->supplier_id    = $request->supplier_id;
            $employee->department_id  = $request->department_id;
            $employee->division_id    = $request->division_id;
            $employee->role_id        = $request->role_id;
            $employee->address        = $request->address;
            $employee->status         = $request->status;
            $employee->daily_allowance = $request->daily_allowance;
            $employee->working_location = $request->working_location;
            $employee->created_at     = Carbon::now();
            $employee->save();

            return Response::json(true);
        }
    } // End Method
    public function getDivisions($deapartment_id)
    {
        $divisions = Division::active()->select('id', 'name')->where('department_id', $deapartment_id)->get();
        return view('backend.employee.division_department', compact('divisions'));
    }

    public function EmployeeEdit($id)
    {
        $user = User::findOrFail($id);

        $employee = Employee::findOrFail($id);
        $employee_pocs = Employee::orderBy('name', 'asc')->get();
        $departments = Department::active() ->orWhere('id', '=', $employee['department_id'])->orderBy('name', 'asc')->get();
        // $divisions = Division::active()->orderBy('name','asc')->get();
        $divisions = Division::select('id', 'name')
            ->where('department_id', $employee->division->department_id ?? '')
            ->active()
            ->orWhere('id', '=', $employee['division_id'])
            ->get();
        // dd($divisions);
        $roles = Role::active()->where('role_for', 'employee')->orWhere('id', '=', $employee['role_id'])->orderBy('name', 'asc')->get();

        return view('backend.employee.employee_edit', compact('employee', 'roles', 'departments', 'user', 'divisions', 'employee_pocs'));
    } // End Method


    public function EmployeeUpdate(Request $request)
    {


        $employee_id = $request->id;

        Validator::extend('without_spaces', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });

        $validator = FacadesValidator::make(
            $request->all(),
            [
                'employee_code' => 'nullable|unique:employees,employee_code,' . $request->id,
                'email' => 'nullable|unique:employees,email,' . $request->id,
                'office_email' => 'unique:users,email,' . $request->id,
                'office_phone' => 'unique:employees,office_phone,' . $request->id,
                'personal_phone' => 'nullable|unique:employees,personal_phone,' . $request->id,
                'username' => 'required|without_spaces|unique:users,username,' . $request->id,
            ],
            [
                'employee_code.unique' => trans('Employee ID already exist'),
                'email.unique' => trans('Personal Email ID already exist'),
                'office_email.unique' => trans('Organization Email ID already exist'),
                'office_phone.unique' => trans('Organization Phone Number already exist'),
                'personal_phone.unique' => trans('Personal Phone Number already exist'),
                'username.unique' => trans('User Name already exist'),
                'username.without_spaces' => trans('Whitespace not allowed.'),
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        } else {

            $user = User::findOrFail($employee_id);
            $user->name       = $request->name;
            $user->email      = $request->office_email;
            $user->username   = $request->username;
            $user->role_id    = $request->role_id;
            // $user->email_verified_at = Carbon::now();
            $user->save();
            // $user_id = $user->id;
            // dd($user_id);

            $employee = Employee::findOrFail($employee_id);
            // $employee->id       = $user_id;
            if ($request->image) {
                $existing_employee = "upload/employees/" . $employee->image;
                $extention  = $request->image->getClientOriginalExtension();
                $image_name = Str::slug($request->name, '-') . '-' . date('Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
                $image = 'upload/employees/' . $image_name;
                $img   = Image::make($request->image);
                $img->resize(200, 200, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path() . '/' . $image);

                if ($existing_employee && $employee->image) {
                    if (File::exists(public_path() . '/' . $existing_employee)) unlink(public_path() . '/' . $existing_employee);
                }
                $employee->image = $image_name;
            }

            $employee->name           = $request->name;
            // $employee->user_name      = $request->user_name;
            $employee->employee_code  = $request->employee_code;
            $employee->email          = $request->email;
            $employee->office_email   = $request->office_email;
            $employee->personal_phone = $request->personal_phone;
            $employee->poc_1          = $request->poc_1;
            $employee->poc_2          = $request->poc_2;
            $employee->office_phone   = $request->office_phone;
            // $employee->supplier_id    = $request->supplier_id;
            $employee->department_id  = $request->department_id;
            $employee->division_id    = $request->division_id;
            $employee->role_id        = $request->role_id;
            $employee->address        = $request->address;
            $employee->status         = $request->status;
            $employee->daily_allowance = $request->daily_allowance;
            $employee->working_location = $request->working_location;
            $employee->updated_at     = Carbon::now();
            $employee->save();

            return Response::json(true);
        }
    } // End Method



    public function resetPassword($id)
    {
        $user = User::find($id);
        return view('backend.employee.reset_password', compact('user'));
    }

    public function updateResetPassword(Request $request, $id)
    {

        $rules = [
            'new_password' => 'required',
        ];
        $this->validate($request, $rules);
        $user = User::find($id);
        $user->password = Hash::make($request->new_password);
        $user->save();
        return back()->with("success", "Password Updated successfully!");
    }

    public function importEmployees()
    {

        return view('backend.employee.employee_import');
    }

    public function storeImportEmployees()
    {
        // dd('test');

        try {
            Excel::queueImport(new EmployeesImport(), request()->file('file'));
        } catch (ValidationException $e) {
            $failures = $e->failures();

            dd($failures);

            // return view('employee.importError', compact('failures'));
        }

        $notification = array(
            'message' => 'Employees data was successfully imported.',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function downloadFile()
    {
        $filepath = public_path('imports/employee_details.xlsx');
        return Response::download($filepath);
    }
}
