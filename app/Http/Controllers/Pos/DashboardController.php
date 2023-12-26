<?php

namespace App\Http\Controllers\Pos;

use Carbon\Carbon;
use App\Models\Beat;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\OrderDetail;
use App\Models\PaymentDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\IpaymentDetail;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public  function index(Request $request)
    {
        if ($request->has('start_date')) {
            $start_date = $request->query('start_date');
        }
        if ($request->has('end_date')) {
            $end_date = $request->query('end_date');
        }

        $supplier_id = $request->query('supplier_id') ?? null;
        $order_invoice = $request->query('order_invoice') ?? "invoice";
        $start_date = $request->query('start_date') ?? Carbon::now()->format('Y-m-d');
        $end_date = $request->query('end_date') ?? Carbon::now()->format('Y-m-d');

        if ($order_invoice == 'invoice') {
            $orderSQLWhere = "where date(i.dtCreatedOn) BETWEEN '" . $start_date . "' and '" . $end_date . "'";
            if ($supplier_id) $orderSQLWhere .= " and i.iSupplierID =" . $supplier_id;
            $orderedCustomersCountSql = "SELECT count(distinct(c.id)) customers_count FROM invoices i 
                                              join orders o on o.id = i.iOrderID
                                              join payments p on p.order_id = o.id 
                                              join customers c on c.id = p.customer_id 
                                              " . $orderSQLWhere;

            $orderedCustomersCountData = DB::select($orderedCustomersCountSql);

            $orderedCustomersCount = $orderedCustomersCountData[0]->customers_count ?? 0;
        } else {
            $orderSQLWhere = "where date(o.created_at) BETWEEN '" . $start_date . "' and '" . $end_date . "'";
            if ($supplier_id) $orderSQLWhere .= " and o.supplier_id =" . $supplier_id;
            $orderedCustomersCountSql = "SELECT count(distinct(c.id)) customers_count FROM orders o 
                                        join payments p on  p.order_id = o.id 
                                        join customers c on c.id = p.customer_id  
                                        " . $orderSQLWhere;

            $orderedCustomersCountData = DB::select($orderedCustomersCountSql);

            $orderedCustomersCount = $orderedCustomersCountData[0]->customers_count ?? 0;
        }

        $employeesCount = Employee::count();
        $customersCount = Customer::count();
        $notOrderedCustomersCount = $customersCount - $orderedCustomersCount;

        $supplier = Supplier::get();
        $todayAttendancePresentCount = Attendance::where('attendance_date', Carbon::now()->toDateString())->count();
        $todayAttendanceAbsentCount = $employeesCount - $todayAttendancePresentCount;

        $attendanceSql = "SELECT d.id, d.name, count(e.id) emp_total_count, count(a.employee_id) emp_present_count FROM divisions d
        left join employees e on d.id = e.division_id
        left join attendances a on e.id = a.employee_id and a.attendance_date = '" . Carbon::now()->format('Y-m-d') . "'
        group by d.id, d.name
        order by emp_present_count desc";

        $attendancesList = DB::select($attendanceSql);

        if ($supplier_id) {
            $userOrdersSqlWhere = " and ord.supplier_id =" . $supplier_id;
        } else {
            $userOrdersSqlWhere = " and true ";
        }
        $userOrdersSql = "SELECT emp.id emp_id,emp.name emp_name, r.name as role_name,sum(ordd.selling_qtl) qtl,sum(ordd.selling_price) price, count(DISTINCT ord.id) orders_count  FROM `order_details` ordd
        join orders ord on ord.id = ordd.order_id
        join employees emp on  emp.id = ord.created_by
        join roles r on r.id = emp.role_id
        WHERE date(ord.created_at) between '" . $start_date . "' and '" . $end_date . "' $userOrdersSqlWhere
        group by emp.id, emp.name,r.name";

        $userOrdersList = DB::select($userOrdersSql);

        if ($order_invoice == 'invoice') {
            if ($supplier_id) {
                $categoryOrdesSqlWhere = " and i.iSupplierID =" . $supplier_id;
            } else {
                $categoryOrdesSqlWhere = " and true ";
            }
            $categoryOrdesSql  = "SELECT c.id, c.name, sum(idd.selling_qtl) qtl,sum(idd.iSellingTotalPrice) price, count(DISTINCT i.iInvoiceID) orders_count FROM invoice_details idd 
                                  join invoices i on i.iInvoiceID = idd.iInvoiceID
                                  join orders ord on ord.id = i.iOrderID
                                  join employees emp on emp.id = ord.created_by 
                                  join roles r on r.id = emp.role_id 
                                  join categories c on c.id = idd.iCategoryID 
                                  WHERE date(i.dtCreatedOn) between '" . $start_date . "' and '" . $end_date . "' $categoryOrdesSqlWhere
                                  group by c.id, c.name";
        } else {
            if ($supplier_id) {
                $categoryOrdesSqlWhere = " and ord.supplier_id =" . $supplier_id;
            } else {
                $categoryOrdesSqlWhere = " and true ";
            }
            $categoryOrdesSql  = "SELECT c.id, c.name, sum(ordd.selling_qtl) qtl,sum(ordd.selling_price) price, count(DISTINCT ord.id) orders_count  FROM `order_details` ordd
                                  join orders ord on ord.id = ordd.order_id
                                  join employees emp on  emp.id = ord.created_by
                                  join roles r on r.id = emp.role_id
                                  join categories c on c.id = ordd.category_id
                                  WHERE date(ord.created_at) between '" . $start_date . "' and '" . $end_date . "' $categoryOrdesSqlWhere
                                  group by c.id, c.name";
        }

        $categoryOrdersList = DB::select($categoryOrdesSql);

        if ($order_invoice == 'invoice') {
            if ($supplier_id) {
                $productOrdesSqlWhere = " and i.iSupplierID =" . $supplier_id;
            } else {
                $productOrdesSqlWhere = " and true ";
            }
            $productOrdesSql  = "SELECT p.id, p.name, sum(idd.selling_qtl) qtl,sum(idd.iSellingTotalPrice) price, count(DISTINCT i.iInvoiceID) orders_count FROM invoice_details idd
                                      join invoices i on i.iInvoiceID = idd.iInvoiceID
                                      join orders ord on ord.id = i.iOrderID
                                      join employees emp on emp.id = ord.created_by 
                                      join roles r on r.id = emp.role_id 
                                      join products p on p.id = idd.iProductID
                                      WHERE date(ord.created_at) between '" . $start_date . "' and '" . $end_date . "' $productOrdesSqlWhere
                                      group by p.id, p.name";
        } else {
            if ($supplier_id) {
                $productOrdesSqlWhere = " and ord.supplier_id =" . $supplier_id;
            } else {
                $productOrdesSqlWhere = " and true ";
            }
            $productOrdesSql  = "SELECT p.id, p.name, sum(ordd.selling_qtl) qtl,sum(ordd.selling_price) price, count(DISTINCT ord.id) orders_count  FROM `order_details` ordd
                                 join orders ord on ord.id = ordd.order_id
                                 join employees emp on  emp.id = ord.created_by
                                 join roles r on r.id = emp.role_id
                                 join products p on p.id  = ordd.product_id
                                 WHERE date(ord.created_at) between '" . $start_date . "' and '" . $end_date . "' $productOrdesSqlWhere
                                 group by p.id, p.name";
        }
        $productOrdersList = DB::select($productOrdesSql);

        /* $transactionsSql  = "SELECT ord.id, ord.order_no,ord.date, c.name customer_name,e.name emp_name
        ,sum(ordd.selling_qtl) qtl
        ,sum(ordd.selling_price) price
        ,p.paid_status
        ,ord.status order_status
        ,p.paid_amount
        ,p.due_amount
        FROM `order_details` ordd
        join orders ord on ord.id = ordd.order_id
        left join payments p on p.order_id = ord.id
        left join customers c on c.id = p.customer_id
        left join employees e on e.id = ord.created_by
        where ordd.date = '" . Carbon::now()->format('Y-m-d') . "'
        group by ord.id,order_no,ord.date,c.id,c.name,e.id,e.name,p.paid_status,ord.status,p.paid_amount,p.due_amount"; */


        if ($supplier_id) {
            $transactionsSqlWhere = " where supplier =" . $supplier_id;
        } else {
            $transactionsSqlWhere = " where 1";
        }
        if ($order_invoice == 'invoice') {
            $transactionsSql = "SELECT * FROM (SELECT 
                                ord.id as order_id
                                ,ord.order_no
                                ,date(ord.created_at) order_date
                                ,inv.vcInvoiceNo
                                ,c.name as customer_name
                                ,cu.name as ord_created_by
                                ,inv.iloading_status
                                ,inv.iInvoiceID
                                ,inv.iSupplierID supplier
                                ,inv.dRemaining_amount
                                ,inv.iTotalAmount
                                ,au.name ord_approved_by
                                ,p.total_amount as order_amount
                                FROM `orders` ord 
                                left join payments p on p.order_id = ord.id
                                join invoices inv on ord.id = inv.iOrderID
                                left join customers c on c.id = p.customer_id
                                left join users cu on  cu.id = ord.created_by
                                left join users au on  au.id = ord.updated_by
                                where date(ord.created_at) between '" . $start_date . "' and '" . $end_date . "')temp $transactionsSqlWhere";
        } else {
            $transactionsSql = "SELECT * FROM (SELECT 
                                ord.id as order_id
                                ,ord.order_no
                                ,ord.supplier_id supplier
                                ,ord.status order_status
                                ,date(ord.created_at) order_date
                                ,c.name as customer_name
                                ,cu.name as ord_created_by
                                ,au.name ord_approved_by
                                ,p.total_amount as order_amount
                                FROM `orders` ord 
                                join payments p on p.order_id = ord.id
                                left join customers c on c.id = p.customer_id
                                left join users cu on  cu.id = ord.created_by
                                left join users au on  au.id = ord.updated_by
                                where date(ord.created_at) between '" . $start_date . "' and '" . $end_date . "')temp $transactionsSqlWhere";
        }
        $transactionsList = DB::select($transactionsSql);
        if ($supplier_id) {
            $newOrdersCountSql = "SELECT count(id) count FROM `orders` WHERE date(created_at) BETWEEN '" . $start_date . "' and '" . $end_date . "' and status=true and supplier_id =" . $supplier_id;
        } else {
            $newOrdersCountSql = "SELECT count(id) count FROM `orders` WHERE date(created_at) BETWEEN '" . $start_date . "' and '" . $end_date . "' and status=true";
        }
        $newOrdersCountData = DB::select($newOrdersCountSql);

        $newOrdersCount = $newOrdersCountData[0]->count ?? 0;

        if ($supplier_id) {
            $pendingOrdersCountSql = "SELECT count(id) count FROM `orders` WHERE date(created_at) BETWEEN '" . $start_date . "' and '" . $end_date . "' and status=false and supplier_id =" . $supplier_id;
        } else {
            $pendingOrdersCountSql = "SELECT count(id) count FROM `orders` WHERE date(created_at) BETWEEN '" . $start_date . "' and '" . $end_date . "' and status=false";
        }

        $pendingOrdersCountData = DB::select($pendingOrdersCountSql);

        $pendingOrdersCount = $pendingOrdersCountData[0]->count ?? 0;
        //$totalQTL = OrderDetail::where('Date', Carbon::today()->toDateString())->sum('selling_qtl');        

        if ($order_invoice == 'invoice') {
            $totalQTLSQLWhere = "where date(i.dtCreatedOn) BETWEEN '" . $start_date . "' and '" . $end_date . "'";
            if ($supplier_id) $totalQTLSQLWhere .= " and i.iSupplierID =" . $supplier_id;
            $totalQTLSQL = "SELECT sum(iid.selling_qtl) as selling_qtl  FROM `invoices` i 
            join invoice_details iid on i.iInvoiceID = iid.iInvoiceID
            join products p on p.id = iid.iProductID
            join suppliers s on s.id = i.iSupplierID
            " . $totalQTLSQLWhere;
            $totalQTLData = DB::select($totalQTLSQL);

            $totalQTL = $totalQTLData[0]->selling_qtl ?? 0;
        } else {
            $totalQTLSQLWhere = "where date(o.created_at) BETWEEN '" . $start_date . "' and '" . $end_date . "'";
            if ($supplier_id) $totalQTLSQLWhere .= " and o.supplier_id =" . $supplier_id;
            $totalQTLSQL = "SELECT sum(selling_qtl) as selling_qtl FROM `orders` o
            join order_details od on o.id = od.order_id
            join products p on p.id = od.product_id
            join suppliers s  on  s.id = o.supplier_id
            " . $totalQTLSQLWhere;
            $totalQTLData = DB::select($totalQTLSQL);

            $totalQTL = $totalQTLData[0]->selling_qtl ?? 0;
        }

        if ($order_invoice == 'invoice') {
            $totalSaleSQLWhere = "where date(i.dtCreatedOn) BETWEEN '" . $start_date . "' and '" . $end_date . "'";
            if ($supplier_id) $totalSaleSQLWhere .= " and i.iSupplierID =" . $supplier_id;
            $totalSalesSQL = "SELECT sum(iid.iSellingTotalPrice) as total_amount  FROM `invoices` i 
            join invoice_details iid on i.iInvoiceID = iid.iInvoiceID
            join products p on p.id = iid.iProductID
            join suppliers s on s.id = i.iSupplierID
            " . $totalSaleSQLWhere;
            $totalSalesData = DB::select($totalSalesSQL);

            $totalSales = $totalSalesData[0]->total_amount ?? 0;
        } else {
            $totalSaleSQLWhere = "where date(o.created_at) BETWEEN '" . $start_date . "' and '" . $end_date . "'";
            if ($supplier_id) $totalSaleSQLWhere .= " and o.supplier_id =" . $supplier_id;
            $totalSalesSQL = "SELECT sum(selling_price) as total_amount FROM `orders` o
            join order_details od on o.id = od.order_id
            join products p on p.id = od.product_id
            join suppliers s  on  s.id = o.supplier_id
            " . $totalSaleSQLWhere;
            $totalSalesData = DB::select($totalSalesSQL);

            $totalSales = $totalSalesData[0]->total_amount ?? 0;
        }

        $receivedPayment = PaymentDetail::where('Date', Carbon::today()->toDateString())->sum('current_paid_amount');
        if (Auth::user()->role->name == 'Admin' || Auth::user()->role->name == 'Director' || Auth::user()->role->name == 'General Manager') {
            return view('admin.index', compact(
                'todayAttendancePresentCount',
                'todayAttendanceAbsentCount',
                'attendancesList',
                'employeesCount',
                'totalSales',
                'newOrdersCount',
                'pendingOrdersCount',
                'totalQTL',
                'userOrdersList',
                'categoryOrdersList',
                'productOrdersList',
                'transactionsList',
                'receivedPayment',
                'supplier',
                'supplier_id',
                'order_invoice',
                'start_date',
                'end_date',
                'orderedCustomersCount',
                'notOrderedCustomersCount'
            ));
        } else {
            return view('admin.index_other');
        }
    }
    public function show(Request $request, $id)
    {

        $start_date = $request->query('start_date') ?? Carbon::now()->format('Y-m-d');
        $end_date = $request->query('end_date') ?? Carbon::now()->format('Y-m-d');

        $transactionsSql  = "SELECT ord.id, ord.order_no,ord.date, c.name customer_name,e.name emp_name
        ,sum(ordd.selling_qtl) qtl
        ,sum(ordd.selling_price) price
        ,p.paid_status
        ,ord.status order_status
        ,p.paid_amount
        ,p.due_amount
        FROM `order_details` ordd
        join orders ord on ord.id = ordd.order_id
        left join payments p on p.order_id = ord.id
        left join customers c on c.id = p.customer_id
        left join employees e on e.id = ord.created_by
        WHERE date(ord.created_at) between '" . $start_date . "' and '" . $end_date . "' and e.id = $id
        group by ord.id,order_no,ord.date,c.id,c.name,e.id,e.name,p.paid_status,ord.status,p.paid_amount,p.due_amount";

        $transactionsList = DB::select($transactionsSql);
        // dd($transactionsList);

        return view('admin.dashboard_popups.show_orders', compact('transactionsList'));
    }

    public function getProductsByCategories(Request $request)
    {
        $id = $request->id;
        $order_invoice = $request->order_invoice;
        $supplier_id = $request->supplier_id;
        $start_date = $request->query('start_date') ?? Carbon::now()->format('Y-m-d');
        $end_date = $request->query('end_date') ?? Carbon::now()->format('Y-m-d');
        $order_invoice_data = $order_invoice;
        $category = Category::select('name')->find($id);
        if ($order_invoice == 'invoice') {
            if ($supplier_id) {
                $Where = " and i.iSupplierID =" . $supplier_id;
            } else {
                $Where = " and true ";
            }
            $sql = "SELECT i.iInvoiceID, i.vcInvoiceNo, p.name product_name,c.name customer_name,e.name emp_name,idd.selling_qtl,idd.iSellingTotalPrice as selling_price FROM invoice_details idd
            join invoices i on i.iInvoiceID = idd.iInvoiceID
            join orders ord on ord.id = i.iOrderID
            join products p on p.id  = idd.iProductID
            join payments pts on pts.order_id = ord.id
            join customers c on c.id = pts.customer_id
            join employees e on e.id = ord.created_by
            WHERE date(i.dtCreatedOn) between '" . $start_date . "' and '" . $end_date . "' and idd.iCategoryID = $id" . $Where . "";
        } else {
            if ($supplier_id) {
                $Where = " and ord.supplier_id =" . $supplier_id;
            } else {
                $Where = " and true ";
            }
            $sql  = "SELECT 
            ord.id, ord.order_no, p.name product_name,c.name customer_name
            ,e.name emp_name,ordd.selling_qtl,ordd.selling_price 
            FROM `order_details` ordd
            join orders ord on ord.id = ordd.order_id
            join products p on p.id  = ordd.product_id
            join payments pts on pts.order_id = ord.id
            join customers c on c.id = pts.customer_id
            join employees e on e.id = ord.created_by
            WHERE date(ordd.created_at) between '" . $start_date . "' and '" . $end_date . "' and ordd.category_id = $id" . $Where . "";
        }

        $products = DB::select($sql);
        // dd($transactionsList);

        return view('admin.dashboard_popups.products', compact('products', 'order_invoice_data'));
    }
    public function getProductData(Request $request)
    {
        $id = $request->id;
        $order_invoice = $request->order_invoice;
        $supplier_id = $request->supplier_id;
        $start_date = $request->query('start_date') ?? Carbon::now()->format('Y-m-d');
        $end_date = $request->query('end_date') ?? Carbon::now()->format('Y-m-d');
        $order_invoice_data = $order_invoice;
        $category = Category::select('name')->find($id);
        if ($order_invoice == 'invoice') {
            if ($supplier_id) {
                $Where = " and i.iSupplierID =" . $supplier_id;
            } else {
                $Where = " and true ";
            }
            $sql  = "SELECT i.iInvoiceID, i.vcInvoiceNo, p.name product_name,c.name customer_name,e.name emp_name,idd.selling_qtl,idd.iSellingTotalPrice as selling_price FROM invoice_details idd
            join invoices i on i.iInvoiceID = idd.iInvoiceID
            join orders ord on ord.id = i.iOrderID
            join products p on p.id  = idd.iProductID
            join payments pts on pts.order_id = ord.id
            join customers c on c.id = pts.customer_id
            join employees e on e.id = ord.created_by
            WHERE date(i.dtCreatedOn) between '" . $start_date . "' and '" . $end_date . "' and idd.iProductID  = $id" . $Where . "";
        } else {
            if ($supplier_id) {
                $Where = " and ord.supplier_id =" . $supplier_id;
            } else {
                $Where = " and true ";
            }
            $sql  = "SELECT 
                     ord.id, ord.order_no, p.name product_name,c.name customer_name
                     ,e.name emp_name,ordd.selling_qtl,ordd.selling_price 
                     FROM `order_details` ordd
                     join orders ord on ord.id = ordd.order_id
                     join products p on p.id  = ordd.product_id
                     join payments pts on pts.order_id = ord.id
                     join customers c on c.id = pts.customer_id
                     join employees e on e.id = ord.created_by
                     WHERE date(ordd.created_at) between '" . $start_date . "' and '" . $end_date . "' and ordd.product_id = $id" . $Where . "";
        }
        $products = DB::select($sql);
        // dd($transactionsList);

        return view('admin.dashboard_popups.products', compact('products', 'order_invoice_data'));
    }

    public function getOrder($id)
    {
        $payment = Payment::where('order_id', $id)->first();
        return view('admin.dashboard_popups.order_info', compact('payment'));
    }

    public function getInvoice($id)
    {
        $invoice = Invoice::where('iInvoiceID', $id)->first();
        return view('admin.dashboard_popups.invoice_info', compact('invoice'));
    }

    public function getInvoiceStatus($id)
    {
        $invoice_status = Invoice::where('iInvoiceID', $id)->first();
        return view('admin.dashboard_popups.invoice_status', compact('invoice_status'));
    }
    public function getInvoicePaymentStatus($id)
    {
        $invoice_payment_status = IpaymentDetail::where('invoice_id', $id)->get();
        $invoice = Invoice::where('iInvoiceID', $id)->first();
        return view('admin.dashboard_popups.invoice_payment_status', compact('invoice_payment_status', 'invoice'));
    }
}
