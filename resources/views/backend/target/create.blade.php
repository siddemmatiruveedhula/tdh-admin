@extends('admin.admin_master')
@section('admin')
    

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Targets</h4>

                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('target.index') }}">Target</a></li>
                            <li class="breadcrumb-item active">Add</li>
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

                            <h4 class="card-title">Add Target</h4><br><br>
                            @if (Session::has('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                    @php
                                        Session::forget('success');
                                    @endphp
                                </div>
                            @endif


                            <form method="post" class="row g-3" action="{{ route('target.store') }}" id="myForm">
                                @csrf

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">Employees<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select name="employee_id" id="employee-dropdown" class="form-select select2">
                                            <option value="">--Select Employees --</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}"
                                                    {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                                    {{ $employee->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">Category <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <select name="category_id" id="category_id" class="form-select select2"
                                            onchange="getProducts()">
                                            <option value="">--Select Category --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-4" id="product_id_content">
                                    <label for="product_id" class="form-label">Products <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <select name="product_id" id="product_id" class="form-select select2"
                                            aria-label="Select Sector">

                                            <option value="" disabled selected>--Select Products--</option>
                                            @php
                                                if (old('category_id')) {
                                                    $products = App\Models\Product::select('id', 'name')
                                                        ->where('category_id', old('category_id'))
                                                        ->where('status', true)
                                                        ->get();
                                                }
                                                
                                            @endphp
                                            @if (isset($products))
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}"
                                                        {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                        {{ $product->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">Month and Year<span
                                            class="text-danger">*</span></label>
                                    <div>
                                        <div class="form-group" style="width: 50%; float:left">
                                            <select name="month" class="form-select select2" id="dlMonth">
                                                <option value="">--Select Month--</option>
                                                <option value="January"
                                                    @if (old('month') == 'January') {{ 'selected' }} @endif>January
                                                </option>
                                                <option value="February"
                                                    @if (old('month') == 'February') {{ 'selected' }} @endif>February
                                                </option>
                                                <option value="March"
                                                    @if (old('month') == 'March') {{ 'selected' }} @endif>March
                                                </option>
                                                <option value="April"
                                                    @if (old('month') == 'April') {{ 'selected' }} @endif>April
                                                </option>
                                                <option value="May"
                                                    @if (old('month') == 'May') {{ 'selected' }} @endif>May
                                                </option>
                                                <option value="June"
                                                    @if (old('month') == 'June') {{ 'selected' }} @endif>June
                                                </option>
                                                <option value="July"
                                                    @if (old('month') == 'July') {{ 'selected' }} @endif>July
                                                </option>
                                                <option value="August"
                                                    @if (old('month') == 'August') {{ 'selected' }} @endif>August
                                                </option>
                                                <option value="September"
                                                    @if (old('month') == 'September') {{ 'selected' }} @endif>September
                                                </option>
                                                <option value="October"
                                                    @if (old('month') == 'October') {{ 'selected' }} @endif>October
                                                </option>
                                                <option value="November"
                                                    @if (old('month') == 'November') {{ 'selected' }} @endif>November
                                                </option>
                                                <option value="December"
                                                    @if (old('month') == 'December') {{ 'selected' }} @endif>December
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group" style="width: 50%; float:right">
                                            <select id="year" class="form-select select2" name="year">
                                                <option value="">--SELECT YEAR--</option>
                                                {{ $year = date('Y') }}
                                                @for ($year = 2023; $year <= 3000; $year++)
                                                    <option value="{{ $year }}"
                                                        {{ old('year', date('Y')) == $year ? 'selected' : '' }}>
                                                        {{ $year }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label"> Targets (In QTL) <span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <input name="targets" class="form-control" placeholder="In QTL" type="number"
                                            min="0" oninput="this.value = Math.abs(this.value)"
                                            value="{{ old('targets') }}">
                                        {{-- @if ($errors->has('targets'))
                                            <span class="text-danger">{{ $errors->first('targets') }}</span>
                                        @endif --}}
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="col-4">
                                    <label for="example-text-input" class="form-label">Status<span
                                            class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select name="status" class="form-select" aria-label="Select status">
                                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="text-left">
                                    <input type="submit" class="btn btn-info waves-effect waves-light"
                                        value="Add Target">
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
            $('#myForm').validate({
                rules: {
                    employee_id: {
                        required: true,
                    },
                    category_id: {
                        required: true,
                    },
                    product_id: {
                        required: true,
                    },
                    month: {
                        required: true,
                    },
                    year: {
                        required: true,
                    },
                    targets: {
                        required: true,
                    },
                },
                messages: {
                    employee_id: {
                        required: 'Please Select Employee',
                    },
                    category_id: {
                        required: 'Please Select Category',
                    },
                    product_id: {
                        required: 'Please Select Products',
                    },
                    month: {
                        required: 'Please Select Month',
                    },
                    year: {
                        required: 'Please Enter Year',
                    },
                    targets: {
                        required: 'Target field is required',
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
                        if ($('#employee-dropdown').val()) {
                            $('#employee-dropdown').removeClass('is-invalid');
                        } else {
                            $('#employee-dropdown').addClass('is-invalid');
                        }
                        if ($('#category_id').val()) {
                            $('#category_id').removeClass('is-invalid');
                        } else {
                            $('#category_id').addClass('is-invalid');
                        }
                        if ($('#product_id').val()) {
                            $('#product_id').removeClass('is-invalid');
                        } else {
                            $('#product_id').addClass('is-invalid');
                        }
                        if ($('#dlMonth').val()) {
                            $('#dlMonth').removeClass('is-invalid');
                        } else {
                            $('#dlMonth').addClass('is-invalid');
                        }
                        
                    });
                },
            });
        });
    </script>

    <script>
        function getProducts() {
            let id = $("#category_id").val();
            $.ajax({
                type: "get",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                url: "{{ url('/target-products/') }}" + "/" + id,
                success: function(response) {

                    $("#product_id_content").html(response);
                },
                error: function(err) {
                    console.log(err);
                }
            })
        }

        $(document).ready(function() {
            var currentDate = new Date();

            var curMonth = currentDate.getMonth() + 1;
            $('#dlMonth option:lt(' + curMonth + ')').prop('disabled', 'none');
        });
    </script>

@endsection
