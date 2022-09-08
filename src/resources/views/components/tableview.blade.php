<table class="table bg-white w-100">
    @if($people->count())
    <tr class="py-3"><td colspan="6" class="float-right px-4">{{ $people->links() }}</td></tr>
    @endif
    <tr>
        <th class="ps-4">Email</th>
        <th>ID</th>
        <th>Tags</th>
        <th>Full name</th>
        <th>Location</th>
        <th class="pe-4">IP</th>
    </tr>
    @if($people->count())
    @foreach($people as $key => $p)
        <tr>
            <td class="ps-4"><input type="checkbox" name="people[]" class="me-3 checkbox"> {{ $p->email }}</td>
            <td>{{ $p->id }}</td>
            <td><span class="badge badge-custom rounded">Customers</span></td>
            <td>{{ $p->name }}</td>
            <td>{{ $p->country }}</td>
            <td class="pe-4">{{ $p->ip }}</td>
        </tr>
    @endforeach
    <tr class="py-4"><td colspan="6" class="px-4">{{ $people->links() }}</td></tr>
    @else 
        <tr><td colspan="6" class="px-4">No records found</td></tr>
    @endif
</table>