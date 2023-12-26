@inject('carbon', 'Carbon\Carbon')
@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Visitor</h4>



                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Visitor List </h4>

                            <div class="table-responsive">
                                <table id="visitorsTable" class="table table-bordered nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Visitor Name</th>
                                            <th>Phone Number</th>
                                            <th>Visitor City</th>
                                            <th>Visitor From</th>
                                            <th>Card No.</th>
                                            <th>Card Submit</th>
                                            <th>Agenda</th>
                                            <th>Whom To Meet</th>
                                            <th>Check In Date & Time </th>
                                            <th>Check out Date & Time</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>

                                    </thead>


                                    <tbody>

                                        @foreach ($visitors as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->visitor_name }}</td>
                                                <td>{{ $item->visitor_phone }}</td>
                                                <td>{{ $item->visitor_city }}</td>
                                                <td>{{ $item->visitor_from }}</td>
                                                <td>{{ $item->card_no }}</td>
                                                <td>
                                                    @if ($item->card_submit == 1)
                                                        Yes
                                                    @else
                                                        No
                                                    @endif
                                                </td>
                                                <td>{{ $item->agenda }}</td>
                                                <td>{{ $item->whom_to_meet }}</td>

                                                <td>
                                                    @if ($item->check_in_date)
                                                        {{ $carbon::parse($item->check_in_date)->format('d-m-Y') }}
                                                        {{ $item->check_in_time }}
                                                    @else
                                                        {{ null }}
                                                    @endif
                                                </td>


                                                {{-- <td>{{ $item->check_out_time }}</td> --}}
                                                <td>
                                                    @if ($item->check_out_date)
                                                        {{ $carbon::parse($item->check_out_date)->format('d-m-Y') }}
                                                        {{ $item->check_out_time }}
                                                    @else
                                                        {{ null }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->status == 1)
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" checked
                                                                onchange="changeVisitorStatus({{ $item->id }})">
                                                        </div>
                                                    @else
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                onchange="changeVisitorStatus({{ $item->id }})">
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('visitor.edit', $item->id) }}"
                                                        class="btn btn-info sm" title="Edit Data"> <i
                                                            class="fa fa-edit"></i> </a>
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
        function changeVisitorStatus(id) {
            $.ajax({
                type: "put",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                url: "{{ url('/visitor-status/') }}" + "/" + id,
                success: function(response) {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true
                    }
                    toastr.success(response)
                },
                error: function(err) {
                    console.log(err);
                }
            })
        }
        $(document).ready(function() {
            $('#visitorsTable').DataTable({
                dom: 'Blftip',
               
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        },
                        title: 'Visitors List',
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        },
                        title: 'Visitors List',
                    },
                    
                ],
                lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
            });
        });
    </script>
@endsection
