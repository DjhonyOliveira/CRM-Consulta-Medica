<?php

use App\EnumAcao;

?>

<div>
    @livewire('shared.modal-buttons')

    @if($showModal)
        @if($action == EnumAcao::delete->value)
            <div>
                @livewire('components.modal-delete', [
                        "showModalDelete" => $showModal,
                        "action"          => $action,
                        "dados"           => $especialidade,
                        "nomeRotina"      => "Especialidade",
                        "route"           => "especialidade.view"
                    ])
            </div>
        @else
            <div id="draggableModal"
                class="fixed top-1/2 left-1/2 w-96 bg-white text-black border border-gray-300 rounded-xl shadow-xl z-50"
                style="transform: translate(-50%, -50%);">

                <p class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert" data-field="sucesso" style="display: none;"></p>

                <div id="modalHeader" class="cursor-move flex justify-between items-center px-4 py-3 border-b bg-gray-100 rounded-t-xl">
                    <h2 class="text-base font-semibold">{{ $actionName }} Especialidade</h2>
                    <button
                        wire:click="closeModal"
                        class="bg-red-600 text-gray-900 text-lg w-8 h-8 rounded">
                        &times;
                    </button>
                </div>

                <form id="formModal" action="{{ route('especialidade.view') }}" method="POST">
                    @csrf
                    @method($method)

                    <div class="px-4 py-4">
                        <label for="especialidades" class="block text-sm font-medium text-gray-700 mb-2">
                            Especialidades
                        </label>
                        <p class="text-red-600 text-sm mt-1 error-message" data-field="nome"></p>
                        <input
                            type="text"
                            name="nome"
                            value="{{ $especialidade['nome'] ?? '' }}"
                            placeholder="Nome"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                            {{ $action == EnumAcao::view->value ? 'readonly' : '' }}
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