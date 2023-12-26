@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Fully Adjusted Payments</h4>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Payments List</h4>

                            <table id="yajra-datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <th width="5%">Sl</th>
                                    <th>Customer Name</th>
                                    <th>Payment Mode</th>
                                    <th>Payment Ref No.</th>
                                    <th>Paid Amount</th>
                                    <th>Paid Date</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Payment Id</th>
                                </thead>

                                <tbody>
                                </tbody>
                            </table>
                            <!-- The Modal -->
                            <div class="modal" id="myModalAdjustedPaymentInvoce" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Adjusted Payment Invoices List</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body" id="modalBody">
                                            <div class="row">
                                                <div class="col-6">
                                                    <h5>Customer Name: <span id="cus_name_s" style="color:#ff0000"></span>
                                                    </h5>
                                                </div>
                                                <div class="col-6">
                                                    <h5>Total Paid Amount: <span id="paid_amount_s"
                                                            style="color:#ff0000"></span></h5>
                                                    </h5>
                                                </div>
                                            </div>


                                            <div class="table-responsive">
                                                <table class="table" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Sl No.</th>
                                                            <th>Invoice No</th>
                                                            <th>Amount</th>
                                                            <th>Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="payment_adjusted_invoice_rows">
                                                    </tbody>


                                                </table>

                                                <br>


                                            </div>
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
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->



        </div> <!-- container-fluid -->
    </div>
    <script type="text/javascript">
        $(function() {

            var table = $('#yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('payment.fully-adjust') }}",
                    data: function(d) {
                        d.search = $('input[type="search"]').val()
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name'
                    },
                    {
                        data: 'payment_mode',
                        name: 'payment_mode'
                    },
                    {
                        data: 'payment_ref_no',
                        name: 'payment_ref_no'
                    },
                    {
                        data: 'paid_amount',
                        name: 'paid_amount'
                    },
                    {
                        data: 'paid_date',
                        name: 'paid_date'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'created_user',
                        name: 'created_user'
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                ],
                columnDefs: [{
                        visible: false,
                        targets: [8],
                    },
                    {
                        targets: 4,
                        orderable: false,
                        render: function(url, type, full) {
                            return (
                                '<a data-bs-toggle="modal" href="#myModalAdjustedPaymentInvoce" id="modalButton" data-bs-target="#myModalAdjustedPaymentInvoce" title="show"' +
                                "onclick=\"getAdjustedInvoice( '" +
                                full.customer_name +
                                "', '" +
                                full.id +
                                "', '" +
                                full.paid_amount +
                                "')\">" +
                                full.paid_amount +
                                "</a>"
                            );
                        },
                    },
                ],
                dom: 'Blftip',

                buttons: [{
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        },
                        title: 'Fully Adjusted Payments List',
                    },
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        },
                        title: 'Fully Adjusted Payments List',
                    },

                ],
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ]

            });

        });
    </script>
    <script>
        function getAdjustedInvoice(customer_name, payment_id, paid_amount) {
            $("#cus_name_s").html(customer_name);
            $("#paid_amount_s").html(paid_amount);
            $.ajax({
                url: "{{ url('api/fetch-invoicesList') }}",
                type: "POST",
                data: {
                    payment_id: payment_id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                beforeSend: function() {
                    $("#payment_adjusted_invoice_rows").html(
                        "<tr><td colspan='5' align='middle'>Loading...</td></tr>"
                    );
                },
                success: function(result) {
                    var rows = "";
                    if (result.paymentInvoices) {
                        var i = 0;
                        $.each(result.paymentInvoices, function(key, item) {
                            var date = item.adjusting_date;
                            var newdate = date.split("-").reverse().join("-");
                            var adjusting_amount = parseFloat(item.adjusting_amount);
                            var invoce_no = item.invoce_no;
                            if (adjusting_amount > 0) {
                                rows += "<tr>";
                                rows += "<td>" + ++i + "</td>";
                                rows += "<td>" + item.invoce_no + "</td>";
                                rows += "<td>" + item.adjusting_amount + "</td>";
                                rows += "<td>" + newdate + "</td>";
                                rows += "</tr>";
                            }
                        });
                    }

                    $("#payment_adjusted_invoice_rows").html(rows);
                }
            });
        }
    </script>
@endsection
