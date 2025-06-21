<?php
    use App\EnumAcao;
    use App\UserTypes;
?>

<div>
    @livewire('shared.modal-buttons')

    @if($showModal)
        @if($action == EnumAcao::delete->value && isset($usuario['id']))
            <div>
                <div id="draggableModal" 
                    class="fixed top-1/2 left-1/2 w-96 bg-white text-black border border-gray-300 rounded-xl shadow-xl z-50"
                    style="transform: translate(-50%, -50%);">

                    <div id="modalHeader" class="cursor-move flex justify-between items-center px-4 py-3 border-b bg-gray-100 rounded-t-xl">
                        <h2 class="text-base font-semibold">Deletar Consulta</h2>
                        <button
                            wire:click="closeModal"
                            class="bg-red-600 text-gray-900 text-lg w-8 h-8 rounded">
                            &times;
                        </button>
                    </div>

                    <form id="formModal" action="{{ route('consulta.view') }}" method="POST">
                        @csrf
                        @method('delete')

                        <div class="px-4 py-4">
                            <p class="text-red-600 text-sm mt-1 error-message" data-field="name"></p>
                            @if($usuario)
                                <input
                                    type="number"
                                    name="id"
                                    value="{{ '' }}"
                                    placeholder="number"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    hidden>
                            @endif

                            <div class="px-4 pb-4">
                                <p class="text-sm text-gray-700 mb-3">
                                    Tem certeza que deseja <span class="font-semibold text-red-600">deletar esta consulta</span>? Esta ação não poderá ser desfeita.
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
                    <h2 class="text-base font-semibold">{{ $actionName }} Consulta</h2>
                    <button
                        wire:click="closeModal"
                        class="bg-red-600 text-gray-900 text-lg w-8 h-8 rounded">
                        &times;
                    </button>
                </div>

                <form id="formModal" action="{{ route('consulta.view') }}" method="POST">
                    @csrf
                    @method($method)

                    <div class="px-4 py-4">
                        <!-- Médico -->
                        <label class="block text-sm font-medium text-gray-700">Médico</label>
                        <p class="text-red-600 text-sm mt-1 error-message" data-field="medico_id"></p>
                        <div class="flex items-center space-x-2 mb-3">
                            <input type="text" id="medico_nome" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm" readonly placeholder="Selecione um médico">
                            <input type="hidden" id="medico_id" name="medico_id">
                            <button type="button" class="btn btn-outline ml-2" onclick="abrirModalExterno()"> 🔍 </button>
                        </div>

                        <!-- Especialidade -->
                        <label class="block text-sm font-medium text-gray-700">Especialidade</label>
                        <p class="text-red-600 text-sm mt-1 error-message" data-field="especialidade_id"></p>
                        <select name="especialidade_id" id="especialidade_id" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-3" onchange="especialidadeSelecionada()">
                            <option value="">Selecione</option>
                        </select>

                        <!-- Horário -->
                        <label class="block text-sm font-medium text-gray-700">Horário</label>
                        <p class="text-red-600 text-sm mt-1 error-message" data-field="horario_id"></p>
                        <select name="horario_id" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-3">
                            
                        </select>

                        <!-- Paciente -->
                        <label class="block text-sm font-medium text-gray-700">Paciente</label>
                        <p class="text-red-600 text-sm mt-1 error-message" data-field="paciente_id"></p>
                        <select name="paciente_id" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-3">
                            @foreach ($pacientes as $paciente)
                                <option value="{{ $paciente->id }}">{{ $paciente->nome }}</option>
                            @endforeach
                        </select>

                        <!-- Valor -->
                        <label class="block text-sm font-medium text-gray-700">Valor</label>
                        <input type="text" id="valor" name="valor" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-3" readonly>
                    </div>

                    @if($action != EnumAcao::view->value)
                        <div class="flex justify-end px-4 py-3 border-t gap-2">
                            <button
                                wire:click="closeModal"
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