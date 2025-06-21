<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pacientes') }}
        </h2>
    </x-slot>
    @include('components.table-pacientes', ['pacientes' => $pacientes])
</x-app-layout>