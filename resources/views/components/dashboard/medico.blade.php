<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <x-dashboard.card title="Consultas de Hoje" color="text-blue-600" :value="$consultasHoje" />
    <x-dashboard.card title="Consultas na Semana" color="text-blue-600" :value="$consultasSemana" />
    <x-dashboard.card title="Próximos Horários Disponíveis" color="text-green-600" :value="$horariosDisponiveis" />
</div>

<div class="mt-8 bg-white rounded-xl shadow p-4 border">
    <h2 class="text-lg font-semibold mb-4">Consultas Futuras</h2>
    <table class="min-w-full text-sm border">
        <thead class="bg-gray-100">
            <tr>
                <th class="text-left py-2 px-3 border">Paciente</th>
                <th class="text-left py-2 px-3 border">Data</th>
                <th class="text-left py-2 px-3 border">Horário</th>
                <th class="text-left py-2 px-3 border">Especialidade</th>
            </tr>
        </thead>
        <tbody>
            @forelse($consultasFuturas as $consulta)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-3 border">{{ $consulta->paciente->name }}</td>
                    <td class="py-2 px-3 border">{{ $consulta->horario->data }}</td>
                    <td class="py-2 px-3 border">{{ $consulta->horario->inicio . ' - ' . $consulta->horario->fim }}</td>
                    <td class="py-2 px-3 border">{{ $consulta->especialidade->nome }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-gray-500 py-4">Nenhuma consulta agendada</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
