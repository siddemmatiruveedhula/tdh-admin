
@if (count($customers) > 0)
<table id="table_modal" class="table" width="100%">
    <thead>
        <tr>
            <th scope="col">Si.No</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>

        </tr>
    </thead>
    <tbody>
            @foreach ($customers as $index => $customer)
                <tr>
                        <td>{{ ++$index }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                </tr>
            @endforeach
      
    </tbody>
</table>
@else
<p text-align="center">Data not available</p>
@endif


