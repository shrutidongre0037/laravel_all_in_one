<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10">
        <h2 class="text-xl font-bold mb-6 text-center">🗑️ Trashed Employee</h2>

        <div class="overflow-x-auto">
            <table id="trashedTable" class="table-auto w-full bg-white shadow-md rounded-lg text-sm">
                <thead class="bg-gray-200 text-gray-700 text-center">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Deleted At</th>
                        <th>Restore</th>
                        <th>Delete</th>
                    </tr>
                </thead>
            </table>
        </div>

        <a href="{{ route('departments.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded mt-4 inline-block">← Back</a>
    </div>

    @push('scripts')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

        <script>
            $(function () {
                $('#trashedTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('departments.trashed.data') }}',
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false }, // <--- fix here
                        { data: 'name', name: 'name' },
                        { data: 'deleted_at', name: 'deleted_at' },
                        { data: 'restore', name: 'restore', orderable: false, searchable: false },
                        { data: 'forceDelete', name: 'forceDelete', orderable: false, searchable: false }
                    ]

                });
            });
        </script>
    @endpush
</x-app-layout>
