@extends('admin.admin_master')
@section('admin')
   

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">State</h4>

                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('state.all') }}">State</a></li>
                            <li class="breadcrumb-item active">ADD</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Add State</h4><br><br>
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
                            <form method="post" class="row g-3" action="{{ route('state.store') }}" id="myForm">
                                @csrf

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">Name <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input name="name" value="{{ old('name') }}" placeholder="State Name"
                                            class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label for="example-text-input" class="form-label"> Country <span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select name="country_id" id="country-dropdown" class="form-select select2">
                                            <option value="">--Select Country --</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="text-left">
                                    <input type="submit" class="btn btn-info waves-effect waves-light" value="Add State">
                                </div>

                            </form>



                        </div>
                    </div>
                </div> <!-- end col -->
            </div>

        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            jQuery.validator.addMethod("lettersonly", function(value, element) {
                return this.optional(element) || /^[A-Za-z ]+$/i.test(value);
            }, "Please enter Letters only");
            $('#myForm').validate({
                rules: {
                    name: {
                        required: true,
                        lettersonly: true,
                    },
                    country_id: {
                        required: true,
                    },

                },
                messages: {
                    name: {
                        required: 'Please Enter State Name',
                    },
                    country_id: {
                        required: 'Please select Country',
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
                },
            });
        });
    </script>
@endsection
