<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4">
        <x-dashboard.medico
            :consultasHoje="$consultasHoje"
            :consultasSemana="$consultasSemana"
            :horariosDisponiveis="$horariosDisponiveis"
            :consultasFuturas="$consultasFuturas"
        />
    </div>
</x-app-layout>
