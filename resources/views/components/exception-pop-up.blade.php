@props(['id' => 'exception-popup'])

<div 
    id="{{ $id }}" 
    class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center"
>
    <div class="bg-white max-w-lg w-full p-6 rounded shadow-xl relative">
        <button class="absolute top-2 right-3 text-2xl leading-none" onclick="closeExceptionPopup()">&times;</button>
        <h2 class="text-lg font-bold text-red-600 mb-3">Erro no sistema</h2>
        <pre id="exception-message" class="text-sm text-gray-800 overflow-auto max-h-96 whitespace-pre-wrap"></pre>
    </div>
</div>
