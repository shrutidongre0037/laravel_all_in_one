<x-app-layout>
    <div class="max-w-3xl mx-auto mt-10">
        <h2 class="text-2xl text-center font-bold mb-4">Project Detail</h2>
        <div class="bg-white text-center shadow p-6 rounded">
            <p><strong>Title:</strong> {{ $project->title }}</p>
            <p><strong class="ml-36">Description:</strong> {{ $project->description }}</p>
            <p><strong>Start Date:</strong> {{ $project->start_date }}</p>
            <p><strong>End Date:</strong> {{ $project->end_date }}</p>
            <a href="{{ route('projects.index') }}" class="inline-block text-center mt-4 px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
            Back
        </a>
        </div>
         
    </div>
</x-app-layout>
