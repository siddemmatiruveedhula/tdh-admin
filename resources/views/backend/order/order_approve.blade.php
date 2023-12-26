@extends('admin.admin_master')
@section('admin')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Order Approve</h4>



                </div>
            </div>
        </div>
        <!-- end page title -->
        @php
        $payment = App\Models\Payment::where('order_id', $order->id)->first();
        @endphp
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Order No: #{{ $order->order_no }}
                        </h4>
                        <a href="{{ route('order.pending.list') }}"
                            class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;"><i
                                class="fa fa-list"> Pending Order List </i></a> <br> <br>

                        <table class="table" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <p> Customer Info </p>
                                    </td>
                                    <td>
                                        <p> Name: <strong> {{ $payment['customer']['name'] }} </strong> </p>
                                    </td>
                                    <td>
                                        <p> Mobile: <strong> {{ $payment['customer']['mobile_no'] }} </strong> </p>
                                    </td>
                                    <td>
                                        <p> Email: <strong> {{ $payment['customer']['email'] }} </strong> </p>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Date: <strong>{{ date('d-m-Y', strtotime($order->date)) }}</strong></td>
                                    <td colspan="3">
                                        <p> Description : <strong> {{ $order->description }} </strong> </p>
                                    </td>
                                </tr>
                            </tbody>

                        </table>


                        <form method="post" action="{{ route('approval.store', $order->id) }}">
                            @csrf
                            <table border="1" class="table" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">Sl</th>
                                        <th class="text-center">Category</th>
                                        <th class="text-center">Product Name</th>
                                        <th class="text-end">Current Stock</th>
                                        <th class="text-end">Quantity</th>
                                        <th class="text-end">Unit Price </th>
                                        <th class="text-end">Total Price</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @php
                                    $total_sum = '0';
                                    @endphp
                                    @foreach ($order['order_details'] as $key => $details)
                                    <tr>

                                        <input type="hidden" name="category_id[]" value="{{ $details->category_id }}">
                                        <input type="hidden" name="product_id[]" value="{{ $details->product_id }}">
                                        <input type="hidden" name="selling_qty[{{ $details->id }}]"
                                            value="{{ $details->selling_qty }}">

                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td class="text-center">{{ $details['category']['name'] }}</td>
                                        <td class="text-center">{{ $details['product']['name'] }}</td>
                                        <td class="text-end">
                                            {{ $details['product']['quantity'] }}</td>
                                        <td class="text-end">{{ $details->selling_qty }}</td>
                                        <td class="text-end">{{ $details->unit_price }}</td>
                                        <td class="text-end">{{ $details->selling_price }}</td>
                                    </tr>
                                    @php
                                    $total_sum += $details->selling_price;
                                    @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="6"> Sub Total </td>
                                        <td align="right"> {{ $total_sum }} </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"> Discount (CASH/PERCENTAGE/TRANSPORT) </td>
                                        <td  align="right"> {{ $payment->discount_amount }} </td>
                                    </tr>

                                    <tr>
                                        <td colspan="6"> Paid Amount </td>
                                        <td align="right">{{ $payment->paid_amount }} </td>
                                    </tr>

                                    <tr>
                                        <td colspan="6"> Due Amount </td>
                                        <td align="right"> {{ $payment->due_amount }} </td>
                                    </tr>

                                    <tr>
                                        <td colspan="6"> Grand Amount </td>
                                        <td align="right">{{ $payment->total_amount }}</td>
                                    </tr>
                                </tbody>

                            </table>

                            <button type="submit" class="btn btn-info">Order Approve </button>

                        </form>



                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->



    </div> <!-- container-fluid -->
</div>
@endsection