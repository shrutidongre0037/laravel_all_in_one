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

        

        <a href="{{ route('developments.index') }}" class="inline-block mt-4 px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
            Back
        </a>
    </div>
</x-app-layout>
