<x-app-layout>
    <div class="max-w-md mx-auto mt-10">
        <h2 class="text-xl font-bold mb-4">Edit Employee</h2>
        <form method="POST" action="{{ route('marketings.update', $marketing->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('marketings.form', [
                'submitButtonText' => 'Update',
                'marketing' => $marketing
            ])
        </form>
    </div>
</x-app-layout>

