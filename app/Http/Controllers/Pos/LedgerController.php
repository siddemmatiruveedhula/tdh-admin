<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

     

    public function index(Request $request)
    {
        $customers = Customer::active()->orderBy('name', 'asc')->get();
        $cus_id=0;
        $balance_amount=0;
        $from_date='';
        $to_date='';
        $debit=0;
        $credit=0;
        $ledger_rows=array();
        if ($request->method()=='POST'){
            $cus_id=$request->customer_id;
            $from_date=$request->from_date;
            $to_date=$request->to_date;
            $balance_sql="SELECT sum(amount) balance from
            (
            SELECT `dtInvoiceDate` as doc_date,'Tax Invoice' transaction_name,`vcInvoiceNo` as ref_no,`iTotalAmount` as amount,'Debit' transaction_type,`iCustomerID` as cus_id FROM `invoices` where iStatus='1'
            UNION ALL
            SELECT `paid_date` as doc_date,'Payment' transaction_name,`payment_ref_no` as ref_no,-`paid_amount` as amount,'Credit' transaction_type,customer_id as cus_id FROM `ipayments` where status='approved'
            )temp where doc_date<'". $request->from_date ."' and cus_id='". $request->customer_id ."'";
            $data = DB::select($balance_sql);
            foreach ($data as $bal) {
                $balance_amount=$bal->balance;
            }
            $ledger_rows_sql="select * from (
                SELECT i.dtInvoiceDate as doc_date,'Tax Invoice' transaction_name,o.order_no as order_number,i.vcInvoiceNo as ref_no,i.iTotalAmount as amount,'Debit' transaction_type,i.iCustomerID as cus_id FROM `invoices` i JOIN orders o on o.id=i.iOrderID where i.iStatus='1'
                UNION ALL
                SELECT `paid_date` as doc_date,'Payment' transaction_name,'' as order_number,`payment_ref_no` as ref_no,`paid_amount` as amount,'Credit' transaction_type,customer_id as cus_id FROM `ipayments` where status='approved'
                )temp where doc_date BETWEEN '" . $request->from_date . "' and '" . $request->to_date . "' and cus_id = '" . $request->customer_id ."' order by doc_date" ;
            $ledger_rows = DB::select($ledger_rows_sql);
        }
        return view('backend.ledger.index',compact('customers','balance_amount','cus_id','from_date','to_date','ledger_rows','debit','credit'));
    }
}
