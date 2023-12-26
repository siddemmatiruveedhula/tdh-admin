<?php

namespace App\Http\Controllers\Pos;

use App\Models\Area;
use App\Models\Beat;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Country;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\District;
use Illuminate\Support\Str;
use App\Models\CustomerType;
use Illuminate\Http\Request;
use App\Models\PaymentDetail;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Imports\CustomersImport;
use App\Models\CustomerCategoryType;
use App\Models\Employee;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Response;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function CustomerAll()
    {

        $customers = Customer::orderBy('id', 'desc')->get();
        return view('backend.customer.customer_all', compact('customers'));
    } // End Method

    public function fetchState(Request $request)
    {
        $data['states'] = State::active()->where("country_id", $request->country_id)
            ->get(["name", "id"]);


        return response()->json($data);
    }
    /**
     * Write code on Method
     *
     * @return response()
     */

    public function fetchDistrict(Request $request)
    {
        $data['districts'] = District::active()->where("state_id", $request->state_id)
            ->get(["name", "id"]);

        return response()->json($data);
    }

    public function fetchCity(Request $request)
    {
        $data['cities'] = City::active()->where("district_id", $request->district_id)
            ->get(["name", "id"]);

        return response()->json($data);
    }
    public function fetchArea(Request $request)
    {
        $data['areas'] = Area::active()->where("city_id", $request->city_id)
            ->get(["name", "id"]);

        return response()->json($data);
    }

    public function CustomerAdd()
    {
        $countries = Country::active()->orderBy('name', 'asc')->get();
        $states = State::orderBy('name', 'asc')->get();
        $districts = District::latest()->get();
        $cities = City::latest()->get();
        $areas = Area::latest()->get();
        $defaultSos = Employee::whereIn('role_id', [2, 3, 9])->get();
        // $customerTypes = CustomerType::orderBy('custom_order', 'asc')->get();
        // $customerTypes = CustomerType::orderBy('custom_order', 'asc')->get();
        $customerCategoryTypes = CustomerCategoryType::latest()->get();
        $beats = Beat::active()->latest()->get();
        $customerRoles = Role::active()->where('role_for', 'customer')->get();
        $distributor_dealers = Customer::whereIn('role_id', [15, 16])->get();
        return view('backend.customer.customer_add', compact('countries', 'beats', 'customerCategoryTypes', 'customerRoles', 'districts', 'cities', 'areas', 'states', 'defaultSos', 'distributor_dealers'));
    }    // End Method


    public function CustomerStore(Request $request)
    {

        if ($request->customer_code != '') {
            $validator = FacadesValidator::make(
                $request->all(),
                [
                    'name' => 'required|unique:customers',
                    // 'email' => 'required|unique:users',
                    'mobile_no' => 'nullable|unique:customers',
                    'customer_code' => 'nullable|unique:customers',
                    'gst_no' => 'nullable|unique:customers',
                ],
                [
                    'name.required' => trans('Name is required'),
                    'name.unique' => trans('Name already exist'),
                    // 'email.unique' => trans('Email ID already exist'),
                    'mobile_no.unique' => trans('Mobile Number already exist'),
                    'customer_code.unique' => trans('Customer Code already exist'),
                    'gst_no.unique' => trans('GST Number already exist'),
                ]
            );
        } else {
            $validator = FacadesValidator::make(
                $request->all(),
                [
                    'name' => 'required|unique:customers',
                    // 'email' => 'required|unique:users',
                    'mobile_no' => 'nullable|unique:customers',
                    'gst_no' => 'nullable|unique:customers',
                ],
                [
                    'name.required' => trans('Name is required'),
                    'name.unique' => trans('Name already exist'),
                    // 'email.unique' => trans('Email ID already exist'),
                    'mobile_no.unique' => trans('Mobile Number already exist'),
                    'gst_no.unique' => trans('GST Number already exist'),
                ]
            );
        }
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        } else {

            $user = new User();
            $user->name       = $request->name;
            $user->email      = $request->gst_no ?? $request->name . '@gmail.com';
            $password         =  $request->gst_no ?? $request->name;
            $user->password   = Hash::make($password);
            $user->username   = $request->gst_no ?? $request->name . '@gmail.com';
            $user->role_id    = $request->customer_type;
            $user->email_verified_at = Carbon::now();

            $user->save();

            $user_id = $user->id;

            $customer = new Customer();
            $customer->id = $user_id;
            if ($request->customer_image) {
                $extention = $request->customer_image->getClientOriginalExtension();
                $image_name = Str::slug($request->name, '-') . '-' . date('Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
                $image = 'upload/customer/' . $image_name;
                $img = Image::make($request->customer_image);
                $img->resize(200, 200, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path() . '/' . $image);
                $customer->customer_image = $image_name;
            }
            $customer->name = $request->name;
            $customer->customer_code = $request->customer_code;
            $customer->customer_alias = $request->customer_alias;
            $customer->mobile_no = $request->mobile_no;
            $customer->email = $request->gst_no ?? $request->name . '@gmail.com';
            $customer->address = $request->address;

            $customer->pin_code = $request->pin_code;
            // $customer->discount_amount = $request->discount_amount;
            $customer->credit_limit = $request->credit_limit;
            $customer->credit_duration = $request->credit_duration;
            $customer->gst_no = $request->gst_no;
            $customer->distributor_cst = $request->distributor_cst;
            $customer->lbt_no = $request->lbt_no;
            $customer->country_id = $request->country_id;
            $customer->state_id = $request->state_id;
            $customer->city_id = $request->city_id;

            $customer->district_id = $request->district_id;
            $customer->area_id = $request->area_id;
            $customer->discount = $request->discount;
            $customer->fssai_no = $request->fssai_no;
            $customer->parent_hierarchy_id = $request->parent_hierarchy_id;

            $customer->role_id = $request->customer_type;
            $customer->customer_category_type = $request->customer_category_type;
            $customer->beat_id = $request->beat_id;
            $customer->communicating_person = $request->communicating_person;
            $customer->default_so = $request->default_so;
            // $customer->customer_image => $save_url ? $save_url : null;
            $customer->created_by = Auth::user()->id;
            $customer->created_at = Carbon::now();
            $customer->save();



            return Response::json(true);
        }
    } // End Method


    public function CustomerEdit($id)
    {
        $countries = Country::active()->orderBy('name', 'asc')->get();
        $states = State::orderBy('name', 'asc')->get();
        $districts = District::latest()->get();
        $cities = City::latest()->get();
        $areas = Area::latest()->get();
        $defaultSos = Employee::whereIn('role_id', [2, 3, 9])->get();
        $customer = Customer::findOrFail($id);
        // $customerTypes = CustomerType::latest()->get();
        $customerCategoryTypes = CustomerCategoryType::latest()->get();
        $beats = Beat::active()->latest()->get();
        $customerRoles = Role::active()->where('role_for', 'customer')->orWhere('id', $customer['role_id'])->get();
        $distributor_dealers = Customer::whereIn('role_id', [15, 16])->get();
        return view('backend.customer.customer_edit', compact('customer', 'beats', 'countries', 'customerRoles', 'customerCategoryTypes', 'states',  'districts',  'cities',  'areas', 'defaultSos', 'distributor_dealers'));
    } // End Method


    public function CustomerUpdate(Request $request)
    {

        $customer_id = $request->id;
        if ($request->customer_code != '') {
            $validator = FacadesValidator::make(
                $request->all(),
                [
                    'name' => 'required|unique:customers,name,' . $request->id,
                    // 'email' => 'required|unique:users,email,' . $request->id,
                    'mobile_no' => 'nullable|unique:customers,mobile_no,' . $request->id,
                    'customer_code' => 'unique:customers,customer_code,' . $request->id,
                    'gst_no' => 'nullable|unique:customers,gst_no,' . $request->id,
                ],
                [
                    'name.required' => trans('Name is required'),
                    'name.unique' => trans('Name already exist'),
                    // 'email.unique' => trans('Email ID already exist'),
                    'mobile_no.unique' => trans('Mobile Number already exist'),
                    'customer_code.unique' => trans('Customer Code already exist'),
                    'gst_no.unique' => trans('GST Number already exist'),
                ]
            );
        } else {
            $validator = FacadesValidator::make(
                $request->all(),
                [
                    'name' => 'required|unique:customers,name,' . $request->id,
                    // 'email' => 'required|unique:users,email,' . $request->id,
                    'mobile_no' => 'nullable|unique:customers,mobile_no,' . $request->id,
                    'gst_no' => 'nullable|unique:customers,gst_no,' . $request->id,
                ],
                [
                    'name.required' => trans('Name is required'),
                    'name.unique' => trans('Name already exist'),
                    // 'email.unique' => trans('Email ID already exist'),
                    'mobile_no.unique' => trans('Mobile Number already exist'),
                    'gst_no.unique' => trans('GST Number already exist'),
                ]
            );
        }
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        } else {
            $user = User::findOrFail($customer_id);
            $user->name       = $request->name;
            $user->email      = $request->gst_no . '@gmail.com';
            $user->username   = $request->gst_no . '@gmail.com';
            $user->role_id    = $request->customer_type;
            // $user->email_verified_at = Carbon::now();
            $user->save();

            $user_id = $user->id;


            $customer = Customer::findOrFail($customer_id);
            $customer->id       = $user_id;
            if ($request->file('customer_image')) {

                $existing_employee = "upload/customer/" . $customer->customer_image;
                $image = $request->file('customer_image');
                $extention = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                // $extention  = $request->customer_image->getClientOriginalExtension();
                $image_name = Str::slug($request->name, '-') . '-' . date('Y-m-d-h-i-s-') . rand(999, 9999) . '.' . $extention;
                $image = 'upload/customer/' . $image_name;
                $img   = Image::make($request->customer_image);
                $img->resize(200, 200, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path() . '/' . $image);

                if ($existing_employee && $customer->customer_image) {
                    if (File::exists(public_path() . '/' . $existing_employee)) unlink(public_path() . '/' . $existing_employee);
                }
                $customer->customer_image = $image_name;
                // $customer->save();
                // dd($customer);
            }
            $customer->name = $request->name;
            $customer->customer_code = $request->customer_code;
            $customer->customer_alias = $request->customer_alias;
            $customer->mobile_no = $request->mobile_no;
            $customer->email = $request->gst_no . '@gmail.com';
            $customer->address = $request->address;

            $customer->pin_code = $request->pin_code;
            // $customer->discount_amount = $request->discount_amount;
            $customer->credit_limit = $request->credit_limit;
            $customer->credit_duration = $request->credit_duration;
            $customer->gst_no = $request->gst_no;
            $customer->distributor_cst = $request->distributor_cst;
            $customer->lbt_no = $request->lbt_no;
            $customer->country_id = $request->country_id;
            $customer->state_id = $request->state_id;
            $customer->city_id = $request->city_id;

            $customer->district_id = $request->district_id;
            $customer->area_id = $request->area_id;
            $customer->discount = $request->discount;
            $customer->fssai_no = $request->fssai_no;
            $customer->parent_hierarchy_id = $request->parent_hierarchy_id;

            $customer->role_id = $request->customer_type;
            $customer->customer_category_type = $request->customer_category_type;
            $customer->beat_id = $request->beat_id;
            $customer->communicating_person = $request->communicating_person;
            $customer->default_so = $request->default_so;
            // $customer->customer_image => $save_url ? $save_url : null;
            $customer->created_by = Auth::user()->id;
            $customer->created_at = Carbon::now();
            $customer->save();

            return Response::json(true);

            // $notification = array(
            //     'message' => 'Customer Updated Successfully',
            //     'alert-type' => 'success'
            // );

            // return redirect()->route('customer.all')->with($notification);
        }
    } // End Method

    public function resetPassword($id)
    {
        $user = User::find($id);
        return view('backend.customer.reset_password', compact('user'));
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

    public function CustomerDelete($id)
    {

        $customers = Customer::findOrFail($id);
        $img = $customers->customer_image;
        unlink($img);

        Customer::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Customer Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method


    public function CreditCustomer()
    {

        $allData = Payment::whereIn('paid_status', ['full_due', 'partial_paid'])->get();
        return view('backend.customer.customer_credit', compact('allData'));
    } // End Method


    public function CreditCustomerPrintPdf()
    {

        $allData = Payment::whereIn('paid_status', ['full_due', 'partial_paid'])->get();
        return view('backend.pdf.customer_credit_pdf', compact('allData'));
    } // End Method



    public function CustomerEditOrder($order_id)
    {

        $payment = Payment::where('order_id', $order_id)->first();
        return view('backend.customer.edit_customer_order', compact('payment'));
    } // End Method


    public function CustomerUpdateOrder(Request $request, $order_id)
    {

        if ($request->new_paid_amount < $request->paid_amount) {

            $notification = array(
                'message' => 'Sorry You Paid Maximum Value',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } else {
            $payment = Payment::where('order_id', $order_id)->first();
            $payment_details = new PaymentDetail();
            $payment->paid_status = $request->paid_status;

            if ($request->paid_status == 'full_paid') {
                $payment->paid_amount = Payment::where('order_id', $order_id)->first()['paid_amount'] + $request->new_paid_amount;
                $payment->due_amount = '0';
                $payment_details->current_paid_amount = $request->new_paid_amount;
            } elseif ($request->paid_status == 'partial_paid') {
                $payment->paid_amount = Payment::where('order_id', $order_id)->first()['paid_amount'] + $request->paid_amount;
                $payment->due_amount = Payment::where('order_id', $order_id)->first()['due_amount'] - $request->paid_amount;
                $payment_details->current_paid_amount = $request->paid_amount;
            }

            $payment->save();
            $payment_details->order_id = $order_id;
            $payment_details->date = date('Y-m-d', strtotime($request->date));
            $payment_details->updated_by = Auth::user()->id;
            $payment_details->save();

            $notification = array(
                'message' => 'Order Update Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('credit.customer')->with($notification);
        }
    } // End Method



    public function CustomerOrderDetails($order_id)
    {

        $payment = Payment::where('order_id', $order_id)->first();
        return view('backend.pdf.order_details_pdf', compact('payment'));
    } // End Method

    public function PaidCustomer()
    {
        $allData = Payment::where('paid_status', '!=', 'full_due')->get();
        return view('backend.customer.customer_paid', compact('allData'));
    } // End Method

    public function PaidCustomerPrintPdf()
    {

        $allData = Payment::where('paid_status', '!=', 'full_due')->get();
        return view('backend.pdf.customer_paid_pdf', compact('allData'));
    } // End Method


    public function CustomerWiseReport()
    {

        $customers = Customer::all();
        return view('backend.customer.customer_wise_report', compact('customers'));
    } // End Method


    public function CustomerWiseCreditReport(Request $request)
    {

        $allData = Payment::where('customer_id', $request->customer_id)->whereIn('paid_status', ['full_due', 'partial_paid'])->get();
        return view('backend.pdf.customer_wise_credit_pdf', compact('allData'));
    } // End Method


    public function CustomerWisePaidReport(Request $request)
    {

        $allData = Payment::where('customer_id', $request->customer_id)->where('paid_status', '!=', 'full_due')->get();
        return view('backend.pdf.customer_wise_paid_pdf', compact('allData'));
    } // End Method

    public function changeStatus(Request $request, $id)
    {

        $customer = Customer::findOrFail($id);
        $message = "Updated Successfully";

        if ($customer->status == 1) {
            $customer->status = 0;
            $customer->save();
            $message = "Inactive Successfully";
        } else {
            $customer->status = 1;
            $customer->save();
            $message = "Active Successfully";
        }

        return response()->json($message);
    }

    public function importCustomers()
    {
        // $name = 'india';
        // $state_array = State::whereHas('country', function ($query) use ($name) {
        //     $query->where('name',  $name);
        // })->pluck('name');

        // dd($state_array);

        return view('backend.customer.customer_import');
    }

    public function storeImportCustomers()
    {
        // dd('test');

        try {
            Excel::queueImport(new CustomersImport(), request()->file('file'));
        } catch (ValidationException $e) {
            $failures = $e->failures();

            dd($failures);

            // return view('employee.importError', compact('failures'));
        }

        $notification = array(
            'message' => 'Customers data was successfully imported.',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function downloadFile()
    {
        $filepath = public_path('imports/customer_details.xlsx');
        return Response::download($filepath); 
    }
}
