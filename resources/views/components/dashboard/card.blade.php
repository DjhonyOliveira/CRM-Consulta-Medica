@props(['title', 'value', 'color' => 'text-blue-600'])

<div class="bg-white shadow rounded-xl p-4 border">
    <h2 class="text-lg font-semibold mb-2">{{ $title }}</h2>
    <p class="text-3xl font-bold {{ $color }}">{{ $value }}</p>
</div>
