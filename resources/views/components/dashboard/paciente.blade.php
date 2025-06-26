<div class="space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <x-dashboard.card title="Consultas Futuras" color="text-blue-600" :value="$consultasFuturas" />
        <x-dashboard.card title="Consultas Realizadas" color="text-green-600" :value="$consultasRealizadas" />
        <x-dashboard.card title="Especialidades Disponíveis" color="text-purple-600" :value="$especialidadesDisponiveis" />
    </div>

    <div class="bg-white mt-3 shadow rounded-xl p-4 border">
        <h2 class="text-lg font-semibold mb-4">Próxima Consulta</h2>

        @if($proximaConsulta)
            <div class="space-y-2 text-sm">
                <p><strong>Data:</strong> {{ $proximaConsulta->horario->data }}</p>
                <p><strong>Horário:</strong> {{ $proximaConsulta->horario->inicio }} - {{ $proximaConsulta->horario->fim }}</p>
                <p><strong>Médico:</strong> {{ $proximaConsulta->medico->name }}</p>
                <p><strong>Especialidade:</strong> {{ $proximaConsulta->especialidade->nome }}</p>
            </div>
        @else
            <p class="text-gray-500">Nenhuma consulta agendada.</p>
        @endif
    </div>
</div>
