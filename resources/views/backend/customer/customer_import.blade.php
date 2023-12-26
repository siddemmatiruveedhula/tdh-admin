@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Customer</h4>
                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('customer.all') }}">Customers</a></li>
                            <li class="breadcrumb-item active">Import</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end page title -->

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Import Customers </h4><br><br>



                            <p>The first line in downloaded excel file should remain as it is.Please do not change the order
                                of
                                columns in excel file.
                            <p>

                            <p>The correct column order is ( Customer name, customer type, customer code, GST No, Mobile No,
                                Country, State, District, city, area, pincode, address ) and you must follow the excel file,
                                otherwise you will
                                get
                                an error while importing the excel file.</p>
                            <div style="margin-bottom: 10px;">
                                <a href="{{ route('customer.download-file') }}" aria-label="" class="btn btn-info"><i
                                        class="fa fa-download"></i>
                                    <span> Download Sample File
                                    </span></a>
                            </div>

                            <form method="post" class="row g-3" action="{{ route('customer.store-import-customers') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-4">
                                    <label for="example-text-input" class="form-label"> Upload </label>
                                    <div class="form-group ">
                                        <input name="file" id="excel-file" class="form-control" type="file" accept=".xlsx,.csv">
                                    </div>
                                    <span>Please select excel file</span>
                                </div>
                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">&nbsp;</label>
                                    <div class="form-group ">
                                        <input type="submit" class="btn btn-info waves-effect waves-light" value="Submit">
                                    </div>
                                </div>
                                <!-- end row -->
                            </form>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>

        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {

            if (document.getElementById("excel-file").files.length == 0) {
                $('input[type="submit"]').attr('disabled', 'disabled');
            } else {
                $('input[type="submit"]').removeAttr('disabled');
            }

            $("#excel-file").on("change", function(e) {
                if (this.files[0].type) {
                    $('input[type="submit"]').removeAttr('disabled');
                } else {
                    $('input[type="submit"]').attr('disabled', 'disabled');
                }
            });
        });
    </script>
@endsection
