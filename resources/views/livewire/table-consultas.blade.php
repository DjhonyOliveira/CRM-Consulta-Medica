<?php

use App\EnumConsulta;

?>

<div>
    <table class="min-w-full table-auto border border-gray-200 text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-3 py-2 border">
                    <input type="checkbox" disabled name="all-selected" id="all-selected">
                </th>
                <th class="px-3 py-2 border">Paciente</th>
                <th class="px-3 py-2 border">Médico</th>
                <th class="px-3 py-2 border">Especialidade</th>
                <th class="px-3 py-2 border">Data</th>
                <th class="px-3 py-2 border">Horário</th>
                <th class="px-3 py-2 border">Valor</th>
                <th class="px-3 py-2 border">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consultas as $consulta)
            <tr class="hover:bg-gray-50">
                <td>
                    <input class="ml-3" type="checkbox" value="{{ $consulta->id }}">
                </td>
                <td class="px-3 py-2 border">{{ $consulta->paciente->name ?? '-' }}</td>
                <td class="px-3 py-2 border">{{ $consulta->medico->name ?? '-' }}</td>
                <td class="px-3 py-2 border">{{ $consulta->especialidade->nome ?? '-' }}</td>
                <td class="px-3 py-2 border">{{ \Carbon\Carbon::parse($consulta->horario->data)->format('d/m/Y') ?? '-' }}</td>
                <td class="px-3 py-2 border">
                    {{ \Carbon\Carbon::parse($consulta->horario->inicio ?? '')->format('H:i') ?? '-' }}
                    -
                    {{ \Carbon\Carbon::parse($consulta->horario->fim ?? '')->format('H:i') ?? '-' }}
                </td>
                <td class="px-3 py-2 border">R$ {{ number_format($consulta->valor, 2, ',', '.') }}</td>
                <td class="px-3 py-2 border">{{ EnumConsulta::from($consulta->status)->statusConsulta() }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>