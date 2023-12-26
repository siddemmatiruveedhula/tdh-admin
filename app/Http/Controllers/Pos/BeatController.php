<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Beat;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\District;
use App\Models\Customer;
use App\Models\Eod;
use App\Models\Order;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class BeatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function fetchState(Request $request)
    {
        $data['states'] = State::active()->where("country_id", $request->country_id)
            ->get(["name", "id"]);


        return response()->json($data);
    }
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

    public function index()
    {
        $beats = Beat::withCount('customers')->orderBy('id', 'DESC')->get();

        return view('backend.configuration.beat.index', compact('beats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::select('cities.*','districts.name as district_name','states.name as states_name','countries.name as countrie_name')
                  ->Join('districts', 'cities.district_id', '=', 'districts.id')
                  ->Join('states', 'cities.state_id', '=', 'states.id')
                  ->Join('countries', 'cities.country_id', '=', 'countries.id')
                  ->where('cities.status',true)
                  ->get();
        $suppliers = Customer::join('roles','customers.role_id','=', 'roles.id')
        ->select('customers.*','roles.name as customer_type_name')
        ->whereIn('customers.role_id',array(15,16))->orderBy('name')->get();
        return view('backend.configuration.beat.create', compact('cities','suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = FacadesValidator::make(
            $request->all(),
            [
                'name' => 'required|unique:beats',
            ],
            [
                'name.required' => trans('Name is required'),
                'name.unique' => trans('Name already exist'),
            ]
        );
        

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        } else {

        $beat  = new Beat();
        $beat->name  =  $request->name;
        $beat->city_id = $request->city_id;
        $beat->supplier_id  =  $request->supplier_id;
        $beat->status  =  $request->status;

        $beat->save();
        return Response::json(true);

        }
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
        $beat = Beat::find($id);
        // dd($post);
        $customers = Customer::where('beat_id', '=', $beat->id)->get();

        return view('backend.configuration.beat.show', compact('customers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $suppliers = Customer::join('roles','customers.role_id','=', 'roles.id')
        ->select('customers.*','roles.name as customer_type_name')
        ->whereIn('customers.role_id',array(15,16))->orderBy('name')->get();
        $cities = City::select('cities.*','districts.name as district_name','states.name as states_name','countries.name as countrie_name')
                  ->Join('districts', 'cities.district_id', '=', 'districts.id')
                  ->Join('states', 'cities.state_id', '=', 'states.id')
                  ->Join('countries', 'cities.country_id', '=', 'countries.id')
                  ->where('cities.status',true)
                  ->get();
        $beat = Beat::findOrFail($id);
        return view('backend.configuration.beat.edit', compact('cities','suppliers', 'beat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $beat_id = $request->id;
        $validator = FacadesValidator::make(
            $request->all(),
            [
                'name' => 'required|unique:beats,name,' . $request->id,
            ],
            [
                'name.required' => trans('Name is required'),
                'name.unique' => trans('Name already exist'),
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        } else {

        $beat = Beat::findOrFail($beat_id);
        $beat->name  =  $request->name;
        $beat->city_id = $request->city_id;
        $beat->supplier_id  =  $request->supplier_id;
        $beat->status  =  $request->status;

        $beat->save();
        return Response::json(true);
        }
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

        $area = Beat::findOrFail($id);
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

    public function beatReport()
    {
        $eods = Eod::latest()->get();        

        return view('backend.configuration.beat.beat_report',compact('eods'));
    }

    public function assignCustomersToBeat($id)
    {

        $customers = Customer::whereNull('beat_id')->orderBy('name')->get();
        $beat_customers = Customer::where('beat_id',$id)->orderBy('name')->get();
        $beat = Beat::findOrFail($id);

        return view('backend.configuration.beat.assign_customers_to_beat', compact('beat', 'customers','beat_customers'));
    }

    public function updateBeatCustomers(Request $request, $id)
    {
        Customer::where('beat_id', $id)->update(['beat_id' => null]);

        if (count($request->customers) > 0) {
            foreach ($request->customers as $customer) {
                $cust = Customer::find($customer);
                $cust->beat_id = $id;
                $cust->save();
            }
        }

        $notification = array(
            'message' => 'Customers Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('beat.index')->with($notification);
    }

    public function viewBeat($eod_id)
    {       

        
        $eod = Eod::findOrFail($eod_id);

        $orders = Order::where('created_by',$eod->employee_id)->where('date',$eod->date)->get();        

        return view('backend.configuration.beat.beat_view', compact('orders','eod'));
    }
}
