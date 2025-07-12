<x-app-layout>
    <div class="max-w-md mx-auto mt-10">
        <h2 class="text-xl font-bold mb-4">Add Project</h2>
        <form method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data">
            @csrf
            @include('projects.form', ['submitButtonText' => 'Create'])
        </form>
    </div>
    @if ($errors->any())
    <div class="bg-red-100 text-red-800 p-3 mb-4 rounded">
        <strong>There were some errors with your input:</strong>
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
</x-app-layout>
