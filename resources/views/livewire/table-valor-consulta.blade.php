<div>
    <table class="min-w-full table-auto border border-gray-200 text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-3 py-2 border">
                    <input type="checkbox" disabled name="all-selected" id="all-selected">
                </th>
                <th class="px-3 py-2 border">Especialidade</th>
                <th class="px-3 py-2 border">Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($valorConsulta as $consulta)
                <tr data-row-selectable class="hover:bg-gray-50">
                    <td class="px-3 py-2 border">
                        <input type="checkbox" class="user-checkbox" value="{{ $consulta->id }}">
                    </td>
                    <td class="px-3 py-2 border">{{ $consulta->especialidade->nome ?? 'N/A' }}</td>
                    <td class="px-3 py-2 border">R$ {{ number_format($consulta->valor, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>