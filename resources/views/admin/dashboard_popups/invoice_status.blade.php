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
                                        {{ $invoice_status->vcInvoiceNo }}</strong></h4>
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
                                                    <td class="text-center"><strong>Supervisor Name</strong></td>
                                                    <td class="text-center"><strong>Vehicle No</strong></td>
                                                    <td class="text-center"><strong>Transportation Name</strong></td>
                                                    <td class="text-center"><strong>Driver Name</strong></td>
                                                    <td class="text-center"><strong>Driver Mobile No</strong></td>
                                                    <td class="text-center"><strong>Vehicle in time</strong></td>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                <tr>
                                                    <td class="text-center">{{ $invoice_status->supervisor->name }}</td>
                                                    <td class="text-center">{{ $invoice_status->vehicle->vehicle_number }}</td>
                                                    <td class="text-center">{{ $invoice_status->vehicle->transportation->name }}</td>
                                                    <td class="text-center">{{ $invoice_status->vehicle->driver_name }}</td>
                                                    <td class="text-center">{{ $invoice_status->vehicle->driver_phone }}</td>
                                                    <td class="text-center">{{ $carbon::parse($invoice_status->vehicle->check_in_date)->format('d-m-Y') }} {{ $invoice_status->vehicle->check_in_time }}</td>

                                                </tr>
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
