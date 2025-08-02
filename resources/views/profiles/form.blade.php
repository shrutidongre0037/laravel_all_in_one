<x-app-layout>
    <div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">
            {{ isset($profile) ? 'Edit Profile' : 'Create Profile' }}
        </h2>

        <form action="{{ isset($profile) ? route('profiles.update', $profile->id) : route('profiles.store') }}" method="POST">
            @csrf
            @if(isset($profile))
                @method('PUT')
            @endif
            
            @if(isset($development))
                <input type="hidden" name="development_id" value="{{ $development->id }}">
            @endif

            <div class="mb-4">
                <label for="linkedin" class="block text-sm font-medium text-gray-700">LinkedIn</label>
                <input type="url" name="linkedin" id="linkedin" value="{{ old('linkedin', $profile->linkedin ?? '') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="mb-4">
                <label for="github" class="block text-sm font-medium text-gray-700">GitHub</label>
                <input type="url" name="github" id="github" value="{{ old('github', $profile->github ?? '') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    {{ isset($profile) ? 'Update' : 'Create' }} Profile
                </button>
            </div>
        </form>
    </div>
</x-app-layout>