<?php
 
namespace App\Http\Controllers\Pos;

use App\Models\User;
use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\InvoiceDetail;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function InvoiceList(){
        $invoices = Invoice::orderBy('iInvoiceID','desc')->where('iStatus','1')->get();
        return view('backend.invoice.index', compact('invoices'));
    }
    public function GenrateInvoice($id){

        $orderInfo = Order::find((int) $id);
        $supplier = Supplier::active()->orWhere('id', '=', $orderInfo['supplier_id'])->get();
        if(!$orderInfo || !is_numeric($id))
        {
            $notification = array(
                'message' => 'Invalid Request',
                'alert-type' => 'error'
            );
            return redirect()->route('print.order.list')->with($notification);
        }
        $products = Product::select('id','name','default_price','min_price','max_price')->where('status',1)->get();
        $customerInfo = Customer::select('id','name','mobile_no','customer_code','discount')->findOrFail($orderInfo->payment->customer_id);
        $discountTypes = array(
            'percentage'=>'Percentage (%)',
            'cash'=>'Cash (₹)',
            'transport'=>'Transport (₹)'
        );

        return view('backend.invoice.genrate',compact('orderInfo','customerInfo','discountTypes','products','supplier'));
    }

    public function GenrateInvoiceStore(Request $request)
    {
        try 
        {
            if (count($request->product_id)==0) {

                $notification = array(
                    'message' => 'Sorry You do not select any item',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            } 
            $orderID = base64_decode($request->ouid);
            if(is_numeric($orderID))
            {
                $orderInfo= Order::find($orderID);
                if($orderInfo)
                {
                    DB::beginTransaction();
                    $saveInvoice = new Invoice();
                    $saveInvoice->vcInvoiceNo = $request->invoice_no;
                    $saveInvoice->dtInvoiceDate = date('Y-m-d', strtotime($request->invoice_date));
                    $saveInvoice->iOrderID = $orderID;
                    $saveInvoice->iSupplierID = $request->supplier_id;
                    $saveInvoice->iCustomerID = $request->customer_id;
                    $saveInvoice->vcDiscountType = $request->discount_type;
                    $shippingAmount = $request->shipping_amount;
                    if($saveInvoice->vcDiscountType=='percentage'){
                        $saveInvoice->iDiscountPercentage = $request->discount_percentage;
                        $discount_amount = $request->discount_amount;
                    }
                    else // if discount type is Cash or Transport
                    {
                        $discount_amount = $request->discount_amount;
                    }
                    $saveInvoice->iDiscountAmount = $discount_amount;
                    $saveInvoice->iShippingAmount = $shippingAmount;
                    $saveInvoice->vcDescription = $request->description;
                    $saveInvoice->iTotalAmount = $request->invoice_amount;
                    $saveInvoice->dRemaining_amount = $request->invoice_amount;
                    $saveInvoice->iloading_status = 'not_loaded';
                    
                    if ($request->file('invoice_document')) {
                        $file = $request->file('invoice_document');
                        $savePath = 'upload/invoice';
                        $filename = time().".".$file->getClientOriginalExtension();
                        $file->move(public_path($savePath),$filename);
                        $saveInvoice->vcInvoiceDocument = $savePath.'/'.$filename;
                    }

                    $saveInvoice->iCreatedBy = Auth::user()->id;
                    $saveInvoice->iModifiedBy = Auth::user()->id;

                    $saveInvoice->save();

                    $invoiceTotal = 0;
                    foreach($request->product_id as $lkey=>$lvalue)
                    {
                        $selProductDetail = Product::find($request->product_id[$lkey]);
                        $saveInvoiceDetails = new InvoiceDetail();
                        $saveInvoiceDetails->iInvoiceID = $saveInvoice->id;
                        $saveInvoiceDetails->iProductID = $selProductDetail->id;
                        $saveInvoiceDetails->iCategoryID = $selProductDetail->category_id;
                        $saveInvoiceDetails->iSellingQty = $request->selling_qty[$lkey];
                        $saveInvoiceDetails->iSellingPrice = $request->unit_price[$lkey];
                        $saveInvoiceDetails->iSellingTotalPrice = $saveInvoiceDetails->iSellingQty * $saveInvoiceDetails->iSellingPrice;
                        $saveInvoiceDetails->selling_qtl = $saveInvoiceDetails->iSellingQty * $selProductDetail->total_weight_in_qtl;
                        $saveInvoiceDetails->iCreatedBy = Auth::user()->id;
                        $saveInvoiceDetails->iModifiedBy = Auth::user()->id;
                        $invoiceTotal +=$saveInvoiceDetails->iSellingTotalPrice;
                        $saveInvoiceDetails->save();
                    }
                    $estimatedAmount = $invoiceTotal+$shippingAmount-$discount_amount;
                    if($saveInvoice->iTotalAmount!=$estimatedAmount)
                    {
                        $notification = array(
                            'message' => 'Sorry Invoice Amount and Estimated amount not same',
                            'alert-type' => 'error'
                        );
                        return redirect()->route('print.order.list')->with($notification);                        
                    }                    
                    DB::commit();
                    $notification = array(
                        'message' => 'Invoice Genrated Succcess fully',
                        'alert-type' => 'success'
                    );
                    return redirect()->route('print.order.list')->with($notification);
                }
            }
            $notification = array(
                'message' => 'Invalid Request',
                'alert-type' => 'error'
            );
            return redirect()->route('print.order.list')->with($notification);
        } catch (\Exception $e) {
            $notification = array(
                'message' => 'Unable to take your request, Please try again after some time!.',
                'alert-type' => 'error'
            );
            return redirect()->route('print.order.list')->with($notification);
            DB::rollback();
        }
    }
    public function duplicateCheck(Request $request){
        if($request->ajax())
        {
            echo ($request->invoice_no!="" && Invoice::where('vcInvoiceNo', '=', $request->invoice_no)->exists())?'false':'true';
            die();
        }
        else
        {
            return response()->json(['error'=>__('You are not authorized')]);
        }
    }
}