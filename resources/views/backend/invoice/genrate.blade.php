@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">
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
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">
                            Genrate Invoice
                        </h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="invoiceGenrateForm" method="post" action="{{ route('invoice.genrate-store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="ouid" value="{{ base64_encode($orderInfo->id) }}">
                                <div class="row mt-4 mb-4">
                                    <div class="form-group col-md-2">
                                        <div class="md-3">
                                            <label class="form-label">Order No</label>
                                            <span class="form-control">#{{ $orderInfo->order_no }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="md-3">
                                            <label class="form-label"> Order Date <span class="text-danger">*</span></label>
                                            <span class="form-control">{{ date('d/m/Y', strtotime($orderInfo->date)) }}
                                                <input value="{{ date('d-m-Y', strtotime($orderInfo->date)) }}"
                                                    name="date" type="hidden" id="order_date"></span>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="md-3">
                                            <label> Customer Name <span class="text-danger">*</span></label>
                                            <span class="form-control">
                                                {{ $customerInfo->name }} - {{ $customerInfo->customer_code }}
                                                <input type="hidden" name="customer_id" value="{{ $customerInfo->id }}" />
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="md-3">
                                            <label> Organization Name <span class="text-danger">*</span></label>
                                            <select name="supplier_id" id="supplier_id" class="form-select select2"
                                                aria-label="Default select example">
                                                <option selected="" value="">Select Organization</option>
                                                @foreach ($supplier as $supp)
                                                    <option value="{{ $supp->id }}"
                                                        {{ $supp->id == $orderInfo->supplier_id ? 'selected' : '' }}>
                                                        {{ $supp->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4 mb-4">
                                    <div class="form-group col-md-3">
                                        <div class="md-3">
                                            <label class="form-label">Invoice Date <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control datepicker" value="{{ date('d-m-Y') }}"
                                                name="invoice_date" type="text" id="invoice_date">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="md-3">
                                            <label class="form-label">Invoice Number <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="invoice_no" id="invoice_no">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="md-3">
                                            <label class="form-label">Invoice Amount <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="invoice_amount"
                                                id="invoice_amount" min="0">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label> Invoice Document <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" name="invoice_document"
                                            id="invoice_document" accept="application/pdf" />
                                    </div>

                                </div>
                                <table id="validateTable" class="table-sm table-bordered" width="100%"
                                    style="border-color: #ddd;">
                                    <thead>
                                        <tr>
                                            <th width="">Product Name </th>
                                            <th width="15%">QTY</th>
                                            <th width="15%">Unit Price </th>
                                            <th width="15%">Total Price</th>
                                            <th width="15%">Action</th>

                                        </tr>
                                    </thead>

                                    <tbody id="addRow" class="addRow">
                                        @if (isset($orderInfo))
                                            @foreach ($orderInfo->order_details as $opKey => $opVal)
                                                <tr class="delete_add_more_item">
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control productAutocomplete"
                                                                value="{{ $opVal['product']->name . ' - Rs.' . $opVal['product']->default_price }}" />
                                                            <input type="hidden" name="product_id[]"
                                                                class="selling_product_id"
                                                                value="{{ $opVal->product_id }}" />
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="form-group">
                                                            <input type="number" min="1"
                                                                class="form-control selling_qty text-right"
                                                                name="selling_qty[]" value="{{ $opVal->selling_qty }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <input type="number"
                                                                class="form-control unit_price text-right"
                                                                name="unit_price[]" value="{{ $opVal->unit_price }}"
                                                                min="{{ $opVal['product']['min_price'] }}"
                                                                max="{{ $opVal['product']['max_price'] }}">
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <input type="number"
                                                            class="form-control selling_price text-right"
                                                            name="selling_price[]" value="{{ $opVal->selling_price }}"
                                                            readonly>
                                                    </td>

                                                    <td>
                                                        <span class="btn btn-success btn-sm addeventmore"
                                                            style="{{ $opKey < count($orderInfo->order_details) - 1 ? 'display:none' : '' }}">+</span>
                                                        <span
                                                            class="btn btn-danger btn-sm removeeventmore {{ $opKey == 0 ? 'd-none' : '' }}">-</span>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>

                                    <tbody>
                                        <tr>
                                            <td colspan="3">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        Discount
                                                    </div>
                                                    <div class="col-md-3">
                                                        <select class="form-select" name="discount_type"
                                                            id="discount_type">
                                                            <option value="percentage"
                                                                {{ isset($orderInfo) && $orderInfo->payment->discount_type == 'percentage' ? 'selected' : '' }}>
                                                                Percentage (%)</option>
                                                            <option value="cash"
                                                                {{ isset($orderInfo) && $orderInfo->payment->discount_type == 'cash' ? 'selected' : '' }}>
                                                                Cash (₹)</option>
                                                            <option value="transport"
                                                                {{ isset($orderInfo) && $orderInfo->payment->discount_type == 'transport' ? 'selected' : '' }}>
                                                                Transport (₹)</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <input type="number" name="discount_percentage"
                                                                id="discount_percentage"
                                                                {{ isset($orderInfo) && $orderInfo->payment->discount_type != 'percentage' ? 'style=display:none' : '' }}
                                                                class="form-control"
                                                                value="{{ isset($orderInfo) ? $orderInfo->payment->discount_percentage : 0 }}"
                                                                placeholder="Discount Percentage" min="0"
                                                                max="100">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="text" name="discount_amount" id="discount_amount"
                                                        class="form-control"
                                                        value="{{ isset($orderInfo) && $orderInfo->payment->discount_amount ? $orderInfo->payment->discount_amount : 0 }}"
                                                        placeholder="Discount Amount">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr id="discountTypeDependent">
                                            <td colspan="3"> Transport</td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="text" name="shipping_amount" id="shipping_amount"
                                                        class="form-control"
                                                        value="{{ isset($orderInfo) && $orderInfo->payment->shipping_amount ? $orderInfo->payment->shipping_amount : 0 }}"
                                                        placeholder="Transport Amount">
                                                </div>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td colspan="3"> Grand Total</td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="text" name="estimated_amount"
                                                        value="{{ isset($orderInfo) && $orderInfo->payment->total_amount ? $orderInfo->payment->total_amount : 0 }}"
                                                        id="estimated_amount" class="form-control estimated_amount"
                                                        readonly style="background-color: #ddd;">
                                                </div>
                                            </td>
                                            <td></td>
                                        </tr>

                                    </tbody>
                                </table>
                                <div class="form-row mt-2">
                                    <div class="form-group col-md-12">
                                        <textarea name="description" class="form-control" id="description" placeholder="Write Description Here"></textarea>
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                                    <a href="{{ redirect()->getUrlGenerator()->previous() }}"
                                        class="btn btn-info">Cancel</a>
                                    <button type="submit" class="btn btn-info orderStore">Genrate Invoice</button>
                                </div>

                            </form>
                        </div> <!-- End card-body -->
                    </div>
                </div> <!-- end col -->
            </div>
        </div>
    </div>
@endsection
@section('js-scripts')
    <script id="more-product-template" type="text/x-handlebars-template">
    <tr class="delete_add_more_item">
        <td>
            <div class="form-group">
                <input type="text" class="form-control productAutocomplete"/>
                <input type="hidden" name="product_id[]" class="selling_product_id"/>
            </div>
        </td>

        <td>
            <div class="form-group">
                <input type="number" min="1" class="form-control selling_qty text-right" name="selling_qty[]" value=""> 
            </div>    
        </td>
        <td>
            <div class="form-group">
                <input type="number"class="form-control unit_price text-right" name="unit_price[]" value="@{{ product_default_price }}">
            </div>        
        </td>

        <td>
            <input type="number" class="form-control selling_price text-right" name="selling_price[]" value="0" readonly> 
        </td>

        <td>
            <span class="btn btn-success btn-sm addeventmore">+</span>
            <span class="btn btn-danger btn-sm removeeventmore">-</span>
        </td>
    </tr>
 </script>

    <script type="text/javascript">
        $(document).ready(function() {
            totalAmountPrice();
            var products = JSON.parse('<?php echo json_encode($products); ?>');

            function addMore() {
                var source = $("#more-product-template").html();
                var tamplate = Handlebars.compile(source);
                var data = {};
                var html = tamplate(data);
                $("#addRow").append(html);
                if ($(".addeventmore").length == 1) {
                    $(".removeeventmore").hide();
                }
            }
            $(document).on("click", ".addeventmore", function() {
                if (!$(".selling_product_id:last").val()) {
                    $.notify("Please Select Product", {
                        globalPosition: 'bottom right',
                        className: 'error'
                    });
                    return false;
                }

                if (!$(".selling_qty:last").val()) {
                    $.notify("Please Enter QTY", {
                        globalPosition: 'bottom right',
                        className: 'error'
                    });
                    return false;
                }

                if (!$(".unit_price:last").val()) {
                    $.notify("Please Enter Unit Price", {
                        globalPosition: 'bottom right',
                        className: 'error'
                    });
                    return false;
                } else {
                    var selUnitPrice = parseInt($(".unit_price:last").val());
                    var selProduct = $(".selling_product_id:last").val();
                    var selProductInfo = products.find(el => el.id === parseInt(selProduct));
                    if (selUnitPrice < selProductInfo.min_price || selUnitPrice > selProductInfo
                        .max_price) {
                        $.notify("Unit Price Should be in between " + selProductInfo.min_price + " and " +
                            selProductInfo.max_price, {
                                globalPosition: 'bottom right',
                                className: 'error'
                            });
                        return false;
                    }
                }
                $(".addeventmore").hide();
                addMore();
            });

            $(document).on("click", ".removeeventmore", function(event) {

                $(this).closest(".delete_add_more_item").remove();
                //console.log($(".addeventmore:nth-child("+($(".addeventmore").length-1)+")"));
                $(".addeventmore:last").show();
                totalAmountPrice();
                // checkVal();
            });

            $(document).on('focus', '.productAutocomplete', function() {
                var selThis = $(this);
                selThis.autocomplete({
                    source: function(request, response) {
                        var searchTerm = request.term;
                        var selectProduct = new Array();
                        $('input[name="product_id[]"]').each(function() {
                            if ($(this).val()) {
                                selectProduct.push(parseInt($(this).val()));
                            }
                        });
                        var datamap = products.map(function(productInfo) {
                            if (!selectProduct.includes(productInfo.id)) {
                                return {
                                    label: productInfo.name + ' - Rs.' + productInfo
                                        .default_price,
                                    value: productInfo.name + ' - Rs.' + productInfo
                                        .default_price,
                                    avalue: productInfo.id,
                                    defaultPrice: productInfo.default_price,
                                    category_id: productInfo.category_id,
                                    total_weights: productInfo.total_weight_in_qtl,
                                    minPrice: productInfo.min_price,
                                    maxPrice: productInfo.max_price,
                                }
                            }
                        });
                        datamap = datamap.filter(function(product) {
                            if (product)
                                return product.label.toLowerCase().indexOf(searchTerm
                                    .toLowerCase()) >= 0;
                        });
                        response(datamap);
                    },
                    select: function(event, selProductInfo) {
                        selThis.closest('tr.delete_add_more_item').find(".selling_product_id")
                            .val(selProductInfo.item.avalue);
                        selThis.closest('tr.delete_add_more_item').find(".selling_qty").val("")
                            .trigger('change');
                        selThis.closest('tr.delete_add_more_item').find("input.unit_price").val(
                            selProductInfo.item.defaultPrice).attr('min', selProductInfo
                            .item.minPrice).attr('max', selProductInfo.item.maxPrice);
                    }
                });
            })
            $(document).on('keyup click change', '.unit_price,.selling_qty', function() {
                var unit_price = $(this).closest("tr").find("input.unit_price").val();
                var qty = ($(this).closest("tr").find("input.selling_qty").val()) ? $(this).closest("tr")
                    .find("input.selling_qty").val() : 0;
                var total = unit_price * qty;

                $(this).closest("tr").find("input.selling_price").val(total);
                $('#discount_amount').trigger('keyup');

            });

            $(document).on('keyup', '#discount_amount', function() {
                totalAmountPrice();
            });

            //shipping or Transportation amount 
            $(document).on('keyup', '#shipping_amount', function() {
                totalAmountPrice();
            })

            $(document).on('keyup change', '#discount_percentage', function() {
                totalAmountPrice();
            })

            $(document).on('change', '#discount_type', function() {
                $('#discount_percentage').show();
                $('#discountTypeDependent').show();
                var discountType = $("#discount_type").val();
                if (discountType != 'percentage') {
                    $('#discount_percentage').hide();
                }
                if (discountType == 'transport') {
                    $('#discountTypeDependent').hide();
                }
                $('#discount_percentage').val(0);
                $("#discount_amount").val(0);
                totalAmountPrice();
            })

            function totalAmountPrice() {
                var sum = 0;
                $(".selling_price").each(function() {
                    var value = $(this).val();
                    if (!isNaN(value) && value.length != 0) {
                        sum += parseFloat(value);
                    }
                });

                //Discount
                var discountType = $("#discount_type").val();
                if (discountType == 'percentage') {
                    var discountPercentageValue = parseFloat($('#discount_percentage').val());
                    var discountPercentageAmount = (sum * discountPercentageValue) / 100;
                    $('#discount_amount').val(discountPercentageAmount);
                }

                var discount_amount = parseFloat($('#discount_amount').val());
                if (!isNaN(discount_amount) && discount_amount.length != 0) {
                    sum -= parseFloat(discount_amount);
                }

                //Shipping or Transportation amount addition to product total amount
                var shipping_amount = parseFloat($('#shipping_amount').val());
                if (!isNaN(shipping_amount) && shipping_amount.length != 0) {
                    sum += parseFloat(shipping_amount);
                }

                $('#estimated_amount').val(sum);
            }

            $('#invoiceGenrateForm').validate({
                ignore: [],
                rules: {
                    invoice_date: {
                        required: true,
                    },
                    supplier_id: {
                        required: true,
                    },
                    invoice_no: {
                        required: true,
                        remote: {
                            url: "{{ route('invoice.duplicate-check') }}",
                            type: 'get',
                            async: false,
                        }
                    },
                    invoice_amount: {
                        required: true,
                        number: true,
                        equalTo: "#estimated_amount"
                    },
                    "product_id[]": {
                        required: true,
                    },
                    "selling_qty[]": {
                        required: true,
                    },
                    "unit_price[]": {
                        required: true,
                    },
                    discount_amount: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    shipping_amount: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    invoice_document: {
                        required: true,
                        extension: "pdf"
                    },
                    estimated_amount: {
                        required: true,
                        number: true,
                        equalTo: "#invoice_amount"
                    }
                },
                messages: {
                    invoice_date: {
                        required: " Invoice Date Required"
                    },
                    supplier_id: {
                        required: "Please Select Organization"
                    },
                    invoice_no: {
                        required: " Invoice Number Required",
                        remote: "Invoice number already exists"
                    },
                    invoice_amount: {
                        required: " Invoice Amount Required",
                        equalTo: "Invoice Amount and Grand Total should be same"
                    },
                    "product_id[]": {
                        required: "Please Select Product"
                    },
                    "selling_qty[]": {
                        required: "Please Enter QTY"
                    },
                    "unit_price[]": {
                        required: "Please Enter Unit Price"
                    },
                    discount_amount: {
                        required: "Discount Amount Required",
                    },
                    shipping_amount: {
                        required: "Shipping Amount Required"
                    },
                    invoice_document: {
                        required: "Invoice Document Required",
                        extension: "Invoice Document Only allow PDF"
                    },
                    estimated_amount: {
                        required: "Grand Total Required",
                        equalTo: "Grand Total and Invoice Amount should be same"
                    }
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
