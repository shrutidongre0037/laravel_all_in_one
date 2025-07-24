<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10">
        <h2 class="text-xl font-bold mb-6 text-center">🗑️ Trashed Employee</h2>

        <div class="overflow-x-auto">
            <table id="trashedTable" class="table-auto w-full bg-white shadow-md rounded-lg text-sm">
                <thead class="bg-gray-200 text-gray-700">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Image</th>
                        <th>Deleted At</th>
                        <th>Restore</th>
                        <th>Delete</th>
                    </tr>
                </thead>
            </table>
        </div>

        <a href="{{ route('marketings.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded mt-4 inline-block">← Back</a>
    </div>

    @push('scripts')
    {{-- DataTables and jQuery --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#trashedTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('marketing.trashed.data') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false  },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'address', name: 'address' },
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                    { data: 'deleted_at', name: 'deleted_at' },
                    { data: 'restore', name: 'restore', orderable: false, searchable: false },
                    { data: 'delete', name: 'delete', orderable: false, searchable: false },
                ]
            });
        });
    </script>
    @endpush
</x-app-layout>
