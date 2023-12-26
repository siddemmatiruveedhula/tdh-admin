
@if (count($customers) > 0)
<table id="table_modal" class="table" width="100%">
    <thead>
        <tr>
            <th scope="col">Si.No</th>
            <th scope="col">Name</th>
            <th scope="col">City</th>
            <th scope="col">Type</th>
            {{-- <th>Action</th> --}}

        </tr>
    </thead>
    <tbody>
            @foreach ($customers as $index => $customer)
                <tr>
                        <td>{{ ++$index }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->city->name ?? '' }}</td>
                        <td>{{ $customer->role->name }}</td>
                        {{-- <td><a href="#" class="btn btn-danger sm" title="Delete Data" id="delete"> <i class="fas fa-trash-alt" aria-hidden="true"></i> </a></td> --}}
                </tr>
            @endforeach
      
    </tbody>
</table>
@else
<p text-align="center">Data not available</p>
@endif


