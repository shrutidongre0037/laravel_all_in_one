<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10">
        <h2 class="text-xl font-bold mb-6 text-center">🗑️ Trashed Project</h2>

        <div class="overflow-x-auto mb-3">
            <table id="trashedProjectTable" class="table-auto w-full bg-white shadow-md rounded-lg text-sm">
                <thead class="bg-gray-200 text-gray-700">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Deleted At</th>
                        <th>Restore</th>
                        <th>Force Delete</th>
                    </tr>
                </thead>
            </table>
        </div>

        <a href="{{ route('projects.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">← Back</a>
    </div>

    @push('scripts')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

        <script>
            $(function () {
                $('#trashedProjectTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('projects.trashed.data') }}",
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'title', name: 'title' },
                        { data: 'description', name: 'description' },
                        { data: 'start_date', name: 'start_date' },
                        { data: 'end_date', name: 'end_date' },
                        { data: 'deleted_at', name: 'deleted_at' },
                        { data: 'restore', name: 'restore', orderable: false, searchable: false },
                        { data: 'delete', name: 'delete', orderable: false, searchable: false },
                    ]
                });
            });
        </script>
    @endpush
</x-app-layout>
