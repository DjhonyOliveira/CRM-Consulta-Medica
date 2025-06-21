<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Valor das Consultas por especialidade</h2>
    </x-slot>
    @livewire('modal-valor-consulta')
    @livewire('table-valor-consulta')
</x-app-layout>