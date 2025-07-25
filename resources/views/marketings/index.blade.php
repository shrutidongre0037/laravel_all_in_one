<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10">
         @auth
        @if(Auth::user()->role !== 'marketing')
            <h1 class="text-xl font-bold mb-6 text-center">Marketing Department List</h1>
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
                   
                </tbody>
            </table>
        </div>
    </div>
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(function () {
    $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('marketing.data') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'address', name: 'address' },
            { data: 'image', name: 'image', orderable: false, searchable: false },
            { data: 'edit', name: 'edit', orderable: false, searchable: false },
            { data: 'delete', name: 'delete', orderable: false, searchable: false },
            { data: 'view', name: 'view', orderable: false, searchable: false },
        ]
    });
});
</script>
@endpush
</x-app-layout>
