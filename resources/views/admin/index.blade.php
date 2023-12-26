@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">TDH</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row mb-4">
                <div class="col-12">

                    <form method="GET" id="myForm" novalidate="novalidate">

                        <div class="row">
                            <div class="col-md-2">
                                <div class="md-3 form-group">
                                    <label for="example-text-input" class="form-label">Organization</label>
                                    <select name="supplier_id" class="form-select select2">
                                        <option value="">All</option>
                                        @foreach ($supplier as $supp)
                                            <option value="{{ $supp->id }}"
                                                {{ $supp->id == $supplier_id ? 'selected' : '' }}>{{ $supp->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="md-3 form-group">
                                    <label for="example-text-input" class="form-label">Start Date</label>
                                    <input class="form-control example-date-input" name="start_date" type="date"
                                        id="start_date" placeholder="YY-MM-DD" value="{{ $start_date }}">
                                </div>
                            </div>


                            <div class="col-md-2">
                                <div class="md-3 form-group">
                                    <label for="example-text-input" class="form-label">End Date</label>
                                    <input class="form-control example-date-input" name="end_date" type="date"
                                        id="end_date" placeholder="YY-MM-DD" value="{{ $end_date }}">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="md-3 form-group">
                                    <label for="example-text-input" class="form-label">Based</label>
                                    <select name="order_invoice" class="form-select select2">
                                        <option value="invoice" {{ $order_invoice == 'invoice' ? 'selected' : '' }}>Invoice
                                        </option>
                                        <option value="order" {{ $order_invoice == 'order' ? 'selected' : '' }}>Orders
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label" style="margin-top:43px;"> </label>
                                    <button type="submit" class="btn btn-info">Search</button>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label" style="margin-top:43px;"> </label>
                                    or
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="md-3">
                                    <label for="example-text-input" class="form-label" style="margin-top:43px;"> </label>
                                    <button type="submit" class="btn btn-danger ">This Month Orders</button>
                                </div>
                            </div>

                            {{-- <div class="col-md-2">
                            <div class="md-3">
                                <label for="example-text-input" class="form-label" style="margin-top:43px;"> </label>
                                <button type="submit" class="btn btn-warning">This Month Zero Orders</button>
                            </div>
                        </div> --}}


                        </div> <!-- // end row  -->

                    </form>

                </div> <!-- end col -->
            </div>









            <div class="row">
                <div class="col-xl-2 col-md-6">
                    <div class="card">
                        <div class="card-body bg-info bx-1">
                            <a href="#">
                                <div class="d-flex text-center">
                                    <div class="flex-grow-1">
                                        <p class="text-white font-size-14 mb-2">Total QTL</p>
                                        <h5 class="mb-2">{{ $totalQTL }} Qtl</h5>
                                    </div>

                                </div>
                            </a>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-xl-2 col-md-6">
                    <div class="card">
                        <div class="card-body bg-danger bx-1">
                            <a href="#">
                                <div class="d-flex text-center">

                                    <div class="flex-grow-1 text-white">
                                        <p class="text-truncate font-size-14 mb-2">Total Sales</p>
                                        <h5 class="mb-2">Rs.{{ $totalSales }}</h5>
                                    </div>

                                </div>
                            </a>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-xl-2 col-md-6">
                    <div class="card">
                        <div class="card-body bg-warning bx-1" style="padding:1.25rem 10px;">
                            <a href="#">
                                <div class="d-flex text-center">
                                    <div class="flex-grow-1">
                                        <p class="text-white font-size-14 mb-2">Ord/Pen Parties</p>
                                        <h5 class="mb-2">O: {{ $orderedCustomersCount }} | P:
                                            {{ $notOrderedCustomersCount }}</h5>
                                    </div>
                                </div>
                            </a>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-xl-2 col-md-6">
                    <div class="card">
                        <div class="card-body bg-success bx-1">
                            <a href="#">
                                <div class="d-flex text-center">
                                    <div class="flex-grow-1">
                                        <p class="text-white font-size-14 mb-2">New Orders</p>
                                        <h5 class="mb-2">{{ $newOrdersCount }}</h5>
                                    </div>

                                </div>
                            </a>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->



                <div class="col-xl-2 col-md-6">
                    <div class="card">
                        <div class="card-body bg-primary bx-1">
                            <a href="#">
                                <div class="d-flex text-center">
                                    <div class="flex-grow-1">
                                        <p class="text-white font-size-14 mb-2">Pen. Orders</p>
                                        <h5 class="mb-2">{{ $pendingOrdersCount }}</h5>
                                    </div>

                                </div>
                            </a>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-xl-2 col-md-6">
                    <div class="card">
                        <div class="card-body bg-perple bx-1">
                            <a data-bs-toggle="modal" href="#attendanceModal">
                                <div class="d-flex text-center">
                                    <div class="flex-grow-1">
                                        <p class="text-white font-size-14 mb-2">Attendance</p>
                                        <h5 class="mb-2">P: {{ $todayAttendancePresentCount }} | A:
                                            {{ $todayAttendanceAbsentCount }}</h5>
                                    </div>
                                </div>
                            </a>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->
                </div><!-- end col -->






            </div><!-- end row -->





            {{-- <div class="row mb-2">
                <div class="col-12">

                    <form method="GET" action="#" target="_blank" id="myForm" novalidate="novalidate">

                        <div class="row">



                            <div class="col-md-12">
                                <div class="form-check form-check-inline">

                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1"
                                        checked>

                                    <label class="form-check-label" for="inlineCheckbox1">All Orders</label>

                                </div>

                                <div class="form-check form-check-inline">

                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2"
                                        value="option2">

                                    <label class="form-check-label" for="inlineCheckbox2">SO Orders</label>

                                </div>

                                <div class="form-check form-check-inline">

                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3"
                                        value="option3">

                                    <label class="form-check-label" for="inlineCheckbox3">Broker Orders</label>

                                </div>
                                <div class="form-check form-check-inline">

                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3"
                                        value="option4">

                                    <label class="form-check-label" for="inlineCheckbox3">Distributor Orders </label>

                                </div>
                            </div>
                        </div>


                </div> <!-- // end row  -->

                </form>

            </div> <!-- end col --> --}}
        </div>








        <div class="row">

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        {{-- <div class="dropdown float-end">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>

                    </div> --}}

                        <h4 class="card-title mb-4">
                            @if ($order_invoice == 'invoice')
                                Orders by Categories (Invoice)
                            @else
                                Orders by Categories (Order)
                            @endif
                        </h4>

                        <div class="table-responsive">
                            <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-end">Sl No</th>
                                        <th>Category Name </th>
                                        <th class="text-end">QTL</th>
                                        <th class="text-end"># Orders</th>
                                        <th style="width: 120px;" class="text-end">Amt</th>
                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                    @forelse ($categoryOrdersList as $categoryOrder)
                                        <tr>
                                            <td>
                                                <h6 class="mb-0 text-end">{{ $loop->index + 1 }}</h6>
                                            </td>
                                            <td>
                                                <a href="#" data-bs-toggle="modal" class="categoriesModalButton"
                                                    data-bs-target="#categoriesModal"
                                                    data-attr="{{ route('dashboard.products-by-categories', ['id' => $categoryOrder->id, 'order_invoice' => $order_invoice, 'supplier_id' => $supplier_id]) }}"
                                                    title="show">{{ $categoryOrder->name }}
                                                </a>
                                            </td>
                                            <td class="text-end">{{ $categoryOrder->qtl }}</td>
                                            <td class="text-end">{{ $categoryOrder->orders_count }}</td>
                                            <td class="text-end">Rs.{{ $categoryOrder->price }}</td>
                                        </tr>
                                    @empty
                                    @endforelse
                                    <!-- end -->
                                </tbody><!-- end tbody -->
                            </table> <!-- end table -->
                            <div class="modal" id="categoriesModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Products List of <span
                                                    id="categoriesModalHeading"></span></h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body" id="categoriesModalBody">
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card -->

                </div>

            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        {{-- <div class="dropdown float-end">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>

                    </div> --}}

                        <h4 class="card-title mb-4">
                            @if ($order_invoice == 'invoice')
                                Orders by Products (Invoice)
                            @else
                                Orders by Products (Order)
                            @endif
                        </h4>

                        <div class="table-responsive">
                            <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-end">Sl No</th>
                                        <th>Product Name </th>
                                        <th class="text-end">QTL</th>
                                        <th class="text-end"># Orders</th>
                                        <th style="width: 120px;" class="text-end">Amt</th>
                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                    @forelse ($productOrdersList as $productOrder)
                                        <tr>
                                            <td>
                                                <h6 class="mb-0 text-end">{{ $loop->index + 1 }}</h6>
                                            </td>
                                            <td>
                                                <a href="#" data-bs-toggle="modal" class="productsModalButton"
                                                    data-bs-target="#productsModal"
                                                    data-attr="{{ route('dashboard.product-data', ['id' => $productOrder->id, 'order_invoice' => $order_invoice, 'supplier_id' => $supplier_id]) }}"
                                                    title="show">{{ $productOrder->name }}
                                                </a>
                                            </td>
                                            <td class="text-end">{{ $productOrder->qtl }}</td>
                                            <td class="text-end">{{ $productOrder->orders_count }}</td>
                                            <td class="text-end">Rs.{{ $productOrder->price }}</td>
                                        </tr>
                                    @empty
                                    @endforelse
                                    <!-- end -->
                                </tbody><!-- end tbody -->
                            </table> <!-- end table -->
                            <div class="modal" id="productsModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Product Name: <span id="productsModalHeading"></span>
                                            </h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body" id="productsModalBody">
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card -->

                </div>

            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        {{-- <div class="dropdown float-end">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>

                    </div> --}}
                        <div>
                            <h4 class="card-title mb-4">All Orders</h4>

                            <select name="order_type" id="order_type" class="form-select select2" multiple
                                onchange="myOrderFunction()">
                                <option value="All">All</option>
                                <option value="Sales Officer">SO Orders</option>
                                <option value="Broker">Broker Orders</option>
                                <option value="Distributor">Distributor Orders</option>
                            </select>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered mb-0 align-middle table-hover table-nowrap" id="datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-end">Sl No</th>
                                        <th>User Name </th>
                                        <th>Role Name</th>
                                        <th class="text-end">QTL</th>
                                        <th class="text-end"># Orders</th>
                                        <th style="width: 120px;" class="text-end">Amt</th>
                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                    @forelse ($userOrdersList as $userOrder)
                                        <tr>
                                            <td>
                                                <h6 class="mb-0 text-end">{{ $loop->index + 1 }}</h6>
                                            </td>
                                            <td>
                                                {{-- <a href="#">{{ $userOrder->emp_name }}</a> --}}
                                                <a href="#" data-bs-toggle="modal" class="modalButton"
                                                    data-bs-target="#myModal"
                                                    data-attr="{{ route('dashboard.show', $userOrder->emp_id) }}"
                                                    title="show">{{ $userOrder->emp_name }}
                                                </a>
                                            </td>
                                            <td>{{ $userOrder->role_name }}</td>
                                            <td class="text-end">{{ $userOrder->qtl }}</td>
                                            <td class="text-end">{{ $userOrder->orders_count }}</td>
                                            <td class="text-end">Rs.{{ $userOrder->price }}</td>
                                        </tr>
                                    @empty
                                    @endforelse
                                    <!-- end -->

                                    <!-- end -->
                                    <!-- end -->
                                </tbody><!-- end tbody -->
                            </table> <!-- end table -->
                            <!-- The Modal -->
                            <div class="modal" id="myModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Orders List of <span id="modalHeading"></span></h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body" id="modalBody">
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card -->




                </div><!-- end card -->

                <!-- end col -->

                <!-- end row -->
            </div>




            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        {{-- <div class="dropdown float-end">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>

                    </div> --}}

                        <h4 class="card-title mb-4">
                            @if ($order_invoice == 'invoice')
                                All Transactions (Invoice)
                            @else
                                All Transactions (Order)
                            @endif
                        </h4>

                        <div class="table-responsive">
                            <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-end">Sl No</th>
                                        <th class="text-end">Order No </th>
                                        <th>Order Date</th>
                                        @if ($order_invoice == 'invoice')
                                            <th>Invoice No</th>
                                        @endif
                                        <th>Customer</th>
                                        {{-- <th>Order No</th> --}}
                                        <th>Order By</th>
                                        {{-- <th class="text-end">QTL</th> --}}
                                        <th class="text-end">Amount</th>
                                        {{-- <th class="text-end">Paid</th> --}}
                                        {{-- <th class="text-end">Due</th> --}}
                                        @if ($order_invoice == 'invoice')
                                            <th>Invoice Status</th>
                                        @else
                                            <th>Order Status</th>
                                        @endif
                                        @if ($order_invoice == 'invoice')
                                            <th>Payment Status</th>
                                        @endif

                                        {{-- <th>Approved By</th> --}}
                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                    @forelse ($transactionsList as $transaction)
                                        <tr>
                                            <td>
                                                <h6 class="mb-0 text-end">{{ $loop->index + 1 }}</h6>
                                            </td>
                                            <td class="text-end">
                                                <a href="#" data-bs-toggle="modal" class="transactionsModalButton"
                                                    data-bs-target="#transactionsModal"
                                                    data-attr="{{ route('dashboard.getOrder', $transaction->order_id) }}"
                                                    title="show">{{ $transaction->order_no }}
                                                </a>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($transaction->order_date)->format('d-m-Y') }}</td>
                                            @if ($order_invoice == 'invoice')
                                                <td><a href="#" data-bs-toggle="modal" class="invoiceModalButton"
                                                        data-bs-target="#invoiceModal"
                                                        data-attr="{{ route('dashboard.getInvoice', $transaction->iInvoiceID) }}"
                                                        title="show">{{ $transaction->vcInvoiceNo }}
                                                    </a>
                                                </td>
                                            @endif
                                            <td>{{ $transaction->customer_name }}</td>
                                            {{-- <td>32564</td> --}}
                                            <td>{{ $transaction->ord_created_by }}</td>
                                            {{-- <td class="text-end">{{ $transaction->qtl }}</td> --}}
                                            <td class="text-end">
                                                @if ($order_invoice == 'invoice')
                                                    {{ $transaction->iTotalAmount }}
                                                @else
                                                    {{ $transaction->order_amount }}
                                                @endif
                                            </td>
                                            {{-- <td class="text-end">{{ $transaction->paid_amount ? $transaction->paid_amount : ''
                                        }}</td>
                                    <td class="text-end">{{ $transaction->due_amount ? $transaction->due_amount : '' }}
                                    </td> --}}
                                            @if ($order_invoice == 'invoice')
                                                <td>
                                                    @if ($transaction->iInvoiceID != '')
                                                        @if ($transaction->iloading_status != 'not_loaded')
                                                            <a href="#" data-bs-toggle="modal"
                                                                class="invoicestatusModalButton"
                                                                data-bs-target="#invoicestatusModal"
                                                                data-attr="{{ route('dashboard.getInvoiceStatus', $transaction->iInvoiceID) }}"
                                                                title="show">{{ $transaction->iloading_status }}
                                                            </a>
                                                        @else
                                                            {{ $transaction->iloading_status }}
                                                        @endif
                                                    @endif

                                                </td>
                                            @else
                                                <td>

                                                    @if ($transaction->order_status == true)
                                                        Approved
                                                    @else
                                                        Pending
                                                    @endif
                                            @endif

                                            @if ($order_invoice == 'invoice')
                                                <td>
                                                    @if ($transaction->iInvoiceID != '')
                                                        @if ($transaction->dRemaining_amount == $transaction->iTotalAmount)
                                                            {{ 'Full Due' }}
                                                        @elseif($transaction->dRemaining_amount == 0)
                                                            <a href="#" data-bs-toggle="modal"
                                                                class="invoicepaymentstatusModalButton"
                                                                data-bs-target="#invoicepaymentstatusModal"
                                                                data-attr="{{ route('dashboard.getInvoicePaymentStatus', $transaction->iInvoiceID) }}"
                                                                title="show">{{ 'Paid' }}
                                                            </a>
                                                        @else
                                                            <a href="#" data-bs-toggle="modal"
                                                                class="invoicepaymentstatusModalButton"
                                                                data-bs-target="#invoicepaymentstatusModal"
                                                                data-attr="{{ route('dashboard.getInvoicePaymentStatus', $transaction->iInvoiceID) }}"
                                                                title="show">{{ 'Partially Paid' }}
                                                            </a>
                                                        @endif
                                                    @endif
                                                </td>
                                            @endif

                                            {{-- <td>Admin</td> --}}
                                        </tr>
                                    @empty
                                    @endforelse
                                    <!-- end -->
                                    <!-- end -->
                                </tbody><!-- end tbody -->
                            </table> <!-- end table -->
                            <div class="modal" id="transactionsModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Order No:#<span id="transactionsModalHeading"></span>
                                            </h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body" id="transactionsModalBody">
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal" id="invoiceModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Invoice No:<span id="InvoiceModalHeading"></span>
                                            </h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body" id="invoiceModalBody">
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal" id="invoicestatusModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Invoice Status:<span
                                                    id="invoicestatusModalHeading"></span>
                                            </h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body" id="invoicestatusModalBody">
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal" id="invoicepaymentstatusModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Invoice Status:<span
                                                    id="invoicepaymentstatusModalHeading"></span>
                                            </h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body" id="invoicepaymentstatusModalBody">
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card -->




                </div><!-- end card -->

                <!-- end col -->

                <!-- end row -->
                <!-- The Attendance Modal -->
                <div class="modal" id="attendanceModal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Attendance ({{ \Carbon\Carbon::now()->format('d-M-Y') }})</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Si.No</th>
                                                <th>Particulars</th>
                                                <th>Total</th>
                                                <th>Presents</th>
                                                <th>Absents</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @forelse ($attendancesList as $attendance)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $attendance->name }}</td>
                                                    <td>{{ $attendance->emp_total_count }}</td>
                                                    <td>{{ $attendance->emp_present_count }}</td>
                                                    <td>{{ $attendance->emp_total_count - $attendance->emp_present_count }}
                                                    </td>
                                                </tr>
                                            @empty
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2">Total Employees</th>
                                                <th>{{ $employeesCount }}</th>
                                                <th>{{ $todayAttendancePresentCount }}</th>
                                                <th>{{ $todayAttendanceAbsentCount }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
            <script>
                $(document).on('click', '.modalButton', function(event) {
                    event.preventDefault();
                    let start_date = $("#start_date").val();
                    let end_date = $("#end_date").val();
                    let href = $(this).attr('data-attr') + "?start_date=" + start_date + "&end_date=" + end_date;
                    let username = $(this).text();

                    $("#modalHeading").html(username);


                    $.ajax({
                        url: href,
                        // return the result
                        beforeSend: function() {
                            $("#modalBody").html('Loading...');
                        },
                        success: function(response) {
                            // console.log(response);
                            $('#myModal').modal("show");
                            $('#modalBody').html(response).show();
                        },
                    })
                });

                $(document).on('click', '.categoriesModalButton', function(event) {
                    event.preventDefault();
                    let start_date = $("#start_date").val();
                    let end_date = $("#end_date").val();
                    let href = $(this).attr('data-attr') + "?start_date=" + start_date + "&end_date=" + end_date;
                    let category = $(this).text();
                    $("#categoriesModalHeading").html(category);

                    $.ajax({
                        url: href,
                        // return the result
                        beforeSend: function() {
                            $("#categoriesModalBody").html('Loading...');
                        },
                        success: function(response) {
                            // console.log(response);
                            $('#categoriesModal').modal("show");
                            $('#categoriesModalBody').html(response).show();
                        },
                    })
                });

                $(document).on('click', '.productsModalButton', function(event) {
                    event.preventDefault();
                    let start_date = $("#start_date").val();
                    let end_date = $("#end_date").val();
                    let href = $(this).attr('data-attr') + "?start_date=" + start_date + "&end_date=" + end_date;
                    let product = $(this).text();
                    $("#productsModalHeading").html(product);

                    $.ajax({
                        url: href,
                        // return the result
                        beforeSend: function() {
                            $("#productsModalBody").html('Loading...');
                        },
                        success: function(response) {
                            // console.log(response);
                            $('#productsModal').modal("show");
                            $('#productsModalBody').html(response).show();
                        },
                    })
                });

                $(document).on('click', '.transactionsModalButton', function(event) {
                    event.preventDefault();
                    let href = $(this).attr('data-attr');
                    let order_no = $(this).text();
                    $("#transactionsModalHeading").html(order_no);

                    $.ajax({
                        url: href,
                        // return the result
                        beforeSend: function() {
                            $("#transactionsModalBody").html('Loading...');
                        },
                        success: function(response) {
                            // console.log(response);
                            $('#transactionsModal').modal("show");
                            $('#transactionsModalBody').html(response).show();
                        },
                    })
                });
                $(document).on('click', '.invoiceModalButton', function(event) {
                    event.preventDefault();
                    let href = $(this).attr('data-attr');
                    let order_no = $(this).text();
                    $("#InvoiceModalHeading").html(order_no);

                    $.ajax({
                        url: href,
                        // return the result
                        beforeSend: function() {
                            $("#invoiceModalBody").html('Loading...');
                        },
                        success: function(response) {
                            // console.log(response);
                            $('#invoiceModal').modal("show");
                            $('#invoiceModalBody').html(response).show();
                        },
                    })
                });
                $(document).on('click', '.invoicestatusModalButton', function(event) {
                    event.preventDefault();
                    let href = $(this).attr('data-attr');
                    let invoicestatus = $(this).text();
                    $("#invoicestatusModalHeading").html(invoicestatus);

                    $.ajax({
                        url: href,
                        // return the result
                        beforeSend: function() {
                            $("#invoicestatusModalBody").html('Loading...');
                        },
                        success: function(response) {
                            $('#invoicestatusModal').modal("show");
                            $('#invoicestatusModalBody').html(response).show();
                        },
                    })
                });
                $(document).on('click', '.invoicepaymentstatusModalButton', function(event) {
                    event.preventDefault();
                    let href = $(this).attr('data-attr');
                    let paymentstatus = $(this).text();
                    $("#invoicepaymentstatusModalHeading").html(paymentstatus);

                    $.ajax({
                        url: href,
                        // return the result
                        beforeSend: function() {
                            $("#invoicepaymentstatusModalBody").html('Loading...');
                        },
                        success: function(response) {
                            $('#invoicepaymentstatusModal').modal("show");
                            $('#invoicepaymentstatusModalBody').html(response).show();
                        },
                    })
                });

                function myOrderFunction() {
                    $(document).ready(function() {
                        $.fn.dataTable.Api.register('filter.push', function(fn, draw) {
                            if (!this.__customFilters) {
                                var filters = this.__customFilters = []
                                this.on('mousedown preDraw.dt', function() {
                                    $.fn.dataTable.ext.search = filters
                                })
                            }
                            this.__customFilters.push(fn)
                            $.fn.dataTable.ext.search = this.__customFilters
                            this.draw()
                        });

                        $.fn.dataTable.Api.register('filter.pop', function() {
                            if (!this.__customFilters) return
                            this.__customFilters.pop()
                        });


                        var order_type = $("#order_type").val();
                        var table1 = $('#datatable').DataTable();
                        var res = order_type.join(',')
                        // Custom range filtering function
                        if (res == 'Sales Officer') {
                            table1.filter.push(function(settings, data, dataIndex) {
                                var pos = data[2];

                                if (pos == 'Sales Officer') {
                                    return true;
                                    table1.draw();
                                }
                                return false;
                            });
                        } else if (res == 'Broker') {
                            table1.filter.push(function(settings, data, dataIndex) {
                                var pos = data[2];

                                if (pos == 'Broker') {
                                    return true;
                                    table1.draw();
                                }
                                return false;
                            });
                        } else if (res == 'Distributor') {
                            table1.filter.push(function(settings, data, dataIndex) {
                                var pos = data[2];

                                if (pos == 'Distributor') {
                                    return true;
                                    table1.draw();
                                }
                                return false;
                            });
                        } else if (res == 'Sales Officer,Broker') {
                            table1.filter.push(function(settings, data, dataIndex) {
                                var pos = data[2];

                                if (pos == 'Broker' || pos == 'Sales Officer') {
                                    return true;
                                    table1.draw();
                                }
                                return false;
                            });
                        } else if (res == 'Sales Officer,Distributor') {
                            table1.filter.push(function(settings, data, dataIndex) {
                                var pos = data[2];

                                if (pos == 'Distributor' || pos == 'Sales Officer') {
                                    return true;
                                    table1.draw();
                                }
                                return false;
                            });
                        } else if (res == 'Broker,Distributor') {
                            table1.filter.push(function(settings, data, dataIndex) {
                                var pos = data[2];

                                if (pos == 'Distributor' || pos == 'Broker') {
                                    return true;
                                    table1.draw();
                                }
                                return false;
                            });
                        } else if (res == 'Sales Officer,Broker,Distributor') {
                            table1.filter.push(function(settings, data, dataIndex) {
                                var pos = data[2];

                                if (pos == 'Distributor' || pos == 'Broker' || pos == 'Sales Officer') {
                                    return true;
                                    table1.draw();
                                }
                                return false;
                            });
                        } else if (res == 'All') {
                            table1.filter.push(function(settings, data, dataIndex) {

                                return true;
                                table1.draw();
                            });
                        }
                    });
                }
            </script>
        @endsection
