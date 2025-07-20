@php
    $fields = config('form_fields.' . $module);
@endphp

@csrf

@foreach ($fields as $field)
    @php
        $modelValue = old($field['name'], ${$model}->{$field['name']} ?? '');
    @endphp

    {{-- Select Dropdown --}}
    @if ($field['type'] === 'select')
        <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
        <select name="{{ $field['name'] }}" class="w-full border p-2 mb-4" {{ $field['required'] ? 'required' : '' }}>
            @foreach (${$field['options']} as $option)
                <option value="{{ $option->id }}"
                    {{ $modelValue == $option->id ? 'selected' : '' }}>
                    {{ $option->{$field['optionLabel']} }}
                </option>
            @endforeach
        </select>

    {{-- Multiselect --}}
    @elseif ($field['type'] === 'multiselect')
        <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
        <select name="{{ $field['name'] }}" multiple class="w-full border p-2 mb-4">
            @foreach (${$field['options']} as $option)
                <option value="{{ $option->id }}"
                    {{ isset(${$model}) && ${$model}->projects->contains($option->id) ? 'selected' : '' }}>
                    {{ $option->{$field['optionLabel']} }}
                </option>
            @endforeach
        </select>

    {{-- File Input --}}
    @elseif ($field['type'] === 'file')
        <input type="file"
               name="{{ $field['name'] }}"
               class="w-full border p-2 mb-4"
               placeholder="{{ $field['placeholder'] ?? '' }}"
               {{ $field['required'] ? 'required' : '' }}>
        @if (!empty(${$model}->image))
            <img src="{{ asset('storage/' . ${$model}->image) }}" alt="Current Image" class="h-16 mt-2">
        @endif

    {{-- Other Input Types --}}
    @else
        <input type="{{ $field['type'] }}"
               name="{{ $field['name'] }}"
               class="w-full border p-2 mb-4"
               placeholder="{{ $field['placeholder'] }}"
               value="{{ $modelValue }}"
               {{ $field['required'] ? 'required' : '' }}>
    @endif
@endforeach

<button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">
    {{ $submitButtonText ?? 'Submit' }}
</button>
