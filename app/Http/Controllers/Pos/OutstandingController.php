<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Ipayment;
use App\Models\IpaymentDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OutstandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

     

    public function index(Request $request)
    {
        $customers = Customer::orderBy('name', 'asc')->get();
        if (request()->ajax()) {
            $data =  Invoice::join('customers','invoices.iCustomerID','=', 'customers.id')
                    ->select('invoices.*','customers.name as customer_name')
                    ->where('dRemaining_amount','>','0')->orderBy('iInvoiceID', 'DESC');
            return datatables()->of($data)->addIndexColumn()
                ->addColumn('customer_name', function ($data) {
                    if ($data->customer_name) {
                        $customer_name = $data->customer_name;
                    } else {
                        $customer_name = '';
                    }
                    return $customer_name;
                })
                ->addColumn('vcInvoiceNo', function ($data) {
                    if ($data->vcInvoiceNo) {
                        $vcInvoiceNo = $data->vcInvoiceNo;
                    } else {
                        $vcInvoiceNo = '';
                    }
                    return $vcInvoiceNo;
                })
                ->addColumn('iTotalAmount', function ($data) {
                    if ($data->iTotalAmount) {
                        $iTotalAmount = $data->iTotalAmount;
                    } else {
                        $iTotalAmount = '';
                    }
                    return $iTotalAmount;
                })
                ->addColumn('dAdjusted_amount', function ($data) {
                    if ($data->dAdjusted_amount) {
                        $dAdjusted_amount = $data->dAdjusted_amount;
                    } else {
                        $dAdjusted_amount = '';
                    }
                    return $dAdjusted_amount;
                })
                ->addColumn('dRemaining_amount', function ($data) {
                    if ($data->dRemaining_amount) {
                        $dRemaining_amount = $data->dRemaining_amount;
                    } else {
                        $dRemaining_amount = '';
                    }
                    return $dRemaining_amount;
                })
                ->editColumn('dtInvoiceDate', function ($data) {
                    if ($data->dtInvoiceDate) {
                        $dtInvoiceDate = Carbon::parse($data->dtInvoiceDate)->format("d-m-Y");
                    } else {
                        $dtInvoiceDate = '...';
                    }
                    return $dtInvoiceDate;
                })
                ->addColumn('iInvoiceID', function ($data) {
                    if ($data->iInvoiceID) {
                        $iInvoiceID = $data->iInvoiceID;
                    } else {
                        $iInvoiceID = '';
                    }
                    return $iInvoiceID;
                })
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('customer'))) {
                        $instance->where('customers.id', $request->get('customer'));
                    }
                    if (!empty($request->get('search'))) {
                        $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('vcInvoiceNo', 'LIKE', "%$search%")
                            ->orWhere('iTotalAmount', 'LIKE', "%$search%")
                            ->orWhere('customers.name', 'LIKE', "%$search%")
                            ->orWhere('dRemaining_amount', 'LIKE', "%$search%")
                            ->orWhere('dAdjusted_amount', 'LIKE', "%$search%")
                            ->orWhere('dtInvoiceDate', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['customer_name', 'vcInvoiceNo', 'iTotalAmount', 'dAdjusted_amount', 'dRemaining_amount', 'dtInvoiceDate','iInvoiceID'])->make(true);
            }

        return view('backend.outstanding.index',compact('customers'));
    }
    public function fetchAdjustedPayments(Request $request)
    {
        $data['paymentList'] = IpaymentDetail::join('invoices','ipayment_details.invoice_id','=', 'invoices.iInvoiceID')
            ->join('ipayments','ipayment_details.ipayment_id','=', 'ipayments.id')
            ->select('ipayment_details.*','invoices.vcInvoiceNo as invoce_no','ipayments.payment_mode as pay_mode','ipayments.payment_ref_no as pay_ref_no','ipayments.paid_date as pay_date')
            ->where("invoice_id", $request->invoice_id)
            ->get();


        return response()->json($data);
    }
}
