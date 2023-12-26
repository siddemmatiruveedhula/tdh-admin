@inject('carbon', 'Carbon\Carbon')
@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Ledger</h4>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" class="row g-3" action="{{ route('ledger.fetch') }}" id="myForm">
                                @csrf
                                <div class="col-4">
                                    <label for="example-text-input" class="col-form-label">Customer</label>
                                    <div class="form-group col-sm-12">
                                        <select name="customer_id" id="customer_id"
                                            class="form-select select2 searchCustomer" aria-label="Select customer">
                                            <option value="">--Select Customer--</option>
                                            @forelse ($customers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    {{ old('customer_id', $cus_id) == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label for="example-text-input" class="col-form-label">From Date</label>
                                    <div class="form-group col-sm-12">
                                        <input name="from_date" class="form-control example-date-input" type="date"
                                            id="from_date"
                                            @if ($from_date != '') value="{{ $from_date }}"
                                            @else
                                            value="{{ date('Y-m-01') }}" @endif>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label for="example-text-input" class="col-form-label">To Date</label>
                                    <div class="form-group col-sm-12">
                                        <input name="to_date" class="form-control example-date-input" type="date"
                                            id="to_date"
                                            @if ($to_date != '') value="{{ $to_date }}"
                                            @else
                                            value="{{ date('Y-m-d') }}" @endif
                                            min='Y-m-01'>
                                    </div>
                                </div>
                                <div class="text-left">
                                    <input type="submit" id="search_ledger"
                                        class="btn btn-info waves-effect waves-light pull-right" value="Search">
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            @if (count($ledger_rows) > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Ledger</h4>

                                <table id="yajra-datatable" class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <th width="5%">Sl</th>
                                        <th>Date</th>
                                        <th>Transaction Type</th>
                                        <th>Order No</th>
                                        <th>Ref No</th>
                                        <th>Debit Amt</th>
                                        <th>Credit Amt</th>
                                        <th>Balance</th>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td align="right">{{ $balance_amount ?? '0' }}</td>
                                        </tr>
                                        @if (count($ledger_rows) > 0)
                                            @php
                                                $debit = 0;
                                                $credit = 0;
                                            @endphp
                                            @foreach ($ledger_rows as $key => $row)
                                                @php
                                                    if ($row->transaction_type == 'Debit') {
                                                        $debit += $row->amount;
                                                        $row->debit = $row->amount;
                                                        $row->credit = 0;
                                                    } else {
                                                        $row->debit = 0;
                                                        $credit += $row->amount;
                                                        $row->credit = $row->amount;
                                                    }
                                                    $balance_amount = $balance_amount + $row->debit - $row->credit;
                                                @endphp
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($row->doc_date)) }}</td>
                                                    <td> {{ $row->transaction_name }} </td>
                                                    <td>
                                                        @if ($row->order_number != '')
                                                            {{ '#' . $row->order_number }}
                                                        @else
                                                            {{ '' }}
                                                        @endif
                                                    </td>
                                                    <td> {{ $row->ref_no }} </td>
                                                    <td align="right">
                                                        @if ($row->transaction_type == 'Debit')
                                                            {{ $row->amount }}
                                                        @endif
                                                    </td>
                                                    <td align="right">
                                                        @if ($row->transaction_type == 'Credit')
                                                            {{ $row->amount }}
                                                        @endif
                                                    </td>
                                                    <td align="right"> {{ $balance_amount }} </td>

                                                </tr>
                                            @endforeach
                                        @endif
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Total</td>
                                            <td align="right"> {{ $debit }} </td>
                                            <td align="right"> {{ $credit }} </td>
                                            <td align="right"> {{ $balance_amount }} </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            @endif



        </div> <!-- container-fluid -->
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script type="text/javascript">
        // var today = new Date();
        // var from_date = document.getElementById("from_date").val();
        // console.log(from_date);
        // var dd = today.getDate();
        // var mm = today.getMonth() + 1; //January is 0!
        // var yyyy = today.getFullYear();
        // if (dd < 10) {
        //     dd = '0' + dd
        // }
        // if (mm < 10) {
        //     mm = '0' + mm
        // }

        // today = yyyy + '-' + mm + '-' + dd;
        // document.getElementById("to_date").setAttribute("min", today);


        // var userDate = document.getElementById("from_date");
        var date = new Date($('#from_date').val()),
            yr = date.getFullYear(),
            month = date.getMonth() + 1,
            day = date.getDate();
        if (day < 10) {
            day = '0' + day
        }
        if (month < 10) {
            month = '0' + month
        }
        date = yr + '-' + month + '-' + day;
        var min = document.getElementById("to_date").setAttribute("min", date);
        console.log(date);



        $(document).ready(function() {

            $('#from_date').on('change', function() {

                var date = new Date($('#from_date').val()),
                    yr = date.getFullYear(),
                    month = date.getMonth() + 1,
                    day = date.getDate();
                if (day < 10) {
                    day = '0' + day
                }
                if (month < 10) {
                    month = '0' + month
                }
                date = yr + '-' + month + '-' + day;
                var min = document.getElementById("to_date").setAttribute("min", date);
                console.log(date);
            });

            $('#myForm').validate({
                rules: {
                    customer_id: {
                        required: true,
                    },

                },
                messages: {
                    customer_id: {
                        required: 'Please Select Customer',
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    $('select').on('change', function() {
                        if ($('#customer_id').val()) {
                            $('#customer_id').removeClass('is-invalid');
                        } else {
                            $('#customer_id').addClass('is-invalid');
                        }


                    });
                },
            });
        });
    </script>
     <script>
      
        $(document).ready(function() {
            $('#yajra-datatable').DataTable({
                dom: 'Blftip',
               
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1,2,3,4,5,6,7]
                        },
                        title: 'Ledger List',
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1,2,3,4,5,6,7]
                        },
                        title: 'Ledger List',
                    },
                    
                ],
                lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
            });
        });
    </script>
@endsection
