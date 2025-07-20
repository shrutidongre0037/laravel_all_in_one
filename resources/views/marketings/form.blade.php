@include('components.dynamic-form', [
    'module' => 'marketing',
    'model' => 'marketing',
    'marketing' => $marketing ?? null,
    'submitButtonText' => $submitButtonText ?? 'Submit',
])
