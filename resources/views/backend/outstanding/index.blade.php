@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Outstandings</h4>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="card">
                <div class="card-body">
                    <div class="col-6">
                        <label for="example-text-input" class="col-form-label">Customer</label>
                        <div class="form-group col-sm-12">
                            <select name="customer_id" id="customer_id" class="form-select select2 searchCustomer"
                                aria-label="Select customer">
                                <option value="">--Select Customer--</option>
                                @forelse ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Outstanding List</h4>

                            <table id="yajra-datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <th width="5%">Sl</th>
                                    <th>Customer Name</th>
                                    <th>Invoice No</th>
                                    <th>Total Amount</th>
                                    <th>Paid Amount</th>
                                    <th>Balance</th>
                                    <th>Date</th>
                                    <th>Invoice Id</th>
                                </thead>

                                <tbody>
                                </tbody>
                            </table>
                            <!-- The Modal -->
                            <div class="modal" id="myModalAdjustedPayments" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Adjusted Payments List</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body" id="modalBody">
                                            <div class="row">
                                                <div class="col-4">
                                                    <h5>Customer Name: <span id="cus_name_s" style="color:#ff0000"></span>
                                                    </h5>
                                                </div>
                                                <div class="col-4">
                                                    <h5>Invoice No: <span id="invoice_no_s" style="color:#ff0000"></span>
                                                    </h5>
                                                </div>
                                                <div class="col-4">
                                                    <h5>Total Adjusted Amount: <span id="adjusted_amount_s"
                                                            style="color:#ff0000"></span></h5>
                                                </div>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Sl No.</th>
                                                            <th>Invoice No</th>
                                                            <th>Payment Mode</th>
                                                            <th>Payment Ref No.</th>
                                                            <th>Adjust Amount</th>
                                                            <th>Payment Date</th>
                                                            <th>Adjust Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="payment_adjusted_rows">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script type="text/javascript">
        $(function() {

            var table = $('#yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('outstanding.index') }}",
                    data: function(d) {
                        d.customer = $('.searchCustomer').val(),
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
                        data: 'vcInvoiceNo',
                        name: 'vcInvoiceNo'
                    },
                    {
                        data: 'iTotalAmount',
                        name: 'iTotalAmount'
                    },
                    {
                        data: 'dAdjusted_amount',
                        name: 'dAdjusted_amount'
                    },
                    {
                        data: 'dRemaining_amount',
                        name: 'dRemaining_amount'
                    },
                    {
                        data: 'dtInvoiceDate',
                        name: 'dtInvoiceDate'
                    },
                    {
                        data: 'iInvoiceID',
                        name: 'iInvoiceID'
                    }
                ],
                columnDefs: [{
                        visible: false,
                        targets: [7],
                    },
                    {
                        targets: 4,
                        orderable: false,
                        render: function(url, type, full) {
                            return (
                                '<a data-bs-toggle="modal" href="#myModalAdjustedPayments" id="modalButton" data-bs-target="#myModalAdjustedPayments" title="show"' +
                                "onclick=\"getInvoicePaymentsAdjustment( '" +
                                full.customer_name +
                                "', '" +
                                full.vcInvoiceNo +
                                "', '" +
                                full.iInvoiceID +
                                "','" +
                                full.dAdjusted_amount +
                                "')\">" +
                                full.dAdjusted_amount +
                                "</a>"
                            );
                        },
                    },
                ],
                dom: 'Blftip',

                buttons: [{
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        },
                        title: 'Outstandings List',
                    },
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        },
                        title: 'Outstandings List',
                    },

                ],
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ]
            });
            $("#customer_id").change(function() {
                table.search("").draw();
            });

        });

        function getInvoicePaymentsAdjustment(customer_name, vcInvoiceNo, iInvoiceID, dAdjusted_amount) {
            $("#cus_name_s").html(customer_name);
            $("#invoice_no_s").html(vcInvoiceNo);
            $("#adjusted_amount_s").html(dAdjusted_amount);
            $.ajax({
                url: "{{ url('api/fetch-paymentsList') }}",
                type: "POST",
                data: {
                    invoice_id: iInvoiceID,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                beforeSend: function() {
                    $("#payment_adjusted_rows").html(
                        "<tr><td colspan='6' align='middle'>Loading...</td></tr>"
                    );
                },
                success: function(result) {
                    var rows = "";
                    if (result.paymentList) {
                        var i = 0;
                        $.each(result.paymentList, function(key, item) {
                            var date = item.adjusting_date;
                            var adj_date = date.split("-").reverse().join("-");
                            var date1 = item.pay_date;
                            var paym_date = date1.split("-").reverse().join("-");
                            var adjusting_amount = parseFloat(item.adjusting_amount);
                            var invoce_no = item.invoce_no;
                            var pay_mode = item.pay_mode;
                            var pay_ref_no = item.pay_ref_no;
                            if (adjusting_amount > 0) {
                                rows += "<tr>";
                                rows += "<td>" + ++i + "</td>";
                                rows += "<td>" + item.invoce_no + "</td>";
                                rows += "<td>" + item.pay_mode + "</td>";
                                rows += "<td>" + item.pay_ref_no + "</td>";
                                rows += "<td>" + item.adjusting_amount + "</td>";
                                rows += "<td>" + paym_date + "</td>";
                                rows += "<td>" + adj_date + "</td>";
                                rows += "</tr>";
                            }
                        });
                    }

                    $("#payment_adjusted_rows").html(rows);
                }
            });
        }
    </script>
@endsection
