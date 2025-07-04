@csrf
<div class="mb-4">
    <label class="block text-gray-700 font-medium mb-2">Department Name</label>
    <input type="text" name="name" value="{{ old('name', $department->name ?? '') }}"
        class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring focus:border-blue-300" required>
    @error('name')
        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="flex justify-between">
    <button type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        {{ $submitButtonText }}
    </button>
</div>
