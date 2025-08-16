<?php

use App\EnumAcao;

?>

<div>
    @if ($showModalDelete)
        <div id="draggableModal" 
            class="fixed top-1/2 left-1/2 w-96 bg-white text-black border border-gray-300 rounded-xl shadow-xl z-50"
            style="transform: translate(-50%, -50%);">

            <div id="modalHeader" class="cursor-move flex justify-between items-center px-4 py-3 border-b bg-gray-100 rounded-t-xl">
                <h2 class="text-base font-semibold">Deletar <?= $nomeRotina; ?></h2>
                <button
                    wire:click="closeModal"
                    class="bg-red-600 text-gray-900 text-lg w-8 h-8 rounded">
                    &times;
                </button>
            </div>

            <form id="formModal" action="{{ route('<?= $actionRoute; ?>') }}" method="POST">
                @csrf
                @method('delete')

                <div class="px-4 py-4">
                    <p class="text-red-600 text-sm mt-1 error-message" data-field="name"></p>
                    @if(array_key_exists('id', $dados))
                        <input
                            type="number"
                            name="id"
                            value="{{ $dados['id'] ?? '' }}"
                            placeholder="number"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                            hidden>
                    @endif

                    <div class="px-4 pb-4">
                        <p class="text-sm text-gray-700 mb-3">
                            Tem certeza que deseja <span class="font-semibold text-red-600">deletar este registro</span>? Esta ação não poderá ser desfeita.
                        </p>
                        <button type="submit"
                            class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 transition">
                            Confirmar Exclusão
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif
</div>