<div class="space-y-8">
    <!-- Cards com Métricas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <x-dashboard.card title="Total de Médicos" color="text-blue-600" :value="$totalMedicos" />
        <x-dashboard.card title="Total de Pacientes" color="text-green-600" :value="$totalPacientes" />
        <x-dashboard.card title="Total de Admins" color="text-purple-600" :value="$totalAdmins" />
        <x-dashboard.card title="Total de Consultas" color="text-orange-600" :value="$totalConsultas" />
        <x-dashboard.card title="Especialidades Cadastradas" color="text-pink-600" :value="$totalEspecialidades" />
    </div>

    <div class="bg-white mt-3 shadow rounded-xl p-4 border">
        <h2 class="text-lg font-semibold mb-4">Consultas Recentes</h2>

        <table class="min-w-full text-sm border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left py-2 px-3 border">Paciente</th>
                    <th class="text-left py-2 px-3 border">Médico</th>
                    <th class="text-left py-2 px-3 border">Especialidade</th>
                    <th class="text-left py-2 px-3 border">Criada em</th>
                </tr>
            </thead>
            <tbody>
                @forelse($consultasRecentes as $consulta)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-3 border">{{ $consulta->paciente->name }}</td>
                        <td class="py-2 px-3 border">{{ $consulta->medico->name }}</td>
                        <td class="py-2 px-3 border">{{ $consulta->especialidade->nome }}</td>
                        <td class="py-2 px-3 border">{{ \Carbon\Carbon::parse($consulta->created_at)->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-gray-500 py-4">Nenhuma consulta recente.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>