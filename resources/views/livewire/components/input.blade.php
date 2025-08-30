<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <p class="text-red-600 text-sm mt-1 error-message" data-field="{{ $name ?? '' }}"></p>
    <input
        type="{{ $type }}"
        value="{{ $value ?? '' }}"
        name="{{ $name ?? '' }}"
        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
        {{ $readOnly ? 'readonly' : '' }}
        required>
</div>