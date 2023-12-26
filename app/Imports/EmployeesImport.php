<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Validator;

class EmployeesImport implements ToModel, WithHeadingRow, ShouldQueue, WithChunkReading, WithBatchInserts, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {



        $role = Role::where('name', $row['role'])->select('id')->first();
        $department = Department::where('name', $row['department'])->select('id')->first();

        $division = Division::where('name', $row['division'])->select('id')->first();

        $division_id  = $division->id ?? null;


        $user = User::create([
            'name' => $row['name'],
            'username' => $row['user_name'],
            'email' => $row['organization_email'],
            'password' => Hash::make($row['password']),
        ]);

        return new Employee([
            'id' => $user->id,
            'name' => $row['name'],
            'office_email' => $row['organization_email'],
            'office_phone' => $row['organization_phone'],
            'role_id' => $role->id,
            'department_id' => $department->id,
            'division_id' => $division_id,
        ]);
    }

    public function rules(): array
    {

        $employee_types_array = Role::active()->where('role_for', 'employee')->pluck('name');

        $departments_array = Department::active()->pluck('name');

        $divisions_array = Division::active()->pluck('name');

        Validator::extend('without_spaces', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        });

        Validator::extend('iDepartmentExist', function ($attribute, $value, $parameters, $validator) {            
            $query = DB::table($parameters[0]);
            $column = $query->getGrammar()->wrap($parameters[1]);
            return $query->whereRaw("lower({$column}) = lower(?)", [trim($value)])->count();
        },'The Selected Department Is Invalid.');

        Validator::extend('iDivisionExist', function ($attribute, $value, $parameters, $validator) {            
            $query = DB::table($parameters[0]);
            $column = $query->getGrammar()->wrap($parameters[1]);
            return $query->whereRaw("lower({$column}) = lower(?)", [trim($value)])->count();
        },'The Selected Division Is Invalid.');
        


        return [
            'name' => 'required|string|regex:/^[a-zA-Z0-9 . - , ]*$/',
            'user_name' => 'required|string|regex:/^[A-Za-z0-9]*$/|min:5|without_spaces|distinct|unique:App\Models\User,username',
            'organization_email' => 'required|email|distinct|unique:App\Models\User,email',
            'organization_phone' => 'required|digits:10|distinct|unique:App\Models\Employee,office_phone',
            'password' => 'required|min:4',
            'role' => ['required', Rule::exists('roles', 'name')->where('role_for', 'employee')],
            'department' => 'required|iDepartmentExist:departments,name',
            'division' => 'required|iDivisionExist:divisions,name',
        ];
    }

    public function customValidationAttributes()
    {
        return [
            'user_name' => 'User Name',
            'organization_email' => 'Organization Email',
            'organization_phone' => 'Organization Phone'
        ];
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
