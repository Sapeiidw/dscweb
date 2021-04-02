<a href="{{ route('user.create') }}">Add User</a>
<table>
    <thead>
        <th>No</th>
        <th>Name</th>
        <th>Email</th>
        <th>Status</th>
        <th>Action</th>
    </thead>
    <tbody>
        @forelse ($users as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->email }}</td>
            <td>
                @if ($item->email_verified_at)
                    {{ "verified" }}
                @else
                    {{ "not verified" }}
                @endif
            </td>
            <td>
                <a href="{{ route('user.edit',$item->id) }}" class="">Edit</a>
                <form action="{{ route('user.destroy',$item->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button onclick="return confirm('Are u Suer??')" type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @empty
            <tr>
                Data kosong boss
            </tr>
        @endforelse
    </tbody>
</table>