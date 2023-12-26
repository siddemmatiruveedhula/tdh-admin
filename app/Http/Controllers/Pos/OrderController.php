<?php

namespace App\Http\Controllers\Pos;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Unit;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Purchase;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\OrderDetail;
use App\Models\PaymentDetail;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\IpaymentDetail;

class OrderController extends Controller
{
    public function OrderAll()
    {
        $allData = Order::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', '1')->get();
        return view('backend.order.order_all', compact('allData'));
    } // End Method


    public function orderAdd()
    {
        $supplier = Supplier::active()->get();
        $customerInfo = Customer::select('id','name','mobile_no','customer_code','discount')->where('status',1)->get();
        $products = Product::select('id','name','default_price','min_price','max_price')->where('status',1)->get();
        $order_data = Order::orderBy('id', 'desc')->first();
        if ($order_data == null) {
            $firstReg = '0';
            $order_no = $firstReg + 1;
        } else {
            $order_data = Order::orderBy('id', 'desc')->first()->order_no;
            $order_no = $order_data + 1;
        }
        $date = date('Y-m-d');
        $paymentStatus = array(
            "full_paid"=>"Full Paid",
            "full_due"=>"Full Due",
            "partial_paid"=>"Partial Paid"
        );
        $paymentType = array('CASH'=>'Cash','CHEQUE'=>'Cheque','UPI'=>'UPI','IMPS'=>'IMPS','NEFT'=>'NEFT','RTGS'=>'RTGS');
        return view('backend.order.order_add', compact('order_no','date', 'customerInfo','products','paymentStatus','paymentType','supplier'));
    } // End Method


