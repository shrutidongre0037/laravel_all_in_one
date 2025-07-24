<x-app-layout>
<div class="max-w-6xl mx-auto mt-10">
    <h1 class="text-xl font-bold mb-6 text-center">Project Department List</h1>
</div>

    <div class="container mx-auto py-10">    

             <div class="text-left mb-4">
            <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Add Project</a>
            <a class="px-4 py-2 bg-blue-500 text-white rounded" href="{{ route('projects.index',['deleted' => 1]) }}">Restore</a>

        </div>

            
        <table id="table" class="display table-auto w-full bg-white shadow-md rounded-lg text-sm">
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
                ajax: "{{ route('projects.data') }}",
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
