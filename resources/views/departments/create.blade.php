<x-app-layout>
    <div class="max-w-md mx-auto mt-10">
        <h2 class="text-xl font-bold mb-4">Add Department</h2>
        <form method="POST" action="{{ route('departments.store') }}">
            @csrf
             @include('departments.form', [
                'submitButtonText' => 'Create',
                'department' => null
            ])
        </form>
    </div>
</x-app-layout>
