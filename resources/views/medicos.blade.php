<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Médicos</h2>
    </x-slot>

    @if(auth()->user()->isMedico())
        <div class="top-24 left-4 z-50 bg-white border border-gray-300 shadow-md px-4 py-2 flex gap-2">
            <a href="{{ route('medico.perfil.view') }}"
               id="alterar"
               class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium py-1 px-3 rounded-md transition duration-200">
               ✏️ Editar meu Perfil
            </a>
        </div>
    @endif
    @include('components.table-medicos', ['medicos' => $medicos])
</x-app-layout>
