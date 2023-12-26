@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Pending Orders</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive">

                            <!-- <a href="{{ route('order.add') }}" class="btn btn-dark btn-rounded waves-effect waves-light"
                                style="float:right;"><i class="fas fa-plus-circle"> Add Order </i></a> <br> <br> -->

                            <!-- <h4 class="card-title">Order All Data </h4> -->


                            <table id="orderPendingTable" class="table table-bordered nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Organization</th>
                                        <th>Customer Name</th>
                                        <th>Order No </th>
                                        <th>Amount</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Created On</th>
                                        <th>Created by</th>
                                        <th>Action</th>

                                </thead>


                                <tbody>

                                    @foreach ($allData as $key => $item)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ $item['supplier']['name'] ?? '' }} </td>
                                            <td> {{ $item['payment']['customer']['name'] ?? ''}} </td>
                                            <td> #{{ $item->order_no }} </td>

                                            <td> RS. {{ $item['payment']['total_amount'] ?? '' }} </td>
                                            <td> {{ $item->description }} </td>
                                            <td>
                                                @if ($item->status == '0')
                                                    <span class="btn btn-warning">Pending</span>
                                                @elseif($item->status == '1')
                                                    <span class="btn btn-success">Approved</span>
                                                @endif
                                            </td>

                                            <td> {{ date('d-m-Y h:i A', strtotime($item->created_at)) }} </td>

                                            <td> {{ $item->createdBy->name }} </td>

                                            <td>
                                                @if ($item->status == '0')
                                                    <a href="{{ route('order.edit', $item->id) }}"
                                                            class="btn btn-dark sm" title="Edit"> <i
                                                                class="fas fa-edit"></i> </a>

                                                    {{--<a href="{{ route('order.approve', $item->id) }}"
                                                        class="btn btn-dark sm" title="Approved Data"> <i
                                                            class="fas fa-check-circle"></i> </a>--}}

                                                    <!-- <a href="{{ route('order.delete', $item->id) }}"
                                                        class="btn btn-danger sm" title="Delete Data" id="delete"> <i
                                                            class="fas fa-trash-alt"></i> </a> -->
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
    <script>
   
        $(document).ready(function() {
            $('#orderPendingTable').DataTable({
                dom: 'Blftip',

                buttons: [{
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7,8]
                        },
                        title: 'Pending Orders List',
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7,8]
                        },
                        title: 'Pending Orders List',
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
