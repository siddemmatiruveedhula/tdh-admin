@if ($order_invoice_data == 'invoice')
    <table id="table_modal" class="table" width="100%">
        <thead>
            <tr>
                <th>Sl No</th>
                <th>Product Name</th>
                <th>Invoice No</th>
                <th>Customer</th>
                <th>Order By</th>
                <th>QTL</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>
                        <h6 class="mb-0">{{ $loop->index + 1 }}</h6>
                    </td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->vcInvoiceNo }}</td>
                    <td>{{ $product->customer_name }}</td>
                    <td>{{ $product->emp_name }}</td>
                    <td>{{ $product->selling_qtl }}</td>
                    <td>{{ $product->selling_price }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
@else
    <table id="table_modal" class="table" width="100%">
        <thead>
            <tr>
                <th>Sl No</th>
                <th>Product Name</th>
                <th>Order No</th>
                <th>Customer</th>
                <th>Order By</th>
                <th>QTL</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>
                        <h6 class="mb-0">{{ $loop->index + 1 }}</h6>
                    </td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->order_no }}</td>
                    <td>{{ $product->customer_name }}</td>
                    <td>{{ $product->emp_name }}</td>
                    <td>{{ $product->selling_qtl }}</td>
                    <td>{{ $product->selling_price }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endif