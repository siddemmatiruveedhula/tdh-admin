<table id="table_modal" class="table" width="100%">
    <thead>
        <tr>
            <th>Sl No</th>
            <th>Order No </th>
            <th>Order Date</th>
            <th>Customer</th>
            {{-- <th>Order No</th> --}}
            <th>Order By</th>
            <th>QTL</th>
            <th>Amount</th>
            {{-- <th>Paid</th>
            <th>Due</th>
            <th>Payment Status</th> --}}
            <th>Status</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($transactionsList as $index => $transaction)
            <tr>
                <td>
                    <h6 class="mb-0">{{ $loop->index + 1 }}</h6>
                </td>
                <td><a href="#">{{ $transaction->order_no }}</a></td>
                <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d-m-Y') }}</td>
                <td>{{ $transaction->customer_name }}</td>
                {{-- <td>32564</td> --}}
                <td>{{ $transaction->emp_name }}</td>
                <td>{{ $transaction->qtl }}</td>
                <td>{{ $transaction->price }}</td>
                {{-- <td>{{ $transaction->paid_amount ? $transaction->paid_amount : '' }}</td>
                <td>{{ $transaction->due_amount ? $transaction->due_amount : '' }}</td>
                <td>{{ $transaction->paid_status }}</td> --}}
                <td>
                    {{-- <span class="badge bg-success">Ordered</span> --}}
                    {{ $transaction->order_status ? 'Approved' : 'Pending' }}
                </td>
            </tr>
        @endforeach

    </tbody>
</table>
