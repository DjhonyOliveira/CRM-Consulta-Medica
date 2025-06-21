@props(['type' => 'success', 'message' => null])

@php
    $colors = [
        'success' => 'bg-green-600',
        'error' => 'bg-red-600',
        'warning' => 'bg-yellow-500 text-black',
        'info' => 'bg-blue-600',
    ];
    $color = $colors[$type] ?? $colors['info'];
@endphp

<div 
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 5000)"
    x-show="show"
    x-transition:enter="transition ease-out duration-300 transform"
    x-transition:enter-start="opacity-0 translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-300 transform"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-2"
    class="fixed bottom-4 right-4 z-50 w-80 p-4 rounded shadow-xl text-white {{ $color }}"
>
    <div class="flex justify-between items-start">
        <div class="text-sm font-medium">{!! $message !!}</div>
        <button @click="show = false" class="ml-4 font-bold text-lg leading-none">&times;</button>
    </div>
</div>
