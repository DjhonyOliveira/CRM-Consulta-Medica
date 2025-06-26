<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <x-dashboard.admin 
            :totalMedicos="$totalMedicos"
            :totalPacientes="$totalPacientes"
            :totalAdmins="$totalAdmins"
            :totalConsultas="$totalConsultas"
            :totalEspecialidades="$totalEspecialidades"
            :consultasRecentes="$consultasRecentes"
        />
    </div>
</x-app-layout>
