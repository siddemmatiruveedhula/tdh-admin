<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="order-title">
                                <h4 class="float-end font-size-16"><strong>Order No # {{
                                        $payment['order']['order_no'] }}</strong></h4>
                                <h3>
                                    <img src="{{ asset('backend/assets/images/logo-sm.png') }}" alt="logo"
                                        height="24" /> Tenali Doule Horse
                                </h3>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-6 mt-4">
                                    <address>
                                        <strong>{{ $payment['order']['supplier']['name'] }}:</strong><br>
                                        {{ $payment['order']['supplier']['address'] }}<br>
                                        {{ $payment['order']['supplier']['email'] }}
                                    </address>
                                </div>
                                <div class="col-6 mt-4 text-end">
                                    <address>
                                        <strong>Order Date:</strong><br>
                                        {{ date('d-m-Y',strtotime($payment['order']['date'])) }} <br><br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-12">
                            <div>
                                <div class="p-2">
                                    <h3 class="font-size-16"><strong>Customer Order</strong></h3>
                                </div>
                                <div class="">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <td><strong>Customer Name </strong></td>
                                                    <td class="text-center"><strong>Customer Mobile</strong></td>
                                                    <td class="text-center"><strong>Address</strong>
                                                    </td>


                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                                <tr>
                                                    <td> {{ $payment['customer']['name'] }}</td>
                                                    <td class="text-center">{{ $payment['customer']['mobile_no'] }}
                                                    </td>
                                                    <td class="text-center">{{ $payment['customer']['address'] }}</td>


                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>


                                </div>
                            </div>

                        </div>
                    </div> <!-- end row -->





                    <div class="row">
                        <div class="col-12">
                            <div>
                                <div class="p-2">

                                </div>
                                <div class="">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <td><strong>Sl </strong></td>
                                                    <td class="text-center"><strong>Category</strong></td>
                                                    <td class="text-center"><strong>Product Name</strong>
                                                    </td>
                                                    <td class="text-end"><strong>Current Stock</strong>
                                                    </td>
                                                    <td class="text-end"><strong>Quantity</strong>
                                                    </td>
                                                    <td class="text-end"><strong>Unit Price </strong>
                                                    </td>
                                                    <td class="text-end"><strong>Total Price</strong>
                                                    </td>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- foreach ($order->lineItems as $line) or some such thing here -->

                                                @php
                                                $total_sum = '0';

                                                $order_details =
                                                App\Models\OrderDetail::where('order_id',$payment->order_id)->get();
                                                @endphp
                                                @foreach($order_details as $key => $details)
                                                <tr>
                                                    <td class="text-center">{{ $key+1 }}</td>
                                                    <td class="text-center">{{ $details['category']['name'] }}</td>
                                                    <td class="text-center">{{ $details['product']['name'] }}</td>
                                                    <td class="text-end">{{ $details['product']['quantity'] }}
                                                    </td>
                                                    <td class="text-end">{{ $details->selling_qty }}</td>
                                                    <td class="text-end">{{ $details->unit_price }}</td>
                                                    <td class="text-end">{{ $details->selling_price }}</td>

                                                </tr>
                                                @php
                                                $total_sum += $details->selling_price;
                                                @endphp
                                                @endforeach
                                                <tr>
                                                    <td class="thick-line"></td>
                                                    <td class="thick-line"></td>
                                                    <td class="thick-line"></td>
                                                    <td class="thick-line"></td>
                                                    <td class="thick-line"></td>
                                                    <td class="thick-line text-center">
                                                        <strong>Subtotal</strong>
                                                    </td>
                                                    <td class="thick-line text-end">Rs.{{ $total_sum }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line text-center">
                                                        <strong>Discount Amount</strong>
                                                    </td>
                                                    <td class="no-line text-end">Rs.{{ $payment->discount_amount }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line text-center">
                                                        {{-- <strong>Paid Amount</strong> --}}
                                                    </td>
                                                    <td class="no-line text-end">
                                                        {{-- Rs.{{ $payment->paid_amount }} --}}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line text-center">
                                                        {{-- <strong>Due Amount</strong> --}}
                                                    </td>
                                                    <td class="no-line text-end">
                                                        {{-- Rs.{{ $payment->due_amount }} --}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line"></td>
                                                    <td class="no-line text-center">
                                                        <strong>Grand Amount</strong>
                                                    </td>
                                                    <td class="no-line text-end">
                                                        <h4 class="m-0">Rs.{{ $payment->total_amount }}</h4>
                                                    </td>
                                                </tr>



                                                {{-- <tr>
                                                    <td colspan="7" style="text-align: center;font-weight: bold;">
                                                        Paid Summary</td>

                                                </tr>

                                                <tr>
                                                    <td colspan="4" style="text-align: center;font-weight: bold;">
                                                        Date </td>
                                                    <td colspan="3" style="text-align: center;font-weight: bold;">
                                                        Amount</td>

                                                </tr> --}}
                                                @php
                                                // $payment_details =
                                                // App\Models\PaymentDetail::where('order_id',$payment->order_id)->get();

                                                @endphp

                                                {{-- @foreach($payment_details as $item)
                                                <tr>
                                                    <td colspan="4" style="text-align: center;font-weight: bold;">{{
                                                        date('d-m-Y',strtotime($item->date)) }}</td>
                                                    <td colspan="3" style="text-align: center;font-weight: bold;">{{
                                                        $item->current_paid_amount }}</td>

                                                </tr>
                                                @endforeach --}}









                                            </tbody>
                                        </table>
                                    </div>                                    
                                </div>
                            </div>

                        </div>
                    </div> <!-- end row -->
















                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

</div>