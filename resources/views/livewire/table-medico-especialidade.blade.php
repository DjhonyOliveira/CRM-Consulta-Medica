<div>
    <table class="min-w-full table-auto border border-gray-200 text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-3 py-2 border">
                    <input type="checkbox" disabled name="all-selected" id="all-selected">
                </th>
                <th class="px-3 py-2 border">Nome</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($medico as $especialidade)
                <tr data-row-selectable class="hover:bg-gray-50">
                    <td class="px-3 py-2 border">
                        <input type="checkbox" class="user-checkbox" value="{{ $especialidade->id }}">
                    </td>
                    <td class="px-3 py-2 border">{{ $especialidade->nome }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-3 py-2 text-center">Nenhuma especialidade encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>