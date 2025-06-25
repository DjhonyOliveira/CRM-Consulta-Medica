<div>
    <table class="min-w-full table-auto border border-gray-200 text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-3 py-2 border">
                    <input type="checkbox" disabled name="all-selected" id="all-selected">
                </th>
                <th class="px-3 py-2 border">Especialidade</th>
                <th class="px-3 py-2 border">Data</th>
                <th class="px-3 py-2 border">Hora Inicio</th>
                <th class="px-3 py-2 border">Hora Fim</th>
                <th class="px-3 py-2 border">Disponivel</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($horarios as $horario)
                <tr data-row-selectable class="hover:bg-gray-50">
                    <td class="px-3 py-2 border">
                        <input type="checkbox" class="table-checkbox" value="{{ $horario->id }}">
                    </td>
                    <td class="px-3 py-2 border">{{ $horario->especialidade->nome }}</td>
                    <td class="px-3 py-2 border">{{ $horario->data }}</td>
                    <td class="px-3 py-2 border">{{ $horario->inicio }}</td>
                    <td class="px-3 py-2 border">{{ $horario->fim }}</td>
                    <td class="px-3 py-2 border">{{ $horario->disponivel ? 'Sim' : 'Não' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-3 py-2 text-center">Nenhum Horário de atendimento encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>