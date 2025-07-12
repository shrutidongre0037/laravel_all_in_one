<x-app-layout>
    <div class="max-w-md mx-auto mt-10">
        <h2 class="text-xl font-bold mb-4">Edit Project</h2>
        <form method="POST" action="{{ route('projects.update', $project->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('projects.form', ['submitButtonText' => 'Update'])
        </form>
    </div>
</x-app-layout>

