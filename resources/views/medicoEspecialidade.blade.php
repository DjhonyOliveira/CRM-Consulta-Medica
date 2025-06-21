<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Minhas Especialidades</h2>
    </x-slot>
    @livewire('modal-especialidade-medico')
    @livewire('table-medico-especialidade')
</x-app-layout>