@csrf
<input type="text" name="title" class="w-full border p-2 mb-4" placeholder="Project title" value="{{ old('title', $project->title ?? '') }}" required>
<input type="text" name="description" class="w-full border p-2 mb-4" placeholder="Project description"  value="{{ old('description', $project->description ?? '') }}" required>
<input type="date" name="start_date" class="w-full border p-2 mb-4" placeholder="Project Start Date"  value="{{ old('start_date', $project->start_date ?? '') }}" required>
<input type="date" name="end_date" class="w-full border p-2 mb-4" placeholder="Project End Date"  value="{{ old('end_date', $project->end_date ?? '') }}" required>

<button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">{{ $submitButtonText }}
</button>

