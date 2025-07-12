<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10">
        <h2 class="text-xl font-bold mb-6 text-center">🗑️ Trashed Project</h2>

    @if ($project->isEmpty())
        <div class="alert alert-warning">No deleted users found.</div>
    @else
        <div class="overflow-x-auto">
            <table id="myTable" class="w-full bg-white shadow-md rounded-lg">
                <thead class="bg-gray-200 text-gray-700">
                    <tr class="text-center">
                        <th class="p-3">#</th>
                        
                        <th class="p-3">Title</th>
                        <th class="p-3">Descritpion</th>
                        <th class="p-3">start_date</th>
                        <th class="p-3">end_date</th>
                        <th class="p-3">Deleted_at</th>
                        <th class="p-3">Restore</th>
                        <th class="p-3">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @php $cnt = 1; @endphp
                    @foreach ($project as $pro)
                        <tr class="text-center border-b hover:bg-gray-100">
                            <td class="p-3">{{ $cnt++ }}</td>
                            <td class="p-3">{{ $pro->title }}</td>
                            <td class="p-3">{{ $pro->description }}</td>
                            <td class="p-3">{{ $pro->start_date }}</td>
                            <td class="p-3">{{ $pro->end_date }}</td>
                            <td class="p-3">{{ $pro->deleted_at }}</td>
                            <td>
                    <form action="{{ route('projects.restore', $pro->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-success btn-sm">Restore</button>
                    </form>
                </td>
                            <td>
                                <form action="{{ route('projects.forceDeleted', $pro->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">ForceDelete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
        <a href="{{ route('projects.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">← Back</a>
  

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

