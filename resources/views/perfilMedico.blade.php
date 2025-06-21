<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Meu Perfil Médico | Horário das Consultas</h2>
    </x-slot>
    @livewire('modal-perfil-medico')
    @livewire('table-perfil-medico')
</x-app-layout>