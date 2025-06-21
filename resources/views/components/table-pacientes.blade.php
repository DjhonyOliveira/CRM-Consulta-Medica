<div>
    <table class="min-w-full table-auto border border-gray-200 text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-3 py-2 border">Nome</th>
                <th class="px-3 py-2 border">Email</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pacientes as $paciente)
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-2 border">{{ $paciente->name }}</td>
                    <td class="px-3 py-2 border">{{ $paciente->email }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="px-3 py-2 text-center">Nenhum paciente encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>