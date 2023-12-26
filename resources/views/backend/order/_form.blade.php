@php
    $rowIncrement = 0;
@endphp
<form method="post" action="{{ !isset($orderInfo) ? route('order.store') : route('order.update') }}" id="myForm"
    enctype="multipart/form-data">
    @csrf
    @if (isset($orderInfo))
        <input type="hidden" name="ouid" value="{{ base64_encode($orderInfo->id) }}">
    @endif
    <div class="row mt-4 mb-4">
        @if (isset($orderInfo))
            <div class="form-group col-md-2">
                <div class="md-3">
                    <label class="form-label">Order No</label>
                    <span class="form-control">#{{ $orderInfo->order_no }}</span>
                </div>
            </div>
        @endif
        <div class="form-group col-md-3">
            <div class="md-3">
                <label class="form-label">Date <span class="text-danger">*</span></label>
                @if (isset($orderInfo))
                    <span class="form-control">{{ date('d/m/Y', strtotime($orderInfo->date)) }}</span>
                @else
                    <input class="form-control example-date-input" value="{{ $date }}" name="date"
                        type="date" id="date">
                @endif
            </div>
        </div>
        <div class="form-group col-md-4">
            <div class="md-3">
                <label> Customer Name <span class="text-danger">*</span></label>
                @if (isset($orderInfo))
                    <span class="form-control">
                        {{ $customerInfo->name }} @if ($customerInfo->customer_code)
                            - {{ $customerInfo->customer_code }}
                        @endif
                    </span>
                @else
                    <select name="customer_id" id="customer_id" class="form-select select2"
                        onchange="myCustomerFunction()">
                        <option value="">Select Customer </option>
                        @foreach ($customerInfo as $cust)
                            <option value="{{ $cust->id }}">{{ $cust->name }}
                                @if ($cust->customer_code)
                                    -{{ $cust->customer_code }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>
        <div class="form-group col-md-3">
            <div class="md-3">
                <label> Organization Name <span class="text-danger">*</span></label>
                <select name="supplier_id" id="supplier_id" class="form-select select2"
                    aria-label="Default select example">
                    <option selected="" value="">Select Organization</option>
                    @if (isset($orderInfo))
                        @foreach ($supplier as $supp)
                            <option value="{{ $supp->id }}"
                                {{ $supp->id == $orderInfo->supplier_id ? 'selected' : '' }}>
                                {{ $supp->name }}</option>
                        @endforeach
                    @else
                        @foreach ($supplier as $supp)
                            <option value="{{ $supp->id }}">{{ $supp->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div id="customerdetails" style="display: none">
        <table class="table-sm table-bordered mb-3 " width="100%" style="background: #ced4da">
            <thead>
                <tr>
                    <td><strong>S.No</strong> </td>
                    <td><strong>Invoice No</strong> </td>
                    <td><strong>Invoice Date</strong> </td>
                    <td><strong>Outstanding</strong> </td>
                    <td><strong>Payment</strong> </td>
                </tr>
            </thead>
            <tbody id="customer_invoice_rows"></tbody>
        </table>

    </div>
    <table id="validateTable" class="table-sm table-bordered" width="100%" style="border-color: #ddd;">
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
                                <input type="text" name="product_name[]" id="product_name_{{ $rowIncrement }}"
                                    class="form-control productAutocomplete"
                                    value="{{ $opVal['product']->name . ' - Rs.' . $opVal['product']->default_price }}" />
                                <input type="hidden" name="product_id[]" id="product_id_{{ $rowIncrement }}"
                                    class="selling_product_id" value="{{ $opVal->product_id }}" />
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="number" min="1" class="form-control selling_qty text-right"
                                    name="selling_qty[]" id="selling_qty_{{ $rowIncrement }}"
                                    value="{{ $opVal->selling_qty }}">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input type="number" class="form-control unit_price text-right" name="unit_price[]"
                                    id="unit_price_{{ $rowIncrement }}" value="{{ $opVal->unit_price }}"
                                    min="{{ $opVal['product']['min_price'] }}"
                                    max="{{ $opVal['product']['max_price'] }}">
                            </div>
                        </td>

                        <td>
                            <input type="number" class="form-control selling_price text-right" name="selling_price[]"
                                value="{{ $opVal->selling_price }}" readonly>
                        </td>

                        <td>
                            <span class="btn btn-success btn-sm addeventmore"
                                style="{{ $opKey < count($orderInfo->order_details) - 1 ? 'display:none' : '' }}">+</span>
                            <span
                                class="btn btn-danger btn-sm removeeventmore {{ $opKey == 0 ? 'd-none' : '' }}">-</span>
                        </td>

                    </tr>
                    @php
                        $rowIncrement++;
                    @endphp
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
                            <select class="form-select" name="discount_type" id="discount_type">
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
                                <input type="number" name="discount_percentage" id="discount_percentage"
                                    {{ isset($orderInfo) && $orderInfo->payment->discount_type != 'percentage' ? 'style=display:none' : '' }}
                                    class="form-control"
                                    value="{{ isset($orderInfo) ? $orderInfo->payment->discount_percentage : 0 }}"
                                    placeholder="Discount Percentage" min="0" max="100">
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input type="text" name="discount_amount" id="discount_amount"
                            class="form-control estimated_amount" min="0"
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
                            class="form-control estimated_amount" min="0"
                            value="{{ isset($orderInfo) && $orderInfo->payment->shipping_amount ? $orderInfo->payment->shipping_amount : 0 }}"
                            placeholder="Transport Amount">
                    </div>
                </td>
            </tr>


            <tr>
                <td colspan="3"> Grand Total</td>
                <td>
                    <input type="text" name="estimated_amount"
                        value="{{ isset($orderInfo) && $orderInfo->payment->total_amount ? $orderInfo->payment->total_amount : 0 }}"
                        id="estimated_amount" class="form-control estimated_amount" readonly
                        style="background-color: #ddd;">
                </td>
                <td></td>
            </tr>

        </tbody>
    </table><br>


    <div class="form-row">
        <div class="form-group col-md-12">
            <textarea name="description" class="form-control" id="description" placeholder="Write Description Here"></textarea>
        </div>
    </div><br>

    <div class="row">
        {{-- <div class="form-group col-md-3 mb-3">
                <label> Paid Status <span class="text-danger">*</span> </label>
                <select name="paid_status" id="paid_status" class="form-select">
                    <option value="">Select Status </option>
                    @foreach ($paymentStatus as $psKey => $psValue)
                        <option value="{{ $psKey }}" {{(isset($orderInfo) && $psKey==$orderInfo->payment->paid_status)?"selected":""}}>{{ $psValue }}</option>
                    @endforeach
                </select>
            </div> --}}
        <div class="form-group col-md-3 full_paid_dependent partial_paid_dependent">
            <label> Paid Date <span class="text-danger">*</span> </label>

            <input class="form-control example-date-input"
                value="{{ isset($orderInfo) && $orderInfo->paymentDetail->date ? $orderInfo->paymentDetail->date : date('Y-m-d') }}"
                name="payment_date" type="date" id="payment_date">
        </div>
        <div class="form-group col-md-3 partial_paid_dependent">
            <label> Paid Amount <span class="text-danger">*</span> </label>
            <input type="text" name="paid_amount" class="form-control paid_amount"
                value="{{ isset($orderInfo) ? $orderInfo->payment->paid_amount : 0 }}"
                placeholder="Enter Paid Amount">
        </div>
        <div class="form-group col-md-3 full_paid_dependent partial_paid_dependent">
            <label> Mode of payment <span class="text-danger">*</span> </label>
            <select name="payment_mode" id="payment_mode" class="form-select">
                @foreach ($paymentType as $ptKey => $ptValue)
                    <option value="{{ $ptValue }}"
                        {{ isset($orderInfo) && $ptValue == $orderInfo->paymentDetail->payment_mode ? 'selected' : '' }}>
                        {{ $ptValue }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3 full_paid_dependent partial_paid_dependent">
            <label> Paid Person Name <span class="text-danger">*</span> </label>
            <input type="text" name="payment_person_name" class="form-control payment_person_name"
                value="{{ isset($orderInfo) ? $orderInfo->paymentDetail->person_name : '' }}"
                placeholder="Enter Paid Person Name">
        </div>
        <div class="form-group col-md-3 full_paid_dependent partial_paid_dependent">
            <label> Phone Number <span class="text-danger">*</span> </label>
            <input type="text" name="payment_phone_number" class="form-control payment_phone_number"
                value="{{ isset($orderInfo) ? $orderInfo->paymentDetail->phone_number : '' }}"
                placeholder="Enter Phone Number">
        </div>
        <div class="form-group col-md-3 full_paid_dependent partial_paid_dependent">
            <label> City <span class="text-danger">*</span> </label>
            <input type="text" name="payment_city" class="form-control payment_city"
                value="{{ isset($orderInfo) ? $orderInfo->paymentDetail->city : '' }}" placeholder="Enter City">
        </div>
        <div class="form-group col-md-3 full_paid_dependent partial_paid_dependent">
            <label> Proof of payment</label>
            @if (isset($orderInfo) && $orderInfo->paymentDetail->payment_proof)
                <img class="img-fluid img-thumbnail" src="{{ url($orderInfo->paymentDetail->payment_proof) }}" />
            @endif
            <input type="file" class="form-control" name="payment_proof" id="payment_proof" accept="image/*" />
        </div>
    </div> <!-- // end row -->
    <div class="form-group mt-2">
        <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="btn btn-info">Cancel</a>
        @if (isset($orderInfo))
            <button type="submit" name="update" class="btn btn-info orderStore">Update Order</button>
            <button type="submit" name="approve" class="btn btn-info orderStore">Order Approve</button>
        @else
            <button type="submit" class="btn btn-info orderStore">Save Order</button>
        @endif
    </div>
</form>

<script id="document-template" type="text/x-handlebars-template">
     
    <tr class="delete_add_more_item">
     <td>
        <div class="form-group">
            <input type="text" name="product_name[]" id="product_name_@{{rowID}}" class="form-control productAutocomplete"/>
            <input type="hidden" name="product_id[]" id="product_id_@{{rowID}}"class="selling_product_id"/>
        </div>
    </td>

    <td>
        <div class="form-group">
            <input type="number" min="1" class="form-control selling_qty text-right" name="selling_qty[]" id="selling_qty_@{{rowID}}" value=""> 
        </div>    
    </td>
    <td>
        <div class="form-group">
            <input type="number"class="form-control unit_price text-right" name="unit_price[]" id="unit_price_@{{rowID}}" value="@{{ product_default_price }}">
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
        var customers = JSON.parse('<?php echo json_encode($customerInfo); ?>');
        var products = JSON.parse('<?php echo json_encode($products); ?>');
        var rowIncrement = <?php echo $rowIncrement; ?>;
        @if (!isset($orderInfo))
            addMore();
        @endif

        function addMore() {
            rowIncrement = rowIncrement + 1;
            var source = $("#document-template").html();
            var tamplate = Handlebars.compile(source);
            var data = {
                rowID: rowIncrement,
            };
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
                $('#shipping_amount').val(0);
                $('#discountTypeDependent').hide();
            }
            $('#discount_percentage').val(0);
            $("#discount_amount").val(0);
            totalAmountPrice();
        })

        $(document).on('change', '#customer_id', function() {
            var customer_id = $(this).val();
            var customerInfo = customers.find(el => el.id === parseInt(customer_id));
            var discountPercentage = (customerInfo.discount) ? parseInt(customerInfo.discount) : 0;
            $("#discount_percentage").val(discountPercentage);
            totalAmountPrice();
        });

        // Calculate sum of amout in order 

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

    });

    $(".full_paid_dependent").hide();
    $(".partial_paid_dependent").hide();
    if ($('#paid_status').val() != 'full_due') {
        $('.' + $('#paid_status').val() + '_dependent').show();
    }

    $(document).on('change', '#paid_status', function() {
        var paid_status = $(this).val();
        $(".full_paid_dependent").hide();
        $(".partial_paid_dependent").hide();
        if (paid_status != 'full_due') {
            $('.' + paid_status + '_dependent').show();
        }
    });

    function tofindDuplicates(arr) {
        return arr.filter((currentValue, currentIndex) =>
            arr.indexOf(currentValue) !== currentIndex);
    }
    $(document).ready(function() {
        jQuery.validator.addMethod("valdiatePaidAmount", function(value, element) {
            var estimated_amount = parseFloat($("#estimated_amount").val());
            var paidAmount = parseFloat(value);
            return paidAmount <= estimated_amount;
        }, 'Paid Amount should be less than or equal to Grand Total');

        $('#myForm').validate({
            ignore: [],
            rules: {
                date: {
                    required: true,
                },
                customer_id: {
                    required: true,
                },
                supplier_id: {
                    required: true,
                },
                "product_name[]": {
                    required: true,
                },
                "selling_qty[]": {
                    required: true,
                },
                "unit_price[]": {
                    required: true,
                },
                // paid_status: {
                //     required: true,
                // },
                // paid_amount:{
                //     required:true,
                //     valdiatePaidAmount:true,
                // },
                // payment_date:{
                //     required:true,
                // },
                // payment_mode:{
                //     required:true,
                // },
                // payment_proof:{
                //     accept: "image/*"
                // },
                // payment_person_name:{
                //     required:function(){
                //         return $("#paid_status").val()!='full_due'
                //     },
                // },
                // payment_phone_number:{
                //     required:function(){
                //         return $("#paid_status").val()!='full_due'
                //     },
                //     number: true,
                //     pattern:"^[1-9]{1}[0-9]{9}$"
                // },
                // payment_city:{
                //     required:function(){
                //         return $("#paid_status").val()!='full_due'
                //     },
                // },
            },
            messages: {
                date: {
                    required: "Please Select Date"
                },
                customer_id: {
                    required: "Please Select Customer"
                },
                supplier_id: {
                    required: "Please Select Organization"
                },
                "product_name[]": {
                    required: "Please Select Product"
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
                // paid_status: {
                //     required: 'Please Select status',
                // },
                // paid_amount: {
                //     required: 'Please Enter Paid Amount',
                //     valdiatePaidAmount:"Paid Amount should be less than or equal to Grand Total"
                // },
                // payment_date:{
                //     required: "Please Select Paid Date",
                // },
                // payment_mode:{
                //     required: "Please Select Payment Mode",
                // },
                // payment_proof:{
                //     accept: "Proof of payment allow only jpg|jpeg|png|gif"
                // },
                // payment_person_name:{
                //     required:"Please enter Paid Person name",
                // },
                // payment_phone_number:{
                //     required:"Please enter phone number",
                //     number:"Please Enter Valid Phone number",
                //     pattren:"Please Enter Valid Phone number",
                // },
                // payment_city:{
                //     required:"pelase enter city",
                // },
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
            submitHandler: function(form) {
                var selectProduct = new Array();
                $('select[name="product_id[]"]').each(function() {
                    selectProduct.push($(this).val());
                });

                var duplicateElements = tofindDuplicates(selectProduct);

                if (duplicateElements.length) {
                    alert("Hello");
                    $.notify("Selected duplicate products", {
                        globalPosition: 'bottom right',
                        className: 'error'
                    });
                    return false;
                }
                form.submit();
            }
        });
    });

    function myCustomerFunction() {
        customer_id = $("#customer_id").val();
        $.ajax({
            url: "{{ url('api/invoicesList') }}",
            type: "POST",
            data: {
                customer_id: customer_id,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            beforeSend: function() {
                document.getElementById('customerdetails').style.display = 'none';
                $("#customer_invoice_rows").html(
                    "<tr><td colspan='4' align='middle'>Loading...</td></tr>"
                );
            },
            success: function(result) {
                var rows = "";
                if (result.invoices) {
                    var i = 0;
                    var payment = 0;
                    $.each(result.invoices, function(key, item) {
                        var date = item.dtInvoiceDate;
                        var newdate = date.split("-").reverse().join("-");
                        var invoce_no = item.vcInvoiceNo;
                        var outstanding = parseFloat(item.dRemaining_amount);
                        if (item.dAdjusted_amount != null) {
                            payment = parseFloat(item.dAdjusted_amount);
                        } else {
                            payment = 0;
                        }
                        if (invoce_no != '') {
                            rows += "<tr>";
                            rows += "<td>" + ++i + "</td>";
                            rows += "<td>" + invoce_no + "</td>";
                            rows += "<td>" + newdate + "</td>";
                            rows += "<td>" + outstanding + "</td>";
                            rows += "<td>" + payment + "</td>";
                            rows += "</tr>";
                        }
                    });
                }

                $("#customer_invoice_rows").html(rows);
                if (rows != '') {
                    document.getElementById('customerdetails').style.display = 'block';
                }
            }
        });
    }
</script>
