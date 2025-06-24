<div class="mr-2">
    <table class="min-w-full table-auto border border-gray-200 text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-3 py-2 border">Nome</th>
                <th class="px-3 py-2 border">Email</th>
                <th class="px-3 py-2 border">Especialidades</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($medicos as $medico)
                <tr class="hover:bg-gray-50" onclick="selecionarMedico(this)"
                    data-id="{{ $medico->id }}"
                    data-nome="{{ $medico->name }}"
                    class="hover:bg-gray-100 cursor-pointer">
                    <td class="px-3 py-2 border" id="medico_nome">{{ $medico->name }}</td>
                    <td class="px-3 py-2 border">{{ $medico->email }}</td>
                    <td class="px-3 py-2 border">
                        @if ($medico->especialidades->isNotEmpty())
                            @foreach ($medico->especialidades as $esp)
                                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1 mb-1">
                                    {{ $esp->nome }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-gray-400 text-xs">Sem especialidades</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-3 py-2 text-center">Nenhum médico encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>