<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10">
        <h2 class="text-xl font-bold mb-6 text-center">🗑️ Trashed Employee</h2>

    @if ($marketing->isEmpty())
        <div class="alert alert-warning">No deleted users found.</div>
    @else
        <div class="overflow-x-auto">
            <table id="myTable" class="min-w-full bg-white shadow-md rounded-lg">
                <thead class="bg-gray-200 text-gray-700">
                    <tr class="text-center">
                        <th class="p-3">#</th>
                        
                        <th class="p-3">Name</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Phone</th>
                        <th class="p-3">Address</th>
                        <th class="p-3">Images</th>
                        <th class="p-3">Deleted_at</th>
                        <th class="p-3">Restore</th>
                        <th class="p-3">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @php $cnt = 1; @endphp
                    @foreach ($marketing as $mar)
                        <tr class="text-center border-b hover:bg-gray-100">
                            <td class="p-3">{{ $cnt++ }}</td>
                            <td class="p-3">{{ $mar->name }}</td>
                            <td class="p-3">{{ $mar->email }}</td>
                            <td class="p-3">{{ $mar->phone }}</td>
                            <td class="p-3">{{ $mar->address }}</td>
                            <td class="p-3">
                                <img src="{{ asset('storage/' . $mar->image) }}" width="60" class="mx-auto rounded">
                            </td>
                            <td class="p-3">{{ $mar->deleted_at }}</td>
                            <td>
                    <form action="{{ route('marketings.restore', $mar->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-success btn-sm">Restore</button>
                    </form>
                </td>
                            <td>
                                <form action="{{ route('marketings.forceDeleted', $mar->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Force Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
        <a href="{{ route('marketings.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">← Back</a>
  

    </div>
    @push('scripts')
    {{-- DataTables CDN --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
@endpush
</x-app-layout>
