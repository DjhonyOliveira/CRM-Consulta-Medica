<div>
    <table class="min-w-full table-auto border border-gray-200 text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-3 py-2 border">
                    <input type="checkbox" disabled name="all-selected" id="all-selected">
                </th>
                <th class="px-3 py-2 border">Nome</th>
                <th class="px-3 py-2 border">Email</th>
                <th class="px-3 py-2 border">Tipo</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($usuarios as $usuario)
                <tr data-row-selectable class="hover:bg-gray-50">
                    <td class="px-3 py-2 border">
                        <input type="checkbox" class="user-checkbox" value="{{ $usuario->id }}">
                    </td>
                    <td class="px-3 py-2 border">{{ $usuario->name }}</td>
                    <td class="px-3 py-2 border">{{ $usuario->email }}</td>
                    <td class="px-3 py-2 border">{{ $usuario->type_user }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-3 py-2 text-center">Nenhum usuário encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>