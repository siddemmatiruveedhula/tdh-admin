@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Approved Orders</h4>



                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <!-- <a href="{{ route('order.add') }}" class="btn btn-dark btn-rounded waves-effect waves-light"
                                                    style="float:right;"><i class="fas fa-plus-circle"> Add Order </i></a> <br> <br>

                                                <h4 class="card-title">Order All Data </h4> -->


                            <table id="orderApproveTable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Organization</th>
                                        <th>Customer Name</th>
                                        <th>Order No </th>
                                        <th>Date </th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Action</th>

                                </thead>


                                <tbody>

                                    @foreach ($allData as $key => $item)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ $item['supplier']['name'] ?? '' }} </td>
                                            <td> {{ $item['payment']['customer']['name'] }} </td>
                                            <td> #{{ $item->order_no }} </td>
                                            <td> {{ date('d-m-Y', strtotime($item->date)) }} </td>


                                            <td> {{ $item->description }} </td>

                                            <td> RS. {{ $item['payment']['total_amount'] }} </td>

                                            <td>
                                                <a href="{{ route('print.order', $item->id) }}" class="btn btn-danger sm"
                                                    title="Print Order"> <i class="fa fa-print"></i> </a>
                                                <a href="{{ route('invoice.genrate', $item->id) }}" class="btn btn-dark sm"
                                                    title="Genrate Invoice"> <i class="fa fa-file-text-o"></i> </a>
                                                @if (count($item->invoices) > 0)
                                                @else
                                                    <a href="{{ route('order.pending', $item->id) }}"
                                                        class="btn btn-dark sm move-order-pending"
                                                        title="Move to Pending Order"> <i class="fa fa-arrows"></i> </a>
                                                    
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->



        </div> <!-- container-fluid -->
    </div>
@endsection
@section('js-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '.move-order-pending', function() {
                confirmCheck = confirm(
                    "Are you sure you want to move selected approved order to pending order?");
                if (confirmCheck) {
                    return true;
                }
                return false;
            })
        });
    </script>
    <script>
   
        $(document).ready(function() {
            $('#orderApproveTable').DataTable({
                dom: 'Blftip',
    
                buttons: [{
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        },
                        title: 'Approved Orders List',
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        },
                        title: 'Approved Orders List',
                    },
    
                ],
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ]
            });
        });
    </script>
@endsection`
