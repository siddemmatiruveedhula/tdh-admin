@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Invoices</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Invoices List </h4>

                            <div class="table-responsive">
                                <table id="invoiceTable" class="table table-bordered nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Invoice No</th>
                                            <th>Invoice Date</th>
                                            <th>Organization</th>
                                            <th>Customer Name</th>
                                            <th>Order No</th>
                                            <th>Order Date</th>
                                            <th>Order By</th>
                                            <th>Invoice Amount</th>
                                            <th>Supervisor Name</th>
                                            <th>Vehicle No.</th>
                                            <th>No. of Bags</th>
                                            <th>Comment</th>
                                            <th>Vehicle Status</th>
                                            <th></th>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoices as $invKey => $invValue)
                                            <tr>
                                                <td>{{ $invKey + 1 }}</td>
                                                <td>{{ $invValue->vcInvoiceNo }}</td>
                                                <td>{{ date('d/m/Y', strtotime($invValue->dtInvoiceDate)) }}</td>
                                                <td> {{ $invValue['supplier']['name'] ?? '' }} </td>
                                                <td>{{ $invValue['customer']->name }}</td>
                                                <td>#{{ $invValue['order']->order_no }}</td>
                                                <td>{{ date('d/m/Y', strtotime($invValue['order']->date)) }}</td>
                                                <td>{{ $invValue['order']['createdBy']->name }}</td>
                                                <td>{{ 'Rs. ' . $invValue->iTotalAmount }}</td>
                                                <td>{{ $invValue->supervisor->name ?? '' }}</td>
                                                <td>{{ $invValue->vehicle->vehicle_number ?? '' }}</td>
                                                <td>{{ $invValue->total_bags ?? '' }}</td>
                                                <td>{{ $invValue->supervisior_comment ?? '' }}</td>
                                                <td>
                                                    @if ($invValue->iloading_status == 'not_loaded')
                                                        {{ 'Not Loaded' }}
                                                    @elseif($invValue->iloading_status == 'loaded')
                                                        {{ 'Loaded' }}
                                                    @elseif($invValue->iloading_status == 'dispatched')
                                                        {{ 'Dispatched' }}
                                                    @endif

                                                </td>
                                                <td>
                                                    <a href="{{ url($invValue->vcInvoiceDocument) }}"
                                                        class="btn btn-danger sm" title="Download Invoice" download> <i
                                                            class="fa fa-download"></i> </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->



        </div> <!-- container-fluid -->
    </div>
    <script>
        $(document).ready(function() {
            $('#invoiceTable').DataTable({
                dom: 'Blftip',

                buttons: [{
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
                        },
                        title: 'Invoices List',
                    },
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
                        },
                        title: 'Invoices List',
                    },

                ],
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ]
            });
        });
    </script>
@endsection
