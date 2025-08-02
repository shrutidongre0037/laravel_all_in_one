<x-app-layout>
    <div class="max-w-4xl text-center mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Employee Details</h2>
@if($development->image)
            <div class="mb-4 text-center">
                <img src="{{ asset('storage/' . $development->image) }}" alt="Employee Image" class="h-30 mt-2 text-center ml-96 mr-80">
            </div>
        @endif
        <div class="mb-4">
            <strong>Name:</strong> {{ $development->name }}
        </div>
        <div class="mb-4">
            <strong>Email:</strong> {{ $development->email }}
        </div>
        <div class="mb-4">
            <strong>Phone:</strong> {{ $development->phone }}
        </div>
        <div class="mb-4">
            <strong>Address:</strong> {{ $development->address }}
        </div>
        <div class="mb-4">
            <strong>Department:</strong>
            @if($development->departments && $development->departments->count())
                @foreach($development->departments as $dept)
                    {{ $dept->name }}
                @endforeach
            @endif
        </div>

<div class="mb-4 ml-0">
    <strong>Projects:</strong>
    @if($development->projects && $development->projects->count())
        <ul class="list-disc list-inside text-center">
            @foreach($development->projects as $project)
                <a href="{{ route('projects.show', ['project' => $project->id])}}?from=development&employee_id={{ $development->id }}" target="_self"><li>{{ $project->title }}</a></li>
            @endforeach
        </ul>
    @else
        None Assigned
    @endif
</div>

        
<hr class="my-6">

        <div class="mb-4 text-left">
            <h3 class="text-lg font-bold mb-2">Profile Links</h3>
            @if($development->profileLink && $development->profileLink->profile)
            @php $profile = $development->profileLink->profile ?? null; @endphp
                <p><strong>LinkedIn:</strong>
                    <a href="{{ $profile->linkedin }}" target="_blank" class="text-blue-600 underline">{{ $profile->linkedin }}</a>
                </p>
                <p><strong>GitHub:</strong>
                    <a href="{{ $profile->github }}" target="_blank" class="text-blue-600 underline">{{ $profile->github }}</a>
                </p>
                <a href="{{ route('profiles.edit', $profile->id) }}"
                   class="inline-block mt-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Edit Profile
                </a>
            @else
                <p class="text-gray-500">No profile information available.</p>
                <a href="{{ route('profiles.create', ['development_id' => $development->id]) }}"
                   class="inline-block mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Create Profile
                </a>
            @endif
        </div>

        <a href="{{ route('developments.index') }}"
           class="inline-block mt-6 px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
            Back
        </a>
    </div>
</x-app-layout>
