@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Assign PJP</h4>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('assign_pjp.create') }}"
                                class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;"><i
                                    class="fas fa-plus-circle"> Add Assign Pjp </i></a> <br> <br>
                            <h4 class="card-title">Assign Pjp List</h4>

                            <table id="yajra-datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <th width="5%">Sl</th>
                                    <th>Date</th>
                                    <th>Employee</th>
                                    {{-- <th>Beat</th> --}}
                                    <th>Status</th>
                                    <th width="20%">Action</th>
                                </thead>

                                <tbody>


                                </tbody>
                            </table>


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
                ajax: "{{ route('assign_pjp.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'emp_name',
                        name: 'emp_name'
                    },
                    // {
                    //     data: 'pjp_beats',
                    //     name: 'pjp_beats'
                    // },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ],
                dom: 'Blftip',

                buttons: [{
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 1, 2]
                        },
                        title: 'Assign PJP List',
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [0, 1, 2]
                        },
                        title: 'Assign PJP List',
                    },

                ],
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ]
            });

            $('body').on('click', '.editPost', function() {
                var id = $(this).data('id');
                $.ajax({
                    type: "get",
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    url: "{{ url('/assign_pjp-edit/') }}" + "/" + id,
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

            });

        });
    </script>


    <script>
        function changeAssignPjpStatus(id) {
            $.ajax({
                type: "put",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                url: "{{ url('/assign_pjp-status/') }}" + "/" + id,
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
@endsection
