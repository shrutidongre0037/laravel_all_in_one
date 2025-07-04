<x-app-layout>
    <div class="max-w-md mx-auto mt-10">
        <h2 class="text-xl font-bold mb-4">Add Employee</h2>
        <form method="POST" action="{{ route('marketings.store') }}" enctype="multipart/form-data">
            @csrf
            @include('marketings.form', ['submitButtonText' => 'Create'])

        </form>
    </div>
</x-app-layout>
