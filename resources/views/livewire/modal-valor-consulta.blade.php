<?php

use App\EnumAcao;

?>

<div>
    @livewire('shared.modal-buttons')

    @if($showModal)
        @if($action == EnumAcao::delete->value)
            <div>
                <div id="draggableModal" 
                    class="fixed top-1/2 left-1/2 w-96 bg-white text-black border border-gray-300 rounded-xl shadow-xl z-50"
                    style="transform: translate(-50%, -50%);">

                    <p class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert" data-field="sucesso" style="display: none;"></p>
                    <p class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" data-field="error" style="display: none;"></p>
                    <div id="modalHeader" class="cursor-move flex justify-between items-center px-4 py-3 border-b bg-gray-100 rounded-t-xl">
                        <h2 class="text-base font-semibold">Deletar Valor de consulta</h2>
                        <button
                            wire:click="closeModal"
                            class="bg-red-600 text-gray-900 text-lg w-8 h-8 rounded">
                            &times;
                        </button>
                    </div>

                    <form id="formModal" action="{{ route('medico.perfil.valorConsulta.view') }}" method="POST">
                        @csrf
                        @method('delete')

                        <div class="px-4 py-4">
                            <p class="text-red-600 text-sm mt-1 error-message" data-field="name"></p>
                            @if($valoresConsulta)
                                <input
                                    type="number"
                                    name="id"
                                    value="{{ $valoresConsulta['id'] ?? '' }}"
                                    placeholder="number"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    hidden>
                            @endif

                            <div class="px-4 pb-4">
                                <p class="text-sm text-gray-700 mb-3">
                                    Tem certeza que deseja <span class="font-semibold text-red-600">deletar este valor de consulta</span>? Esta ação não poderá ser desfeita.
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
                
                <p class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert" data-field="sucesso" style="display: none;"></p>
                <p class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" data-field="error" style="display: none;"></p>

                <div id="modalHeader" class="cursor-move flex justify-between items-center px-4 py-3 border-b bg-gray-100 rounded-t-xl">
                    <h2 class="text-base font-semibold">{{ $actionName . ' Valor da Consulta' }}</h2>
                    <button
                        wire:click="closeModal"
                        class="bg-red-600 text-gray-900 text-lg w-8 h-8 rounded">
                        &times;
                    </button>
                </div>

                <form id="formModal" action="{{ route('medico.perfil.valorConsulta.view') }}" method="POST">
                    @csrf
                    @method($method)

                    <div class="px-4 py-4 space-y-3">
                    
                        @if($action == EnumAcao::update->value)
                            <input
                                type="number"
                                name="id"
                                value="{{ $valoresConsulta['id'] ?? '' }}"
                                placeholder="number"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                hidden>
                        @endif

                        <label for="especialidades" class="block text-sm font-medium text-gray-700">Especialidades</label>
                        <p class="text-red-600 text-sm mt-1 error-message" data-field="especialidade"></p>
                        <select
                            id="especialidades"
                            name="especialidade"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                            required
                            {{ $action == EnumAcao::view->value ? 'disabled' : '' }}>
                            <option value="" disabled selected>Selecione...</option>                          
                            @foreach($todasEspecialidades as $especialidade)
                                <option value="{{ $especialidade['id'] }}" 
                                {{ array_key_exists('especialidade', $valoresConsulta) && $valoresConsulta['especialidade'] ==  $especialidade['id'] ? 'selected' : ''}}>
                                    {{ $especialidade['nome'] }}
                                </option>
                            @endforeach
                        </select>

                        <label for="valor" class="block text-sm font-medium text-gray-700">Valor</label>
                        <p class="text-red-600 text-sm mt-1 error-message" data-field="valor"></p>
                        <input
                            type="number"
                            name="valor"
                            id="valor"
                            step="0.01"
                            placeholder="0.00"
                            value="{{ $valoresConsulta['valor'] ?? '' }}"
                            {{ $action == EnumAcao::view->value ? 'readonly' : '' }}
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                            required>
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
