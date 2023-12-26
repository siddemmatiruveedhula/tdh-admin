@inject('carbon', 'Carbon\Carbon')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="order-title">
                                <h4 class="float-start font-size-16"><strong>Invoice No
                                        {{ $invoice->vcInvoiceNo }}</strong></h4>
                            </div>
                        </div>
                    </div>
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
                                                    <td class="text-center"><strong>Payment Mode</strong></td>
                                                    <td class="text-center"><strong>Payment Ref.No.</strong></td>
                                                    <td class="text-center"><strong>Paid Amount</strong></td>
                                                    <td class="text-center"><strong>Adjusted Amount</strong></td>
                                                    <td class="text-center"><strong>Paid Date</strong></td>
                                                    <td class="text-center"><strong>Adjusted date</strong></td>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($invoice_payment_status as $key => $invoice_payment)
                                                    <tr>
                                                        <td class="text-center">{{ $key + 1 }}</td>
                                                        <td class="text-center">
                                                            {{ $invoice_payment->payment->payment_mode }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $invoice_payment->payment->payment_ref_no }}</td>
                                                        <td class="text-center">
                                                            {{ $invoice_payment->payment->paid_amount }}</td>
                                                        <td class="text-center">
                                                            {{ $invoice_payment->adjusting_amount }}</td>
                                                        <td class="text-center">
                                                            {{ $carbon::parse($invoice_payment->payment->paid_date)->format('d-m-Y') }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $carbon::parse($invoice_payment->adjusting_date)->format('d-m-Y') }}
                                                        </td>

                                                    </tr>
                                                @endforeach
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
