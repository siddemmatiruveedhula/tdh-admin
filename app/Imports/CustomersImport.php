<?php

namespace App\Imports;

use App\Models\Area;
use App\Models\Beat;
use App\Models\City;
use App\Models\Country;
use App\Models\Customer;
use App\Models\CustomerCategoryType;
use App\Models\District;
use App\Models\Employee;
use App\Models\Role;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CustomersImport implements ToModel, WithHeadingRow, ShouldQueue, WithChunkReading, WithBatchInserts, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $now = Carbon::now();
        $email = $username = $now->format('YmdHisu') . "@gmail.com";
        $country_id = $state_id = $district_id = $city_id = $area_id = null;

        $role = Role::where('name', $row['customer_type'])->select('id')->first();
        $country = Country::where('name', $row['country'])->select('id')->first();
        if (!isset($country->id)) {
            $country = Country::create(['name' => $row['country']]);
        }
        $country_id = $country->id;

        if ($country_id) {
            $state = State::where('name', $row['state'])->where('country_id', $country->id)->select('id')->first();
            if (!isset($state->id)) {
                $state = State::create([
                    'name' => $row['state'],
                    'country_id' => $country_id
                ]);
            }
            $state_id = $state->id;
        }

        if ($state_id) {
            $district = District::where('name', $row['district'])->where('country_id', $country->id)
                ->where('state_id', $state->id)->select('id')->first();
            if (!isset($district->id)) {
                $district = District::create([
                    'name' => $row['district'],
                    'country_id' => $country_id,
                    'state_id' => $state_id
                ]);
            }
            $district_id = $district->id;
        }

        if ($district_id && $row['city']) {
            $city = City::where('name', $row['city'])
                ->where('country_id', $country->id)
                ->where('state_id', $state->id)
                ->where('district_id', $district->id)
                ->select('id')
                ->first();
            if (!isset($city->id)) {
                $city = City::create([
                    'name' => $row['city'],
                    'country_id' => $country_id,
                    'state_id' => $state_id,
                    'district_id' => $district_id
                ]);
            }
            $city_id = $city->id;
        }

        if ($city_id && $row['city'] && $row['area']) {
            $area = Area::where('name', $row['area'])
                ->where('country_id', $country->id)
                ->where('state_id', $state->id)
                ->where('district_id', $district->id)
                ->where('city_id', $city->id)
                ->select('id')
                ->first();
            if (!isset($area->id)) {
                $area = Area::create([
                    'name' => $row['area'],
                    'country_id' => $country_id,
                    'state_id' => $state_id,
                    'district_id' => $district_id,
                    'city_id' => $city_id
                ]);
            }
            $area_id = $area->id ?? null;
        }

        $user = User::create([
            'name' => $row['name'],
            'username' => $username,
            'email' => $email,
            'password' => Hash::make('Tdh@123'),
        ]);

        return new Customer([
            'id' => $user->id,
            'name' => $row['name'],
            'email' => $email,
            'address' => $row['address'],
            'role_id' => $role->id,
            'country_id' => $country_id,
            'state_id' => $state_id,
            'district_id' => $district_id,
            'customer_code' => $row['customer_code'],
            'mobile_no' => $row['mobile_no'],
            'pin_code' => $row['pin_code'],
            'gst_no' => $row['gst_no'],
            'city_id' => $city_id,
            'area_id' => $area_id,
        ]);
    }

    public function rules(): array
    {
        $customer_types_array = Role::where('role_for', 'customer')->pluck('name');

        return [
            'name' => 'required|distinct|unique:App\Models\Customer,name',
            'gst_no' => 'nullable|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/|min:15|max:15|distinct|unique:App\Models\Customer,gst_no',
            'customer_type' => 'required|' . Rule::in($customer_types_array),
            'country' => 'required',
            'state' => 'required',
            'district' => 'required',
            'address' => 'required',
            'customer_code' => 'nullable|distinct|unique:App\Models\Customer,customer_code',
            'mobile_no' => 'nullable|numeric|digits:10|distinct|unique:App\Models\Customer,mobile_no',
            'pin_code' => 'nullable|numeric|digits:6',            
        ];
    }

    public function customValidationAttributes()
    {
        return [
            'customer_type' => 'Customer Type',
            'gst_no' => 'GST No',
            'customer_code' => 'Customer Code',
            'mobile_no' => 'Mobile Number',
            'pin_code' => 'Pin Code',
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
