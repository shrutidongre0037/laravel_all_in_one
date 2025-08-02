@include('components.dynamic-form', [
    'module' => 'project',
    'model' => 'project',
    'project' => $project ?? null,
    'submitButtonText' => $submitButtonText ?? 'Submit',
    'statuses' => $statuses ?? [],
    'priorities' => $priorities ?? [],
])