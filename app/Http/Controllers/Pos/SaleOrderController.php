<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\SaleOrder;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleOrderController extends Controller
{
    public function index()
    {
        $sale_orders=SaleOrder::orderBy('id', 'DESC')->get();
        return view('backend.saleorder.index', compact('sale_orders'));
    } // End Method 

    public function edit($id)
    {
        $date=date('Y-m-d');
        $visitors=Visitor::where('check_in_date','=',$date)->whereNull('check_out_time')->get();
        $sale_order = SaleOrder::findOrFail($id);
        return view('backend.saleorder.edit', compact('sale_order','visitors'));
    }
    public function update(Request $request,$id)
    {
        $rules = [
            'bill_no' => 'required|unique:sale_orders,bill_no,' . $id,

        ];
        $customMessages = [
            'bill_no.unique' => trans('Bill No. already exist'),

        ];

        $this->validate($request, $rules, $customMessages);
        $saleorder  = SaleOrder::findOrFail($id);
         $saleorder->visitor_id  =  $request->visitor_id;
         $saleorder->bill_no  =  $request->bill_no;
         $saleorder->amount  =  $request->amount;
         $saleorder->updated_by = Auth::user()->id;
         
         $saleorder->save();
 
         $notification = array(
             'message' => 'Sale Order Updated Successfully',
             'alert-type' => 'success'
         );
 
         return redirect()->route('saleorder.index')->with($notification);
    }
}
