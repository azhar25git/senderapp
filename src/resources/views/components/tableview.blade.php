<table class="bg-white w-100">
    @if($people->count())
    <tr class="py-3"><td colspan="6" class="float-right">{{ $people->links() }}</td></tr>
    @endif
    <tr>
        <th>Email</th>
        <th>ID</th>
        <th>Tags</th>
        <th>Full name</th>
        <th>Location</th>
        <th>IP</th>
    </tr>
    @if($people->count())
    @foreach($people as $key => $p)
        <tr>
            <td><input type="checkbox" name="people[]" class="me-3"> {{ $p->email }}</td>
            <td>{{ $p->id }}</td>
            <td><span class="bg-grey rounded">Customers</span></td>
            <td>{{ $p->name }}</td>
            <td>{{ $p->country }}</td>
            <td>{{ $p->ip }}</td>
        </tr>
    @endforeach
    <tr class="py-3"><td colspan="6">{{ $people->links() }}</td></tr>
    @else 
        <tr><td colspan="6">No records found</td></tr>
    @endif
</table>