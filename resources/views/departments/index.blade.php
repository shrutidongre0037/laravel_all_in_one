<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10">
        <h2 class="text-xl font-bold mb-6 text-center">Department List</h2>

        <div class="text-left mb-4">
            <a href="{{ route('departments.create') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Add Department</a>
        </div>

        <div class="overflow-x-auto">
            <table id="myTable" class="min-w-full bg-white shadow-md rounded-lg">
                <thead class="bg-gray-200 text-gray-700">
                    <tr class="text-center">
                        <th class="p-3">#</th>
                        <th class="p-3">Name</th>
                        <th class="p-3">Edit</th>
                        <th class="p-3">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @php $cnt = 1; @endphp
                    @foreach ($departments as $dept)
                        <tr class="text-center border-b hover:bg-gray-100">
                            <td class="p-3">{{ $cnt++ }}</td>
                            <td class="p-3">{{ $dept->name }}</td>
                            <td class="p-3">
                                <a class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600"
                                   href="{{ route('departments.edit', $dept->id) }}">Edit</a>
                            </td>
                            <td class="p-3">
                                <form method="POST" action="{{ route('departments.destroy', $dept->id) }}"
                                      onsubmit="return confirm('Delete this department?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                        Delete
                                    </button>
                                </form>
                            </td>
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