    public function OrderStore(Request $request)
    {
        // $rules = [
        //     'paid_status' => 'required',
            
        // ];
        // $customMessages = [
        //     'paid_status.required' => trans('Paid status is required'),
        // ];
        // $this->validate($request, $rules, $customMessages);

        if (count($request->product_id)==0) {

            $notification = array(
                'message' => 'Sorry You do not select any item',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } else {

            if ($request->paid_amount > $request->estimated_amount) {

                $notification = array(
                    'message' => 'Sorry Paid Amount is Maximum the total price',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            } else {
                $error = 0 ;
                $order = new Order();
                $order->order_no = $request->order_no;
                $order->date = date('Y-m-d', strtotime($request->date));
                $order->supplier_id = $request->supplier_id;
                $order->description = $request->description;
                $order->status = '0';
                $order->created_by = Auth::user()->id;

                DB::transaction(function () use ($request, $order) {
                    if ($order->save()) {
                        Order::where('id',$order->id)->update(['order_no'=>$order->id+1]);
                        $order->order_no = $order->id+1;
                        for ($i = 0; $i < count($request->product_id); $i++) {
                            $currentProduct = Product::find($request->product_id[$i]);
                            $order_details = new OrderDetail();
                            $order_details->date = date('Y-m-d', strtotime($request->date));
                            $order_details->order_id = $order->id;
                            $order_details->category_id = $currentProduct->category_id;
                            $order_details->product_id = $request->product_id[$i];
                            $order_details->selling_qty = $request->selling_qty[$i];
                            $order_details->unit_price = $request->unit_price[$i];
                            $order_details->selling_price = $request->selling_price[$i];
                            $order_details->selling_qtl = $request->selling_qty[$i] * $currentProduct->total_weight_in_qtl;
                            $order_details->status = '0';
                            $order_details->save();
                        }

                        if ($request->customer_id == '0') {
                            $customer = new Customer();
                            $customer->name = $request->name;
                            $customer->mobile_no = $request->mobile_no;
                            $customer->email = $request->email;
                            $customer->save();
                            $customer_id = $customer->id;
                        } else {
                            $customer_id = $request->customer_id;
                        }

                        $payment = new Payment();
                        $payment_details = new PaymentDetail();

                        $payment->order_id = $order->id;
                        $payment->customer_id = $customer_id;
                        $payment->paid_status = $request->paid_status;
                        $payment->discount_type = $request->discount_type;
                        $payment->discount_percentage = $request->discount_percentage;
                        $payment->discount_amount = $request->discount_amount;
                        $payment->total_amount = $request->estimated_amount;
                        $payment->shipping_amount = $request->shipping_amount;

                        // if ($request->paid_status == 'full_paid') {
                        //     $payment->paid_amount = $request->estimated_amount;
                        //     $payment->due_amount = '0';
                        //     $payment_details->current_paid_amount = $request->estimated_amount;
                        // } elseif ($request->paid_status == 'full_due') {
                            $payment->paid_amount = '0';
                            $payment->due_amount = $request->estimated_amount;
                            $payment_details->current_paid_amount = '0';
                        // } elseif ($request->paid_status == 'partial_paid') {
                        //     $payment->paid_amount = $request->paid_amount;
                        //     $payment->due_amount = $request->estimated_amount - $request->paid_amount;
                        //     $payment_details->current_paid_amount = $request->paid_amount;
                        // }
                        $payment->save();

                        if ($request->file('payment_proof')) {
                            $file = $request->file('payment_proof');
                            $savePath = 'upload/order_payment_proof';
                            $filename = $order->id."_".time().".".$file->getClientOriginalExtension();
                            $file->move(public_path($savePath),$filename);
                            $payment_details->payment_proof = $savePath.'/'.$filename;
                        }
                         
                        $payment_details->order_id = $order->id;
                        $payment_details->date = date('Y-m-d', strtotime($request->payment_date));
                        $payment_details->payment_mode = $request->payment_mode;
                        $payment_details->person_name = $request->payment_person_name;
                        $payment_details->phone_number = $request->payment_phone_number;
                        $payment_details->city = $request->payment_city;
                        $payment_details->save();
                    }
                });
            } // end else 
        }

        $notification = array(
            'message' => 'Order Data Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('order.pending.list')->with($notification);
    } // End Method


    public function PendingList()
    {
        $allData = Order::with('createdBy')->orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', '0')->get();
        return view('backend.order.order_pending_list', compact('allData'));
    } // End Method



    public function OrderDelete($id)
    {

        $order = Order::findOrFail($id);
        $order->delete();
        OrderDetail::where('order_id', $order->id)->delete();
        Payment::where('order_id', $order->id)->delete();
        PaymentDetail::where('order_id', $order->id)->delete();

        $notification = array(
            'message' => 'Order Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // End Method



    public function OrderApprove($id)
    {

        $order = Order::with('order_details')->findOrFail($id);
        return view('backend.order.order_approve', compact('order'));
    } // End Method


    public function ApprovalStore(Request $request, $id)
    {

        foreach ($request->selling_qty as $key => $val) {
            $order_details = OrderDetail::where('id', $key)->first();
            $product = Product::where('id', $order_details->product_id)->first();
            if ($product->quantity < $request->selling_qty[$key]) {

                $notification = array(
                    'message' => 'Sorry you approve Maximum Value',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
        } // End foreach 

        $order = Order::findOrFail($id);
        $order->updated_by = Auth::user()->id;
        $order->status = '1';

        DB::transaction(function () use ($request, $order, $id) {
            foreach ($request->selling_qty as $key => $val) {
                $order_details = OrderDetail::where('id', $key)->first();

                $order_details->status = '1';
                $order_details->save();

                $product = Product::where('id', $order_details->product_id)->first();
                $product->quantity = ((float)$product->quantity) - ((float)$request->selling_qty[$key]);
                $product->save();
            } // end foreach

            $order->save();
        });

        $notification = array(
            'message' => 'Order Approve Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('order.pending.list')->with($notification);
    } // End Method


    public function PrintOrderList()
    {

        $allData = Order::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', '1')->get();
        return view('backend.order.print_order_list', compact('allData'));
    } // End Method


    public function PrintOrder($id)
    {
        $order = Order::with('order_details')->findOrFail($id);
        return view('backend.pdf.order_pdf', compact('order'));
    } // End Method


    public function DailyOrderReport()
    {
        return view('backend.order.daily_order_report');
    } // End Method


    public function DailyOrderPdf(Request $request)
    {

        $sdate = date('Y-m-d', strtotime($request->start_date));
        $edate = date('Y-m-d', strtotime($request->end_date));
        $allData = Order::whereBetween('date', [$sdate, $edate])->where('status', '1')->get();


        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date = date('Y-m-d', strtotime($request->end_date));
        return view('backend.pdf.daily_order_report_pdf', compact('allData', 'start_date', 'end_date'));
    } // End Method

    /* Start : Edit OR Update Order  */
    public function OrderEdit($id){
        $products = Product::select('id','name','default_price','min_price','max_price')->where('status',1)->get();
        $orderInfo = Order::with('order_details')->with('payment')->with('paymentDetail')->find((int) $id);
        if(!$orderInfo || !is_numeric($id))
        {
            $notification = array(
                'message' => 'Invalid Request',
                'alert-type' => 'error'
            );
            return redirect()->route('order.pending.list')->with($notification);
        }
        if($orderInfo->status=='1')
        {
            $notification = array(
                'message' => 'Invalid Request, Order Alredy Approved',
                'alert-type' => 'error'
            );
            return redirect()->route('order.pending.list')->with($notification);
        }

        $customerInfo = Customer::select('id','name','mobile_no','customer_code','discount')->findOrFail($orderInfo->payment->customer_id);
        $paymentStatus = array(
            "full_paid"=>"Full Paid",
            "full_due"=>"Full Due",
            "partial_paid"=>"Partial Paid"
        );
        $supplier = Supplier::active()->orWhere('id', '=', $orderInfo['supplier_id'])->get();
        $paymentType = array('CASH'=>'Cash','CHEQUE'=>'Cheque','UPI'=>'UPI','IMPS'=>'IMPS','NEFT'=>'NEFT','RTGS'=>'RTGS');
        return view('backend.order.order_edit',compact('products','customerInfo','orderInfo','paymentStatus','paymentType','supplier'));
    } // End Method 

    public function OrderUpdate(Request $request){
        $orderUpdateID = base64_decode($request->ouid);
        if(is_numeric($orderUpdateID))
        {
            $orderStatus = (isset($_REQUEST['approve']))?'1':'0';
            $orderInfo= Order::find($orderUpdateID);
            if($orderInfo->status=='1')
            {
                $notification = array(
                    'message' => 'Invalid Request, Order Alredy Approved',
                    'alert-type' => 'error'
                );
                return redirect()->route('order.pending.list')->with($notification);
            }
            if($orderInfo)
            {
                if($orderStatus){
                    $orderInfo->status = $orderStatus;
                    $orderInfo->save();
                }
                Order::findOrFail($orderInfo->id)->update([
                    'supplier_id' => $request->supplier_id,
                ]);
                OrderDetail::where('order_id',$orderInfo->id)->delete();

                DB::transaction(function () use ($request, $orderInfo, $orderStatus) {
                    for ($i = 0; $i < count($request->product_id); $i++) {
                        $currentProduct = Product::find($request->product_id[$i]);
                        $order_details = new OrderDetail();
                        $order_details->date = date('Y-m-d', strtotime($request->date));
                        $order_details->order_id = $orderInfo->id;
                        $order_details->category_id = $currentProduct->category_id;
                        $order_details->product_id = $request->product_id[$i];
                        $order_details->selling_qty = $request->selling_qty[$i];
                        $order_details->unit_price = $request->unit_price[$i];
                        $order_details->selling_price = $request->selling_price[$i];
                        $order_details->selling_qtl = $request->selling_qty[$i] * $currentProduct->total_weight_in_qtl;
                        $order_details->status = $orderStatus;
                        $order_details->save();
                    }

                    $payment = Payment::where('order_id',$orderInfo->id)->first();
                    $payment_details = PaymentDetail::where('order_id',$orderInfo->id)->first();

                    $payment->paid_status = $request->paid_status;
                    $payment->discount_type = $request->discount_type;
                    $payment->discount_percentage = $request->discount_percentage;
                    $payment->discount_amount = $request->discount_amount;
                    $payment->total_amount = $request->estimated_amount;
                    $payment->shipping_amount = $request->shipping_amount;

                    // if ($request->paid_status == 'full_paid') {
                    //     $payment->paid_amount = $request->estimated_amount;
                    //     $payment->due_amount = '0';
                    //     $payment_details->current_paid_amount = $request->estimated_amount;
                    // } elseif ($request->paid_status == 'full_due') {
                        $payment->paid_amount = '0';
                        $payment->due_amount = $request->estimated_amount;
                        $payment_details->current_paid_amount = '0';
                    // } elseif ($request->paid_status == 'partial_paid') {
                    //     $payment->paid_amount = $request->paid_amount;
                    //     $payment->due_amount = $request->estimated_amount - $request->paid_amount;
                    //     $payment_details->current_paid_amount = $request->paid_amount;
                    // }
                    $payment->save();

                    if ($request->file('payment_proof')) {
                        $file = $request->file('payment_proof');
                        $savePath = 'upload/order_payment_proof';
                        $filename = $orderInfo->id."_".time().".".$file->getClientOriginalExtension();
                        $file->move(public_path($savePath),$filename);
                        $payment_details->payment_proof = $savePath.'/'.$filename;
                    }

                    $payment_details->date = date('Y-m-d', strtotime($request->payment_date));
                    $payment_details->payment_mode = $request->payment_mode;
                    $payment_details->person_name = $request->payment_person_name;
                    $payment_details->phone_number = $request->payment_phone_number;
                    $payment_details->city = $request->payment_city;
                    $payment_details->save();
                });    

                $notification = array(
                    'message' => 'Order Details Updated '.(($orderStatus)?' & Approved':'').' Successfully',
                    'alert-type' => 'success'
                );
                return redirect()->route('order.pending.list')->with($notification);
        
            }
        }
        $notification = array(
            'message' => 'Invalid Request',
            'alert-type' => 'error'
        );
        return redirect()->route('order.pending.list')->with($notification);
    }
    /* End : Edit OR Update Order  */
    public function OrderConvertToPending($id){
        $orderInfo = Order::find((int) $id);
        if(!$orderInfo || !is_numeric($id))
        {
            $notification = array(
                'message' => 'Invalid Request',
                'alert-type' => 'error'
            );
            return redirect()->route('order.pending.list')->with($notification);
        }
        $orderInfo->status='0';
        $orderInfo->save();
        OrderDetail::where('order_id',$orderInfo->id)->update(['status' => '0']);;
        $notification = array(
            'message' => 'Selected Order Moved To Pending Orders',
            'alert-type' => 'success'
        );
        return redirect()->route('print.order.list')->with($notification);

    }
    public function fetchInvoices(Request $request)
    {
        $data['invoices'] = Invoice::where("iCustomerID", $request->customer_id)
                            ->orderBy('iInvoiceID','DESC')
                            ->skip(0)
                            ->take(3)
                            ->get();


        return response()->json($data);
    }
}
