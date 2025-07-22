@include('components.dynamic-form', [
    'module' => 'department',
    'model' => 'department',
    'department' => $department ?? null,
    'submitButtonText' => $submitButtonText ?? 'Submit',
])
