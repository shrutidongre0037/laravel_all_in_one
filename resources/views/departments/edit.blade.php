<x-app-layout>
    <div class="max-w-md mx-auto mt-10">
        <h2 class="text-2xl font-bold mb-4 text-center">Edit Department</h2>

        <form method="POST" action="{{ route('departments.update', $department->id) }}">
            @csrf
            @method('PUT')
             @include('departments.form', [
                'submitButtonText' => 'Update',
                'department' => $department
            ])
        </form>
    </div>
</x-app-layout>
