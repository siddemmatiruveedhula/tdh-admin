@extends('admin.admin_master')
@section('admin')
    

    <div class="page-content">
        <div class="container-fluid">
             <!-- start page title -->
             <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">District</h4>

                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('district.all') }}">District</a></li>
                            <li class="breadcrumb-item active">UPDATE</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Edit District</h4><br><br>
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
                            <form method="post" class="row g-3" action="{{ route('district.update') }}" id="myForm">
                                @csrf

                                <input type="hidden" name="id" value="{{ $district->id }}">

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">Name <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input name="name" value="{{ $district->name }}" class="form-control"
                                            type="text">
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
                                                    {{ old('country_id', $district->country_id) == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label for="example-text-input" class="form-label"> State <span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group ">
                                        <select name="state_id" id="state-dropdown" class="form-select select2">
                                            <option value="">--Select State --</option>
                                            @foreach ($states as $states)
                                                <option value="{{ $states->id }}"
                                                    {{ old('state_id', $district->state_id) == $states->id ? 'selected' : '' }}>
                                                    {{ $states->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">Status<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group ">
                                        <select name="status" class="form-select select2" aria-label="Select status">
                                            <option {{ old('status', $district->status) == 0 ? 'selected' : '' }}
                                                value="0">Inactive
                                            </option>
                                            <option {{ old('status', $district->status) == 1 ? 'selected' : '' }}
                                                value="1">Active
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="text-left">
                                    <input type="submit" class="btn btn-info waves-effect waves-light"
                                        value="Update District">
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
                    state_id: {
                        required: true,
                    },
                    status: {
                        required: true,
                    },

                },
                messages: {
                    name: {
                        required: 'Please Enter District Name',
                    },
                    country_id: {
                        required: 'Please select Country',
                    },
                    state_id: {
                        required: 'Please select State',
                    },
                    status: {
                        required: 'Please select Status',
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
                        if ($('#country-dropdown').val()) {
                            $('#country-dropdown').removeClass('is-invalid');
                        } else {
                            $('#country-dropdown').addClass('is-invalid');
                        }
                        if ($('#state-dropdown').val()) {
                            $('#state-dropdown').removeClass('is-invalid');
                        } else {
                            $('#state-dropdown').addClass('is-invalid');
                        }
                        
                    });
                },
            });
        });
    </script>
    <script>
        $(document).ready(function() {
    
            /*------------------------------------------
            --------------------------------------------
            Country Dropdown Change Event
            --------------------------------------------
            --------------------------------------------*/
            $('#country-dropdown').on('change', function() {
                var idCountry = this.value;
                $("#state-dropdown").html('');
                $.ajax({
                    url: "{{ url('api/fetch-states') }}",
                    type: "POST",
                    data: {
                        country_id: idCountry,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#state-dropdown').html(
                            '<option value="">-- Select State --</option>');
                        $.each(result.states, function(key, value) {
                            $("#state-dropdown").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                        $('#city-dropdown').html('<option value="">-- Select City --</option>');
                    }
                });
            });
    
            /*------------------------------------------
            --------------------------------------------
            State Dropdown Change Event
            --------------------------------------------
            --------------------------------------------*/
            $('#state-dropdown').on('change', function() {
                var idState = this.value;
                $("#city-dropdown").html('');
                $.ajax({
                    url: "{{ url('api/fetch-cities') }}",
                    type: "POST",
                    data: {
                        state_id: idState,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(res) {
                        $('#city-dropdown').html('<option value="">-- Select City --</option>');
                        $.each(res.cities, function(key, value) {
                            $("#city-dropdown").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
    
        });
    </script>
@endsection
