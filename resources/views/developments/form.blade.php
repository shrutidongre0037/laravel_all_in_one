@csrf
<input type="text" name="name" class="w-full border p-2 mb-4" placeholder="Employee name" value="{{ old('name', $development->name ?? '') }}" required>
<input type="email" name="email" class="w-full border p-2 mb-4" placeholder="Employee Email"  value="{{ old('email', $development->email ?? '') }}" required>
<input type="phone" name="phone" class="w-full border p-2 mb-4" placeholder="Employee Phone"  value="{{ old('phone', $development->phone ?? '') }}" required>
<input type="address" name="address" class="w-full border p-2 mb-4" placeholder="Employee Address"  value="{{ old('address', $development->address ?? '') }}" required>
<input type="file" name="image" class="w-full border p-2 mb-4" placeholder="Employee Image" value="{{ old('image', $development->image ?? '') }}"  >
@if(!empty($development->image))
    <img src="{{ asset('storage/' . $development->image) }}" alt="Current Image" class="h-16 mt-2">
@endif

<button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">{{ $submitButtonText }}
</button>

