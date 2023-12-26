@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Adjust Payments</h4>

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
                                    <th>Unadjusted Amount</th>
                                    <th>Adjusted Amount</th>
                                    <th>Paid Date</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Payment Id</th>
                                    <th>Customer Id</th>
                                    <th>Payment Date</th>
                                </thead>

                                <tbody>
                                </tbody>
                            </table>
                            <!-- The Modal -->
                            <div class="modal" id="myModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Adjustment Payment</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body" id="modalBody">
                                            <form class="form-horizontal" role="form" method="post"
                                                id="parital_adjust_payment_form">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h5>Customer Name: <span id="customer_name_s"
                                                                style="color:#ff0000"></span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-6">
                                                        <h5>Unadjusted Amount: <span id="total_remaining_amount_s"
                                                                style="color:#ff0000"></span>
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <label for="example-text-input" class="col-form-label">Outstanding <span
                                                            class="text-danger">*</span></label>
                                                    <div class="form-group col-sm-12">
                                                        <select id="oustanding_balance" name="oustanding_balance"
                                                            class="nostyle form-control">
                                                            <option selected disabled>Select Outstanding</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <label for="example-text-input" class="col-form-label">Adjusting Amount
                                                        <span class="text-danger">*</span></label>
                                                    <div class="form-group col-sm-12">
                                                        <input type="text" id="adjust_amount" name="adjust_amount"
                                                            class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <label for="example-text-input" class="col-form-label">Adjusting Date
                                                        <span class="text-danger">*</span></label>

                                                    <input name="adjust_amount_date" class="form-control example-date-input"
                                                        type="date" id="adjust_amount_date" value="{{ date('Y-m-d') }}">
                                                </div>
                                                <br />
                                                <div class="text-left">
                                                    <input type="hidden" name="total_remaining_amount"
                                                        id="total_remaining_amount">
                                                    <input type="hidden" name="adjust_payment_id" id="adjust_payment_id">
                                                    <button type="submit" name="submit_adjust_payment_amt"
                                                        id="submit_adjust_payment_amt" class="btn btn-info">Save</button>
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <input type="hidden" name="adjust_customer_id" id="adjust_customer_id">
                                                    <p id="error_msg" name="error_msg" class="text-danger"
                                                        style="display: none;">Invalid Amount</p>
                                                </div><!-- End .form-group  -->

                                            </form>
                                        </div>
                                        <!-- Modal footer -->
                                    </div>
                                </div>
                            </div>

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
                    url: "{{ route('payment.partial-adjust') }}",
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
                        data: 'remaining_amount',
                        name: 'remaining_amount'
                    },
                    {
                        data: 'adjusted_amount',
                        name: 'adjusted_amount'
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
                        data: 'payment_id',
                        name: 'payment_id'
                    },
                    {
                        data: 'customer_id',
                        name: 'customer_id'
                    },
                    {
                        data: 'payment_date',
                        name: 'payment_date'
                    },
                ],

                columnDefs: [{
                        visible: false,
                        targets: [10, 11, 12],
                    },
                    {
                        targets: 5,
                        orderable: false,
                        render: function(url, type, full) {
                            return (
                                '<a data-bs-toggle="modal" href="#myModal" id="modalButton" data-bs-target="#myModal" title="show"' +
                                "onclick=\"getInvoicePaymentsAdjustment( '" +
                                full.customer_name +
                                "', '" +
                                full.customer_id +
                                "', '" +
                                full.remaining_amount +
                                "','" +
                                full.payment_id +
                                "','" +
                                full.payment_date +
                                "')\">" +
                                full.remaining_amount +
                                "</a>"
                            );
                        },
                    },
                    {
                        targets: 6,
                        orderable: false,
                        render: function(url, type, full) {
                            return (
                                '<a data-bs-toggle="modal" href="#myModalAdjustedPaymentInvoce" id="modalButton" data-bs-target="#myModalAdjustedPaymentInvoce" title="show"' +
                                "onclick=\"getAdjustedInvoice( '" +
                                full.customer_name +
                                "', '" +
                                full.payment_id +
                                "', '" +
                                full.adjusted_amount +
                                "')\">" +
                                full.adjusted_amount +
                                "</a>"
                            );
                        },
                    },
                ],
                dom: 'Blftip',

                buttons: [{
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                        },
                        title: 'Adjust Payments List',
                    },
                    {
                        extend: 'pdf',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                        },
                        title: 'Adjust Payments List',
                    },

                ],
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ]
            });

            $("#parital_adjust_payment_form").validate({
                // Specify validation rules
                rules: {
                    // The key name on the left side is the name attribute
                    // of an input field. Validation rules are defined
                    // on the right side
                    oustanding_balance: "required",
                    adjust_amount: "required",
                    adjust_amount_date: "required",


                },
                // Specify validation error messages
                messages: {
                    // response_msg: "Please Enter the message",

                },
                // Make sure the form is submitted to the destination defined
                // in the "action" attribute of the form when valid
                submitHandler: function(form) {
                    var is_amt_ok = false;
                    //For Advance Amount
                    var total_remaining_amount = $("#total_remaining_amount").val();
                    var remaining_amt = parseFloat(total_remaining_amount);
                    //For Select Advance Amount
                    if ($('#oustanding_balance').val() != '')
                        var selected_amt = $('#oustanding_balance').val().split(',')[2];
                    else
                        var selected_amt = total_remaining_amount;
                    //For adv adjust amt
                    var adjust_amount = $("#adjust_amount").val();
                    adjst_amt = parseFloat(adjust_amount);


                    var invoice_id = $('#oustanding_balance').val().split(',')[0];
                    var order_id = $('#oustanding_balance').val().split(',')[1];
                    var adjust_amount = $("#adjust_amount").val();
                    var adjust_amount_date = $("#adjust_amount_date").val();
                    var adjust_payment_id = $("#adjust_payment_id").val();
                    var adjust_customer_id = $("#adjust_customer_id").val();


                    if ((adjst_amt <= remaining_amt) && (adjst_amt <= selected_amt)) {
                        is_amt_ok = true;

                    } else {
                        is_amt_ok = false;

                    }

                    if (is_amt_ok == true) {

                        $.ajax({
                            url: "{{ url('api/save-adjustment-payment') }}",
                            type: "POST",
                            dataType: "json",
                            data: {
                                invoice_id: invoice_id,
                                order_id: order_id,
                                adjust_payment_id: adjust_payment_id,
                                adjust_amount: adjust_amount,
                                adjust_amount_date: adjust_amount_date,
                                adjust_customer_id: adjust_customer_id,
                                _token: '{{ csrf_token() }}'
                            },
                            beforeSend: function() {
                                $("#submit_adjust_payment_amt").html("Please wait..");
                                $('#submit_adjust_payment_amt').attr('disabled', true);

                            },

                            success: function(response) {
                                if (response.status) {
                                    setTimeout(
                                        function() {
                                            $("#submit_adjust_payment_amt").html(
                                                "Save");
                                            $('#myModal').modal('toggle');
                                            $('#submit_adjust_payment_amt').attr(
                                                'disabled', false);
                                            table.ajax.reload();
                                        }, 1000);
                                }
                            }
                        })
                        return false;

                    } else {
                        $('#error_msg').show();

                    }

                }
            });

        });
    </script>
    <script>
        function getInvoicePaymentsAdjustment(customer_name, customer_id, remaining_amount, payment_id, payment_date) {
            $("#customer_name_s").html(customer_name);
            $("#total_remaining_amount_s").html(remaining_amount);
            $("#total_remaining_amount").val(remaining_amount);
            $("#adjust_payment_id").val(payment_id);
            $("#adjust_customer_id").val(customer_id);
            $("#adjust_amount").val("");
            $("#adjust_amount_date").val("");
            $("#error").hide();

            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();
            today = yyyy + '-' + mm + '-' + dd;
            $('#adjust_amount_date').attr('max', today);
            var payment_d = new Date(payment_date);
            var p_dd = String(payment_d.getDate()).padStart(2, '0');
            var p_mm = String(payment_d.getMonth() + 1).padStart(2, '0');
            var p_yyyy = payment_d.getFullYear();
            payment_d = p_yyyy + '-' + p_mm + '-' + p_dd;
            $('#adjust_amount_date').attr('min', payment_d);
            $.ajax({
                url: "{{ url('api/fetch-outstandings') }}",
                type: "POST",
                data: {
                    customer_id: customer_id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                beforeSend: function() {

                    $("#oustanding_balance").html("Loading");
                },
                success: function(result) {
                    $('#oustanding_balance').html(
                        '<option value="">-- Select Outstanding --</option>');
                    $.each(result.invoices_list, function(key, value) {
                        $("#oustanding_balance").append('<option value="' + value.iInvoiceID + ',' +
                            value.iOrderID + ',' + value
                            .dRemaining_amount + '">' + value.dRemaining_amount + ' (' + value
                            .vcInvoiceNo +
                            ')</option>');
                    });
                }
            });
        }

        function getAdjustedInvoice(customer_name, payment_id, adjusted_amount) {
            $("#cus_name_s").html(customer_name);
            $("#adjusted_amount_s").html(adjusted_amount);
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
