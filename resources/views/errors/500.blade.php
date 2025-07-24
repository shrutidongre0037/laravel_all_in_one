<x-app-layout>
    <div class="text-center mt-10">
        <h1 class="text-5xl font-bold text-red-700">500</h1>
        <p class="text-xl mt-4">Internal Server Error</p>
        <p class="text-md text-gray-600 mt-2">{{ $message ?? 'Something went wrong on the server.' }}</p>
        <a href="{{ route('dashboard') }}" class="mt-6 inline-block text-blue-500 underline">Go back to dashboard</a>
    </div>
</x-app-layout>
