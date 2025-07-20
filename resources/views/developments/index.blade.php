<x-app-layout>
    @vite(['resources/css/app.css', 'resources/css/style.css']) 
    <div class="max-w-6xl mx-auto mt-10">
        @auth
        @if(Auth::user()->role !== 'development')
            <h1 class="text-xl font-bold mb-6 text-center">Development Department List</h1>
        @endif
        @endauth

        <div class="text-left mb-4">
            <a href="{{ route('developments.create') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Add Employees</a>
            <a class="px-4 py-2 bg-blue-500 text-white rounded" href="{{ route('developments.index',['deleted' => 1]) }}">Restore</a>

        </div>

        <div class="">
            <table id="myTable" class="display table-auto w-full bg-white shadow-md rounded-lg text-sm">
                <thead class="bg-gray-200 text-gray-700">
                    <tr class="text-center">
                        <th class="p-3">#</th>
        
                        <th class="p-3">Name</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Phone</th>
                        <th class="p-3">Address</th>
                        <th class="p-3">Images</th>
                        <th class="p-3">Department</th>
                        <th class="p-3">Projects</th>
                        <th class="p-3">Edit</th>
                        <th class="p-3">Delete</th>
                        <th class="p-3">View</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    @push('scripts')
<!-- jQuery + DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('developments.data') }}",
            "columnDefs": [
        { "width": "150px", "targets": 0 }, // Name
        { "width": "200px", "targets": 1 }, // Email
        { "width": "120px", "targets": 2 }, // Phone
        { "width": "200px", "targets": 3 }, // Address
        { "width": "100px", "targets": 4 }, // Image
        { "width": "150px", "targets": 5 }, // Department
        { "width": "100px", "targets": 6 }, // Projects
        { "width": "80px",  "targets": 7 }, // Edit
        { "width": "80px",  "targets": 8 }, // Delete
        { "width": "80px",  "targets": 9 }, // View
    ],
    "autoWidth": false,
            columns: [
                 { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name' },
                { data: 'email' },
                { data: 'phone' },
                { data: 'address' },
                { data: 'image', orderable: false, searchable: false },
                { data: 'department', name: 'department' },
                { data: 'projects', name: 'projects', orderable: false, searchable: false },
                { data: 'edit', orderable: false, searchable: false },
                { data: 'delete', orderable: false, searchable: false },
                { data: 'view', orderable: false, searchable: false },
            ]
        });
    });



</script>
@endpush
</x-app-layout>
