<x-app-layout>
<div class="max-w-6xl mx-auto mt-10">
    <h1 class="text-xl font-bold mb-6 text-center">Project List</h1>
</div>

    <div class="container mx-auto py-10">    

             <div class="text-left mb-4">
            <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Add Project</a>
            <a class="px-4 py-2 bg-blue-500 text-white rounded" href="{{ route('projects.index',['deleted' => 1]) }}">Restore</a>
<button onclick="document.getElementById('massUpdateModal').classList.remove('hidden')" class="px-4 py-2 bg-indigo-600 text-white rounded">Mass Update</button>
        </div>

            
        <table id="table" class="display table-auto w-full bg-white shadow-md rounded-lg text-sm">
                <thead class="bg-gray-200 text-gray-700">
                    <tr class="text-center">
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th class="sorting">Edit</th>
                    <th class="sorting">Delete</th>
                    <th class="sorting">View</th>

                </tr>
            </thead>
        </table>
    </div>

    @php
        $module = 'project';
        $fields = collect(config("form_fields.$module"))
            ->filter(fn($f) => !in_array($f['type'], ['file', 'multiselect']) && $f['name'] !== 'id');
    @endphp

    <div id="massUpdateModal" class="hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded shadow-lg w-[400px]">
            <h2 class="text-lg font-bold mb-4">Mass Update Projects</h2>
            <form method="POST" action="{{ route('mass.update') }}">
                @csrf
                <input type="hidden" name="module" value="{{ $module }}">

                <label class="block mb-2 font-semibold">Select Column</label>
                <select name="column" id="massColumn" class="w-full border p-2 mb-4" onchange="updateMassValueDropdown()" required>
                    <option value="">-- Select Column --</option>
                    @foreach ($fields as $field)
                        <option value="{{ $field['name'] }}"
                                data-type="{{ $field['type'] }}"
                                data-options="{{ $field['options'] ?? '' }}"
                                data-label="{{ $field['optionLabel'] ?? '' }}">
                            {{ ucfirst(str_replace('_', ' ', $field['name'])) }}
                        </option>
                    @endforeach
                </select>

                <div id="massValueField"></div>

                <div class="mt-4 flex justify-end">
                    <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded mr-2" onclick="document.getElementById('massUpdateModal').classList.add('hidden')">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update All</button>
                </div>
            </form>
        </div>
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
                    { data: 'status', name: 'status' },
                    { data: 'priority', name: 'priority' },
                    { data: 'edit' },
                    { data: 'delete' },
                    { data: 'view'},
                ]
            });
        });
    </script>
    <script>
    const selectOptions = {
        statuses: @json($statuses),
        priorities: @json($priorities),
    };
</script>
    <script>
    function updateMassValueDropdown() {
    const select = document.getElementById('massColumn');
    const selectedOption = select.options[select.selectedIndex];

    const type = selectedOption.getAttribute('data-type');
    const optionKey = selectedOption.getAttribute('data-options');
    const labelKey = selectedOption.getAttribute('data-label');

    const container = document.getElementById('massValueField');
    container.innerHTML = '';

    if (type === 'select' && optionKey in selectOptions) {
        const selectField = document.createElement('select');
        selectField.name = 'value';
        selectField.required = true;
        selectField.classList.add('w-full', 'border', 'p-2', 'mb-4');

        selectOptions[optionKey].forEach(opt => {
            const option = document.createElement('option');
            option.value = opt.id;
            option.text = opt[labelKey] ?? opt.id;
            selectField.appendChild(option);
        });

        container.appendChild(selectField);
    } else {
        const input = document.createElement('input');
        input.name = 'value';
        input.type = type === 'date' ? 'date' : 'text';
        input.required = true;
        input.classList.add('w-full', 'border', 'p-2', 'mb-4');
        container.appendChild(input);
    }
}
    </script>
    @endpush
</x-app-layout>
