<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Consultas Agendadas</h2>
    </x-slot>
    @livewire('modal-consulta')
    @livewire('table-consultas')
    @livewire('modal-table-medicos')
    @livewire('modal-table-pacientes')
</x-app-layout>