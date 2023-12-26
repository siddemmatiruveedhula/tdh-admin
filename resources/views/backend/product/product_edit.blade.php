@extends('admin.admin_master')
@section('admin')
    

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Product</h4>

                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('product.all') }}">Product</a></li>
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

                            <h4 class="card-title">Update Product</h4><br><br>



                            <form method="post" class="row g-3" action="{{ route('product.update') }}" id="myForm">
                                @csrf

                                <input type="hidden" name="id" value="{{ $product->id }}">

                                {{-- <div class="col-6">
                                    <label class="form-label">Organization Name <span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <select name="supplier_id" id="supplier_id" class="form-select select2"
                                            aria-label="Default select example">
                                            <option value="">Open this select menu</option>
                                            @foreach ($supplier as $supp)
                                                <option value="{{ $supp->id }}"
                                                    {{ $supp->id == $product->supplier_id ? 'selected' : '' }}>
                                                    {{ $supp->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}

                                <div class="col-6">
                                    <label class="form-label">Category Name <span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <select name="category_id" id="category_id" class="form-select select2"
                                            aria-label="Default select example">
                                            <option value="">Open this select menu</option>
                                            @foreach ($category as $cat)
                                                <option value="{{ $cat->id }}"
                                                    {{ $cat->id == $product->category_id ? 'selected' : '' }}>
                                                    {{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">Product Name <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input name="name" value="{{ $product->name }}" placeholder="Product Name"
                                            class="form-control" type="text">
                                    </div>
                                </div>
                                <!-- end row -->



                                <!-- end row -->

                                <div class="col-6">
                                    <label class="form-label">Unit Name<span class="text-danger">*</span> </label>
                                    <div class="form-group">
                                        <select name="unit_id" id="unit_id" class="form-select select2"
                                            aria-label="Default select example">
                                            <option value="">Open this select menu</option>
                                            @foreach ($unit as $uni)
                                                <option value="{{ $uni->id }}"
                                                    {{ $uni->id == $product->unit_id ? 'selected' : '' }}>
                                                    {{ $uni->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="col-6">
                                    <label class="form-label">Brand Name</label>
                                    <div class="form-group">
                                        <select name="brand_id" id="brand_id" class="form-select select2"
                                            aria-label="Default select example">
                                            <option selected="" value="">Open this select menu</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ $brand->id == $product->brand_id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>




                                <!-- end row -->

                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">Default Price<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input name="default_price" id="default_price" class="form-control"
                                            placeholder="Default Price" type="text"
                                            value="{{ $product->default_price }}">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">Minimum Price (MRP)<span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input name="min_price" id="min_price" class="form-control"
                                            placeholder="Minimum Price" type="text" value="{{ $product->min_price }}">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">Max Price (MRP) <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input name="max_price" id="max_price" class="form-control"
                                            placeholder="Max Price (MRP)" type="text" value="{{ $product->max_price }}">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="total_weight_in_qtl" class="form-label">Total Weight (in QTL) <span
                                            class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input name="total_weight_in_qtl" class="form-control"
                                            placeholder="Total Weight (in QTL)" type="number"
                                            value="{{ $product->total_weight_in_qtl }}" min="0"
                                            {{-- oninput="this.value = Math.abs(this.value)" --}}>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">GST(%)</label>
                                    <div class="form-group">
                                        <input name="gst" class="form-control" placeholder="GST" type="text"
                                            value="{{ $product->gst }}">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">HSN CODE</label>
                                    <div class="form-group">
                                        <input name="hsn_no" class="form-control" placeholder="HSN CODE" type="text"
                                            value="{{ $product->hsn_no }}">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">Is CESS
                                        Applicable</label>
                                    <div class="form-group">
                                        <select name="is_cess" id="is_cess" class="form-select"
                                            aria-label="Select Display At">
                                            <option {{ old('is_cess', $product->is_cess) == 'Yes' ? 'selected' : '' }}
                                                value="Yes">Yes
                                            </option>
                                            <option {{ old('is_cess', $product->is_cess) == 'No' ? 'selected' : '' }}
                                                value="No">No
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">Ad Val</label>
                                    <div class="form-group">
                                        <input name="ad_val" class="form-control" placeholder="Ad Val" type="text"
                                            value="{{ $product->ad_val }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">Units Per Case</label>
                                    <div class="form-group">
                                        <input name="units_per_case" class="form-control" placeholder="Units Per Case"
                                            type="text" value="{{ $product->units_per_case }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">Is PromoSKU</label>
                                    <div class="form-group">
                                        <select name="is_promo_sku" id="is_promo_sku" class="form-select"
                                            aria-label="Select Display At">
                                            <option
                                                {{ old('is_promo_sku', $product->is_promo_sku) == 'Yes' ? 'selected' : '' }}
                                                value="Yes">Yes
                                            </option>
                                            <option
                                                {{ old('is_promo_sku', $product->is_promo_sku) == 'No' ? 'selected' : '' }}
                                                value="No">No
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="example-text-input" class="form-label">SKU Code</label>
                                    <div class="form-group">
                                        <input name="sku_code" class="form-control" placeholder="SKU Code"
                                            type="text" value="{{ $product->sku_code }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="product_description" class="form-label">Product
                                        Description</label>
                                    <div class="form-group">
                                        <textarea name="product_description" id="product_description" placeholder="Please Enter Product Description..."
                                            class="form-control">{{ old('product_description', $product->product_description) }}</textarea>
                                    </div>
                                </div>
                                <div class="text-left">
                                    <input type="submit" class="btn btn-info waves-effect waves-light"
                                        value="Update Product">
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
            jQuery.validator.addMethod("valdiateMinPrice", function(value, element) {
                var defaultPrice = parseFloat($("#default_price").val());
                var minPrice = parseFloat(value);
                return minPrice <= defaultPrice;
            }, 'Minimum Price should be less than or equal to default price');
            jQuery.validator.addMethod("valdiateMaxPrice", function(value, element) {
                var defaultPrice = parseFloat($("#default_price").val());
                var maxPrice = parseFloat(value);
                return maxPrice >= defaultPrice;
            }, 'Maximum Price should be greater than or equal to default price');

            jQuery.validator.addMethod('numericOnly', function(value) {
                return value == "" || /^[0-9]+$/.test(value);
            }, 'Please Enter Only Numeric Values (0-9)');

            jQuery.validator.addMethod('allowDecimal', function(value) {
                return value == "" || /^[0-9\.]+$/.test(value);
            }, 'Please Enter Only Numeric Values (0-9)');

            jQuery.validator.addMethod("strongePassword", function(value) {
                    return value == "" || /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) && /[a-z]/.test(value) && /\d/
                        .test(value) ||
                        /[A-Z]/.test(value);
                },
                "Please enter Alphanumeric"
            );

            $('#myForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    unit_id: {
                        required: true,
                    },
                    category_id: {
                        required: true,
                    },
                    max_price: {
                        required: true,
                        numericOnly: true,
                        valdiateMaxPrice: true,
                    },
                    min_price: {
                        required: true,
                        numericOnly: true,
                        min: 1,
                        valdiateMinPrice: true,
                    },
                    default_price: {
                        required: true,
                        numericOnly: true,
                        min: 1,
                    },
                    total_weight_in_qtl: {
                        required: true,
                        allowDecimal: true,
                        step: 0.01,
                    },
                    gst: {
                        numericOnly: true,
                        min: 1,
                        max: 100,
                    },
                    sku_code: {
                        strongePassword: true,
                    },
                    hsn_no: {
                        numericOnly: true,
                    },
                    units_per_case: {
                        numericOnly: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Please Enter Your Product Name',
                    },
                    unit_id: {
                        required: 'Please Select One Unit',
                    },
                    category_id: {
                        required: 'Please Select One Category',
                    },
                    max_price: {
                        required: 'Please Enter Max Price',
                    },
                    min_price: {
                        required: 'Please Enter Min Price',
                        min: 'Min price Must be Greater than zero',
                    },
                    default_price: {
                        required: 'Please Enter Default Price',
                        min: 'Default price Must be Greater than zero',
                    },
                    total_weight_in_qtl: {
                        required: 'Please Enter Total Weight in QTL',
                        step: 'It must include two decimal places',
                    },
                    gst: {
                        min: 'GST(%) should be Greater Than Or Equal To 1',
                        max: 'GST(%) should be Less Than Or Equal To 100',
                        numericOnly: 'GST(%) should be numeric values (1-100)',
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
                        if ($('#supplier_id').val()) {
                            $('#supplier_id').removeClass('is-invalid');
                        } else {
                            $('#supplier_id').addClass('is-invalid');
                        }
                        if ($('#category_id').val()) {
                            $('#category_id').removeClass('is-invalid');
                        } else {
                            $('#category_id').addClass('is-invalid');
                        }
                        if ($('#unit_id').val()) {
                            $('#unit_id').removeClass('is-invalid');
                        } else {
                            $('#unit_id').addClass('is-invalid');
                        }
                    });
                },

            });
        });
    </script>
@endsection
