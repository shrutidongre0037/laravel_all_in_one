<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10">
         @auth
        @if(Auth::user()->role !== 'marketing')
            <h2 class="text-xl font-bold mb-6 text-center">Marketing Department List</h2>
        @endif
        @endauth

        <div class="text-left mb-4">
            <a href="{{ route('marketings.create') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Add Employees</a>
            <a class="px-4 py-2 bg-blue-500 text-white rounded" href="{{ route('marketings.index',['deleted' => 1]) }}">Restore</a>

        </div>

        <div class="overflow-x-auto">
            <table id="myTable" class="table-auto w-full bg-white shadow-md rounded-lg text-sm">
                <thead class="bg-gray-200 text-gray-700">
                    <tr class="text-center">
                        <th class="p-3">#</th>
                        
                        <th class="p-3">Name</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Phone</th>
                        <th class="p-3">Address</th>
                        <th class="p-3">Images</th>
                        <th class="p-3">Edit</th>
                        <th class="p-3">Delete</th>
                        <th class="p-3">View</th>
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
                            <td class="p-3">
                                <a class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600"
                                   href="{{ route('marketings.edit', $mar->id) }}">Edit</a>
                            </td>
                            <td class="p-3">
                                <form method="POST" action="{{ route('marketings.destroy', $mar->id) }}"
                                      onsubmit="return confirm('Delete this employee?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                        Delete
                                    </button>
                                </form>
                            </td>
                            <th>
                                <a href="{{ route('marketings.show', $mar->id) }}"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                        View
                                </a>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
