<x-app-layout>
    <div class="max-w-md mx-auto mt-10">
        <h2 class="text-xl font-bold mb-4">Edit Employee</h2>
        <form method="POST" action="{{ route('marketings.update', $marketing->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="text" name="name" class="w-full border p-2 mb-4" placeholder="Employee name" value="{{ old('name', $marketing->name ?? '') }}" required>
            <input type="email" name="email" class="w-full border p-2 mb-4" placeholder="Employee Email"  value="{{ old('email', $marketing->email ?? '') }}" required>
            <input type="phone" name="phone" class="w-full border p-2 mb-4" placeholder="Employee Phone"  value="{{ old('phone', $marketing->phone ?? '') }}" required>
            <input type="address" name="address" class="w-full border p-2 mb-4" placeholder="Employee Address"  value="{{ old('address', $marketing->address ?? '') }}" required>
            <input type="file" name="image" class="w-full border p-2 mb-4" placeholder="Employee Image" value="{{ old('image', $marketing->image ?? '') }}"  >
            @if($marketing->image)
                <img src="{{ asset('storage/' . $marketing->image) }}" alt="Current Image" class="h-16 mt-2">
            @endif

            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Save</button>
        </form>
    </div>
</x-app-layout>

