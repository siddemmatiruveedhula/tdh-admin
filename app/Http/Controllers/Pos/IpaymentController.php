<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Ipayment;
use App\Models\IpaymentDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IpaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

     

     public function index(Request $request)
     {
         if (request()->ajax()) {

            $data =  Ipayment::join('customers','ipayments.customer_id','=', 'customers.id')
            ->join('users','ipayments.created_by','=', 'users.id')
            ->select('ipayments.*','customers.name as customer_name','users.name as created_user')
            ->orderBy('id', 'DESC');
            return datatables()->of($data)->addIndexColumn()
                ->addColumn('action', function ($data) {
                    if ($data->adjusted_amount == 0) {
                        $btn = '<a href="payment-edit/' . $data->id . '"title="Edit Data" class="btn btn-info sm"><i class="fas fa-edit"></i></a>';
                    }else{
                        $btn = '';
                    }
                    return $btn;
                })
                ->addColumn('customer_name', function ($data) {
                    if ($data->customer_name) {
                        $customer_name = $data->customer_name;
                    } else {
                        $customer_name = '';
                    }
                    return $customer_name;
                })
                ->addColumn('payment_mode', function ($data) {
                    if ($data->payment_mode) {
                        $payment_mode = $data->payment_mode;
                    } else {
                        $payment_mode = '';
                    }
                    return $payment_mode;
                })
                ->addColumn('payment_ref_no', function ($data) {
                    if ($data->payment_ref_no) {
                        $payment_ref_no = $data->payment_ref_no;
                    } else {
                        $payment_ref_no = '';
                    }
                    return $payment_ref_no;
                })
                ->addColumn('paid_amount', function ($data) {
                    if ($data->paid_amount) {
                        $paid_amount = $data->paid_amount;
                    } else {
                        $paid_amount = '';
                    }
                    return $paid_amount;
                })
                ->editColumn('paid_date', function ($data) {
                    if ($data->paid_date) {
                        $paid_date = Carbon::parse($data->paid_date)->format("d-m-Y");
                    } else {
                        $paid_date = '...';
                    }
                    return $paid_date;
                })
                ->addColumn('status', function ($data) {
                    if ($data->status=='approved') {
                        $status = 'Approved';
                    } else {
                        $status = 'Not Approved';
                    }
                    return $status;
                })
                ->addColumn('created_user', function ($data) {
                    if ($data->created_user) {
                        $created_user = $data->created_user;
                    } else {
                        $created_user = '';
                    }
                    return $created_user;
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('customer'))) {
                        $instance->where('customers.id', $request->get('customer'));
                    }
                    if (!empty($request->get('search'))) {
                        $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('customers.name', 'LIKE', "%$search%")
                            ->orWhere('payment_mode', 'LIKE', "%$search%")
                            ->orWhere('payment_ref_no', 'LIKE', "%$search%")
                            ->orWhere('paid_amount', 'LIKE', "%$search%")
                            ->orWhere('paid_date', 'LIKE', "%$search%")
                            ->orWhere('ipayments.status', 'LIKE', "%$search%")
                            ->orWhere('users.name', 'LIKE', "%$search%");
                        });
                    }
                })

                ->rawColumns(['customer_name', 'action', 'status', 'payment_mode', 'paid_amount', 'paid_date', 'created_user','payment_ref_no'])->make(true);
        }
        return view('backend.payment.index');
     }
 
     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function create()
     {
         $customers = Customer::active()->orderBy('name', 'asc')->get();
         $paymentTypes = array('CASH'=>'Cash','CHEQUE'=>'Cheque','UPI'=>'UPI','IMPS'=>'IMPS','NEFT'=>'NEFT','RTGS'=>'RTGS');
         return view('backend.payment.create', compact('customers','paymentTypes'));
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
            'payment_ref_no' => 'required|unique:ipayments',
        ];
        $customMessages = [
            'payment_ref_no.unique' => trans('Payment Ref No. already exist'),

        ];
        $this->validate($request, $rules, $customMessages);
         $add_ipayment  = new Ipayment();
         $add_ipayment->customer_id  =  $request->customer_id;
         $add_ipayment->payment_mode  =  $request->payment_mode;
         $add_ipayment->payment_ref_no  =  $request->payment_ref_no;
         $add_ipayment->paid_amount  =  $request->paid_amount;
         $add_ipayment->adjusted_amount  =  0;
         $add_ipayment->remaining_amount  =  $request->paid_amount;
         $add_ipayment->paid_date  =  $request->paid_date;
         $add_ipayment->person_name  =  $request->person_name;
         $add_ipayment->phone_number  =  $request->phone_number;
         $add_ipayment->city  =  $request->city;
         $add_ipayment->status  =  $request->status;
         if ($request->file('payment_proof')) {
             $file = $request->file('payment_proof');
             $savePath = 'upload/payment_proof';
             $filename = time().".".$file->getClientOriginalExtension();
             $file->move(public_path($savePath),$filename);
             $add_ipayment->payment_proof = $savePath.'/'.$filename;
         }
         $add_ipayment->created_by = Auth::user()->id;
         $add_ipayment->save();
 
         $notification = array(
             'message' => 'Payment Added Successfully',
             'alert-type' => 'success'
         );
 
         return redirect()->route('payment.index')->with($notification);
 
     }
 
     /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function show($id)
     {
 
     }
 
     /**
      * Show the form for editing the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function edit($id)
     {
         
         $paymentTypes = array('CASH'=>'Cash','CHEQUE'=>'Cheque','UPI'=>'UPI','IMPS'=>'IMPS','NEFT'=>'NEFT','RTGS'=>'RTGS');
         $payment = Ipayment::findOrFail($id);
         $customers = Customer::active()->orderBy('name', 'asc')->orWhere('id', $payment['customer_id'])->get();
         return view('backend.payment.edit', compact('payment','customers','paymentTypes'));
     }
 
     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function update(Request $request,$id)
     {
        $rules = [
            'payment_ref_no' => 'required|unique:ipayments,payment_ref_no,' . $id,

        ];
        $customMessages = [
            'payment_ref_no.unique' => trans('Payment Ref No. already exist'),

        ];

        $this->validate($request, $rules, $customMessages);
         $ipayment  = Ipayment::findOrFail($id);
         $ipayment->customer_id  =  $request->customer_id;
         $ipayment->payment_mode  =  $request->payment_mode;
         $ipayment->payment_ref_no  =  $request->payment_ref_no;
         $ipayment->paid_amount  =  $request->paid_amount;
         $ipayment->adjusted_amount  =  0;
         $ipayment->remaining_amount  =  $request->paid_amount;
         $ipayment->paid_date  =  $request->paid_date;
         $ipayment->person_name  =  $request->person_name;
         $ipayment->phone_number  =  $request->phone_number;
         $ipayment->city  =  $request->city;
         $ipayment->status  =  $request->status;
         if ($request->file('payment_proof')) {
             $file = $request->file('payment_proof');
             $savePath = 'upload/payment_proof';
             $filename = time().".".$file->getClientOriginalExtension();
             $file->move(public_path($savePath),$filename);
             $ipayment->payment_proof = $savePath.'/'.$filename;
         }
         $ipayment->save();
 
         $notification = array(
             'message' => 'Payment Updated Successfully',
             'alert-type' => 'success'
         );
 
         return redirect()->route('payment.index')->with($notification);
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
 
     public function partialAdjust(Request $request)
     {
        if (request()->ajax()) {
            $data =  Ipayment::join('customers','ipayments.customer_id','=', 'customers.id')
            ->join('users','ipayments.created_by','=', 'users.id')
            ->where('ipayments.status','=','approved')
            ->where('ipayments.remaining_amount', '!=', '0')
            ->select('ipayments.*','customers.name as customer_name','users.name as created_user')
            ->orderBy('id', 'DESC');
            return datatables()->of($data)->addIndexColumn()
                ->addColumn('customer_name', function ($data) {
                    if ($data->customer_name) {
                        $customer_name = $data->customer_name;
                    } else {
                        $customer_name = '';
                    }
                    return $customer_name;
                })
                ->addColumn('payment_mode', function ($data) {
                    if ($data->payment_mode) {
                        $payment_mode = $data->payment_mode;
                    } else {
                        $payment_mode = '';
                    }
                    return $payment_mode;
                })
                ->addColumn('payment_ref_no', function ($data) {
                    if ($data->payment_ref_no) {
                        $payment_ref_no = $data->payment_ref_no;
                    } else {
                        $payment_ref_no = '';
                    }
                    return $payment_ref_no;
                })
                ->addColumn('paid_amount', function ($data) {
                    if ($data->paid_amount) {
                        $paid_amount = $data->paid_amount;
                    } else {
                        $paid_amount = '';
                    }
                    return $paid_amount;
                })
                ->addColumn('remaining_amount', function ($data) {
                    if ($data->remaining_amount) {
                        $remaining_amount = $data->remaining_amount;
                    } else {
                        $remaining_amount = '';
                    }
                    return $remaining_amount;
                })
                ->addColumn('adjusted_amount', function ($data) {
                    if ($data->adjusted_amount) {
                        $adjusted_amount = $data->adjusted_amount;
                    } else {
                        $adjusted_amount = '0';
                    }
                    return $adjusted_amount;
                })
                ->editColumn('paid_date', function ($data) {
                    if ($data->paid_date) {
                        $paid_date = Carbon::parse($data->paid_date)->format("d-m-Y");
                    } else {
                        $paid_date = '...';
                    }
                    return $paid_date;
                })
                ->addColumn('status', function ($data) {
                    if ($data->status=='approved') {
                        $status = 'Approved';
                    } else {
                        $status = 'Not Approved';
                    }
                    return $status;
                })
                ->addColumn('created_user', function ($data) {
                    if ($data->created_user) {
                        $created_user = $data->created_user;
                    } else {
                        $created_user = '';
                    }
                    return $created_user;
                })
                ->addColumn('payment_id', function ($data) {
                    if ($data->id) {
                        $payment_id = $data->id;
                    } else {
                        $payment_id = '';
                    }
                    return $payment_id;
                })
                ->addColumn('customer_id', function ($data) {
                    if ($data->customer_id) {
                        $customer_id = $data->customer_id;
                    } else {
                        $customer_id = '';
                    }
                    return $customer_id;
                })
                ->editColumn('payment_date', function ($data) {
                    if ($data->paid_date) {
                        $payment_date = Carbon::parse($data->paid_date)->format("Y-m-d");
                    } else {
                        $payment_date = '...';
                    }
                    return $payment_date;
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('customer'))) {
                        $instance->where('customers.id', $request->get('customer'));
                    }
                    if (!empty($request->get('search'))) {
                        $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('customers.name', 'LIKE', "%$search%")
                            ->orWhere('payment_mode', 'LIKE', "%$search%")
                            ->orWhere('payment_ref_no', 'LIKE', "%$search%")
                            ->orWhere('paid_amount', 'LIKE', "%$search%")
                            ->orWhere('remaining_amount', 'LIKE', "%$search%")
                            ->orWhere('adjusted_amount', 'LIKE', "%$search%")
                            ->orWhere('paid_date', 'LIKE', "%$search%")
                            ->orWhere('ipayments.status', 'LIKE', "%$search%")
                            ->orWhere('users.name', 'LIKE', "%$search%");
                        });
                    }
                })

                ->rawColumns(['customer_name', 'status', 'payment_mode', 'paid_amount', 'paid_date', 'created_user','remaining_amount','adjusted_amount','payment_id','customer_id','payment_ref_no','payment_date'])->make(true);
        }
        return view('backend.payment.partial_adjust');
     }

     public function fetchOutstandings(Request $request)
    {
        $data['invoices_list'] = Invoice::where("iCustomerID", $request->customer_id)
            ->where('dRemaining_amount', '!=', '0')
            ->where("iStatus", '1')
            ->orderBy('dtCreatedOn','Asc')
            ->get(["iInvoiceID","dRemaining_amount","iOrderID","vcInvoiceNo"]);


        return response()->json($data);
    }
     public function fetchAdjustedInvoices(Request $request)
    {
        $data['paymentInvoices'] = IpaymentDetail::join('invoices','ipayment_details.invoice_id','=', 'invoices.iInvoiceID')
            ->select('ipayment_details.*','invoices.vcInvoiceNo as invoce_no')
            ->where("ipayment_id", $request->payment_id)
            ->get();


        return response()->json($data);
    }

     public function saveAdjustmentPayment(Request $request)
    {
        $add_ipayment_details  = new IpaymentDetail();
         $add_ipayment_details->invoice_id  =  $request->invoice_id;
         $add_ipayment_details->order_id  =  $request->order_id;
         $add_ipayment_details->ipayment_id  =  $request->adjust_payment_id;
         $add_ipayment_details->adjusting_amount  =  $request->adjust_amount;
         $add_ipayment_details->adjusting_date  =  $request->adjust_amount_date;
         $add_ipayment_details->created_by = Auth::user()->id;
         $add_ipayment_details->save();

         $ipayment = Ipayment::find($request->adjust_payment_id);
         $ipayment_update  = Ipayment::findOrFail($request->adjust_payment_id);
         $ipayment_update->adjusted_amount  =  $request->adjust_amount+$ipayment->adjusted_amount;
         $ipayment_update->remaining_amount  =  $ipayment->remaining_amount-$request->adjust_amount;
         $ipayment_update->save();

         $dAdjusted_amount=0;
         $dRemaining_amount=0;
         $invoicepayment_details = Invoice::where("iInvoiceID",$request->invoice_id)->get();
         foreach ($invoicepayment_details as $invoicepayment_detail) {
            if (!empty($invoicepayment_detail)) {
                $dAdjusted_amount=$invoicepayment_detail->dAdjusted_amount;
                $dRemaining_amount=$invoicepayment_detail->dRemaining_amount;
            }
         }
         $invoicepayment_update_details = array('dAdjusted_amount'  =>  $request->adjust_amount+$dAdjusted_amount ,'dRemaining_amount'=>  $dRemaining_amount-$request->adjust_amount);
         $invoice_update=Invoice::where('iInvoiceID', $request->invoice_id)->update($invoicepayment_update_details);
         if ($invoice_update && $add_ipayment_details) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }


        return response()->json($response);
    }


     public function fullyAdjust(Request $request)
     {
        if (request()->ajax()) {
            $data =  Ipayment::join('customers','ipayments.customer_id','=', 'customers.id')
            ->join('users','ipayments.created_by','=', 'users.id')
            ->where('ipayments.status','=','approved')
            ->where('ipayments.remaining_amount', '=', '0')
            ->select('ipayments.*','customers.name as customer_name','users.name as created_user')
            ->orderBy('id', 'DESC');
            return datatables()->of($data)->addIndexColumn()
                ->addColumn('customer_name', function ($data) {
                    if ($data->customer_name) {
                        $customer_name = $data->customer_name;
                    } else {
                        $customer_name = '';
                    }
                    return $customer_name;
                })
                ->addColumn('payment_mode', function ($data) {
                    if ($data->payment_mode) {
                        $payment_mode = $data->payment_mode;
                    } else {
                        $payment_mode = '';
                    }
                    return $payment_mode;
                })
                ->addColumn('payment_ref_no', function ($data) {
                    if ($data->payment_ref_no) {
                        $payment_ref_no = $data->payment_ref_no;
                    } else {
                        $payment_ref_no = '';
                    }
                    return $payment_ref_no;
                })
                ->addColumn('paid_amount', function ($data) {
                    if ($data->paid_amount) {
                        $paid_amount = $data->paid_amount;
                    } else {
                        $paid_amount = '';
                    }
                    return $paid_amount;
                })
                ->editColumn('paid_date', function ($data) {
                    if ($data->paid_date) {
                        $paid_date = Carbon::parse($data->paid_date)->format("d-m-Y");
                    } else {
                        $paid_date = '...';
                    }
                    return $paid_date;
                })
                ->addColumn('status', function ($data) {
                    if ($data->status=='approved') {
                        $status = 'Approved';
                    } else {
                        $status = 'Not Approved';
                    }
                    return $status;
                })
                ->addColumn('created_user', function ($data) {
                    if ($data->created_user) {
                        $created_user = $data->created_user;
                    } else {
                        $created_user = '';
                    }
                    return $created_user;
                })
                ->addColumn('id', function ($data) {
                    if ($data->id) {
                        $id = $data->id;
                    } else {
                        $id = '';
                    }
                    return $id;
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('customer'))) {
                        $instance->where('customers.id', $request->get('customer'));
                    }
                    if (!empty($request->get('search'))) {
                        $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('customers.name', 'LIKE', "%$search%")
                            ->orWhere('payment_mode', 'LIKE', "%$search%")
                            ->orWhere('payment_ref_no', 'LIKE', "%$search%")
                            ->orWhere('paid_amount', 'LIKE', "%$search%")
                            ->orWhere('paid_date', 'LIKE', "%$search%")
                            ->orWhere('ipayments.status', 'LIKE', "%$search%")
                            ->orWhere('users.name', 'LIKE', "%$search%");
                        });
                    }
                })

                ->rawColumns(['customer_name', 'status', 'payment_mode', 'paid_amount', 'paid_date', 'created_user', 'id','payment_ref_no'])->make(true);
        }
        return view('backend.payment.fully_adjust');
     }
    
}
