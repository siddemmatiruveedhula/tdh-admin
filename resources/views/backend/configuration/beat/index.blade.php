@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Beats</h4>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('beat.create') }}" class="btn btn-dark btn-rounded waves-effect waves-light"
                                style="float:right;"><i class="fas fa-plus-circle"> Add Beat </i></a> <br> <br>
                            <h4 class="card-title">Beats List</h4>

                            <table id="beatTable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <th width="5%">Sl</th>
                                    <th>Name</th>
                                    <th>City</th>
                                    <th>Supplier</th>
                                    <th>Status</th>
                                    <th>Total Customers</th>
                                    <th width="20%">Action</th>
                                </thead>

                                <tbody>
                                    @foreach ($beats as $key => $beat)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ $beat->name }} </td>
                                            <td> {{ $beat->city->name ?? '' }} </td>
                                            <td> {{ $beat->suplier->name ?? '' }} </td>
                                            <td>
                                                @if ($beat->status == 1)
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" checked
                                                            onchange="changeBeatStatus({{ $beat->id }})">
                                                    </div>
                                                @else
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            onchange="changeBeatStatus({{ $beat->id }})">
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <a data-bs-toggle="modal" id="modalButton" data-bs-target="#myModal"
                                                    data-attr="{{ route('beat.show', $beat->id) }}" title="show"
                                                    class="btn btn-info sm">{{ $beat->customers_count }}
                                                </a>
                                                <a href="{{ route('assign-customers-to-beat', $beat->id) }}" class="btn btn-info sm"
                                                    title="Assigning Customers">+ / -</a>
                                            <td>
                                                <a href="{{ route('beat.edit', $beat->id) }}" class="btn btn-info sm"
                                                    title="Edit Data"> <i class="fas fa-edit"></i> </a>
                                                
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <!-- The Modal -->
                            <div class="modal" id="myModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Customers List</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body" id="modalBody">                                            
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
    <script>
        function changeBeatStatus(id) {
            $.ajax({
                type: "put",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                url: "{{ url('/beat-status/') }}" + "/" + id,
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
    </script>
   
    <script>
        $(document).on('click', '#modalButton', function(event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            $.ajax({
                url: href,
                // return the result
                success: function(response) {
                    // console.log(response);
                    $('#myModal').modal("show");
                    $('#modalBody').html(response).show();
                },
            })
        });
        $(document).ready(function() {
            $('#beatTable').DataTable({
                dom: 'Blftip',
               
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 5,]
                        },
                        title: 'Beats List',
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 5,]
                        },
                        title: 'Beats List',
                    },
                    
                ],
                lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
            });
        });
    </script>
@endsection
