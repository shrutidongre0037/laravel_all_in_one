<x-app-layout>
    <div class="container mx-auto py-10">
        <a href="{{ route('projects.create') }}" class="btn btn-primary mb-3">Add Project</a>
            <a class="px-4 py-2 bg-blue-500 text-white rounded ml-5 mb-5" href="{{ route('projects.index',['deleted' => 1]) }}">Restore</a>


        <table id="table" class="display min-w-full bg-white shadow-md rounded-lg">
                <thead class="bg-gray-200 text-gray-700">
                    <tr class="text-center">
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th class="sorting">Edit</th>
                    <th class="sorting">Delete</th>
                    <th class="sorting">View</th>

                </tr>
            </thead>
        </table>
    </div>

    @push('scripts')
    <script>
        $(function () {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('projects.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    { data: 'title', name: 'title' },
                    { data: 'description', name: 'description' },
                    { data: 'start_date', name: 'start_date' },
                    { data: 'end_date', name: 'end_date' },
                    { data: 'edit' },
                    { data: 'delete' },
                    { data: 'view'},
                ]
            });
        });
    </script>
    @endpush
</x-app-layout>
