@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Factory Sale List</h4>



                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Factory Sale List</h4>

                            <div class="table-responsive">
                                <table id="factorySaleTable" class="table table-bordered nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Visitor Name</th>
                                            <th>Phone Number</th>
                                            <th>Visitor City</th>
                                            <th>Bill No.</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Created By</th>
                                            <th>Action</th>
                                        </tr>

                                    </thead>


                                    <tbody>

                                        @foreach ($sale_orders as $key => $sale_order)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $sale_order->visitor->visitor_name }}</td>
                                                <td>{{ $sale_order->visitor->visitor_phone }}</td>
                                                <td>{{ $sale_order->visitor->visitor_city }}</td>
                                                <td>{{ $sale_order->bill_no }}</td>
                                                <td>{{ $sale_order->amount }}</td>
                                                <td>{{ date('d-m-Y',strtotime($sale_order->visitor->check_in_date)) }}</td>
                                                <td>{{ $sale_order->createdUser->name }}</td>
                                                <td>
                                                    @if ($sale_order->visitor->check_out_date == '' && $sale_order->visitor->check_in_date == date('Y-m-d') )
                                                        <a href="{{ route('saleorder.edit', $sale_order->id) }}"
                                                            class="btn btn-info sm" title="Edit Data"> <i
                                                                class="fa fa-edit"></i> </a>
                                                    @endif
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
            $('#factorySaleTable').DataTable({
                dom: 'Blftip',
               
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1,2,3,4,5,6,7]
                        },
                        title: 'Factory Sale List',
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1,2,3,4,5,6,7]
                        },
                        title: 'Factory Sale List',
                    },
                    
                ],
                lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
            });
        });
    </script>
@endsection
