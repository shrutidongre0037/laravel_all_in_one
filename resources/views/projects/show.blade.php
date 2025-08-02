<x-app-layout>
    <div class="max-w-3xl mx-auto mt-10">
        <h2 class="text-2xl text-center font-bold mb-4">Project Detail</h2>
        <div class="bg-white text-center shadow p-6 rounded">
            <p><strong>Title:</strong> {{ $project->title }}</p>
            <p><strong class="ml-36">Description:</strong> {{ $project->description }}</p>
            <p><strong>Start Date:</strong> {{ $project->start_date }}</p>
            <p ><strong>End Date:</strong> {{ $project->end_date }}</p>
            <p><strong>Status:</strong> {{ $project->status }}</p>
            <p class="mb-3"><strong>Priority:</strong> {{ $project->priority }}</p>
            @if(request()->get('from') === 'development' && request()->has('employee_id'))
                <a href="{{ route('developments.show', request()->get('employee_id')) }}" class="bg-gray-700 text-white px-4 py-2 rounded">
                    Back to Employee
                </a>
            @elseif(has_role('admin'))
                <a href="{{ route('projects.index') }}" class="bg-gray-700 text-white px-4 py-2 rounded">Back to List</a>
            @endif

        </div>
         
    </div>
</x-app-layout>
