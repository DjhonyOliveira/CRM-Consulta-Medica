<?php

use App\EnumAcao;

?>

<div>
    @livewire('shared.modal-buttons', [
        "extraButtons" => [
            [
                "id"    => "especialidades",
                "label" => "➕ Minhas Especialidades",
                "acao"  => 5,
                "color" => "bg-green-500 hover:bg-green-600",
                "route" => route('medico.perfil.especialidade.view')
            ],
            [
                "id"    => "valor-consulta",
                "label" => "💲 Valor das Consultas",
                "acao"  => 6,
                "color" => "bg-green-500 hover:bg-green-600",
                "route" => route('medico.perfil.valorConsulta.view')
            ]
        ]
    ])

    @if($showModal)
        @if($action == EnumAcao::delete->value)
            <div>
                <div id="draggableModal" 
                    class="fixed top-1/2 left-1/2 w-96 bg-white text-black border border-gray-300 rounded-xl shadow-xl z-50"
                    style="transform: translate(-50%, -50%);">

                    <div id="modalHeader" class="cursor-move flex justify-between items-center px-4 py-3 border-b bg-gray-100 rounded-t-xl">
                        <h2 class="text-base font-semibold">Deletar Horário</h2>
                        <button
                            wire:click="closeModal"
                            class="bg-red-600 text-gray-900 text-lg w-8 h-8 rounded">
                            &times;
                        </button>
                    </div>

                    <form id="formModal" action="{{ route('medico.perfil.view') }}" method="POST">
                        @csrf
                        @method('delete')

                        <div class="px-4 py-4">
                            <p class="text-red-600 text-sm mt-1 error-message" data-field="name"></p>
                            @if($horario)
                                <input
                                    type="number"
                                    name="id"
                                    value="{{ $horario['id'] ?? '' }}"
                                    placeholder="number"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    hidden>
                            @endif

                            <div class="px-4 pb-4">
                                <p class="text-sm text-gray-700 mb-3">
                                    Tem certeza que deseja <span class="font-semibold text-red-600">deletar este horário de atendimento</span>? Esta ação não poderá ser desfeita.
                                </p>
                                <button type="submit"
                                    class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 transition">
                                    Confirmar Exclusão
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <div id="draggableModal"
                class="fixed top-1/2 left-1/2 w-96 bg-white text-black border border-gray-300 rounded-xl shadow-xl z-50"
                style="transform: translate(-50%, -50%);">

                <div id="modalHeader" class="cursor-move flex justify-between items-center px-4 py-3 border-b bg-gray-100 rounded-t-xl">
                    <h2 class="text-base font-semibold">{{ $actionName . ' Horário de consulta' }}</h2>
                    <button
                        wire:click="closeModal"
                        class="bg-red-600 text-gray-900 text-lg w-8 h-8 rounded">
                        &times;
                    </button>
                </div>

                <form id="formModal" action="{{ route('medico.perfil.view') }}" method="POST">
                    @csrf
                    @method($method)

                    <div class="px-4 py-4 space-y-3">

                        @if($horario && $action == EnumAcao::update->value)
                            <input
                                type="number"
                                name="id"
                                value="{{ $horario['id'] ?? '' }}"
                                placeholder="number"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                hidden>
                        @endif
                    
                        <div class="mb-1">
                            <label for="especialidades" class="block text-sm font-medium text-gray-700">Especialidade</label>
                            <p class="text-red-600 text-sm mt-1 error-message" data-field="especialidade_id"></p>
                            <select
                                id="especialidade_id"
                                name="especialidade_id"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                                {{ $action == EnumAcao::view->value ? 'disabled' : '' }}>
                                <option value="" disabled selected>Selecione...</option>
                                @foreach($todasEspecialidades as $especialidade)
                                    <option 
                                        value="{{ $especialidade['id'] }}"
                                        {{$action !== EnumAcao::create->value && array_key_exists('id', $especialidade) && $especialidade['id'] == $horario['especialidade'] ? 'selected' : '' }}>
                                        {{ $especialidade['nome'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-1">
                            <label for="data" class="block text-sm font-medium text-gray-700">Data</label>
                            <p class="text-red-600 text-sm mt-1 error-message mb-0" data-field="data"></p>
                            <input 
                                type="date"
                                name="data"
                                value="{{ $horario['data'] ?? '' }}"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" 
                                required
                                {{ $action == EnumAcao::view->value ? 'readonly' : '' }}>
                        </div>

                        <div class="mb-1">
                            <label for="hora_inicio" class="block text-sm font-medium text-gray-700">Hora de Início</label>
                            <p class="text-red-600 text-sm mt-1 error-message" data-field="hora_inicio"></p>
                            <input
                                type="time"
                                name="hora_inicio"
                                id="hora_inicio"
                                value="{{ $horario['inicio'] ?? '' }}"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                                {{ $action == EnumAcao::view->value ? 'readonly' : '' }}
                                required>
                        </div>

                        <div class="mb-1">
                            <label for="hora_fim" class="block text-sm font-medium text-gray-700">Hora de Término</label>
                            <p class="text-red-600 text-sm mt-1 error-message" data-field="hora_fim"></p>
                            <input
                                type="time"
                                name="hora_fim"
                                id="hora_fim"
                                value="{{ $horario['fim'] ?? '' }}"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                                {{ $action == EnumAcao::view->value ? 'readonly' : '' }}
                                required>
                        </div>

                    </div>

                    @if($action != EnumAcao::view->value)
                        <div class="flex justify-end px-4 py-3 border-t gap-2">
                            <button
                                wire:click="closeModal"
                                type="button"
                                class="bg-gray-200 hover:bg-gray-300 text-black text-sm font-medium px-4 py-2 rounded">
                                Cancelar
                            </button>
                            <button
                                type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-black text-sm font-medium px-4 py-2 rounded">
                                Salvar
                            </button>
                        </div>
                    @endif
                </form>
            </div>
        @endif
    @endif
</div>