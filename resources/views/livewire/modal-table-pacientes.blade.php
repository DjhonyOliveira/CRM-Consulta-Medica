<div
    x-data="{ open: false }"
    @abrir-modal-externo-paciente.window="open = true;"
    @fechar-modal-externo-paciente.window="open = false"
>
    <template x-if="open">
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30">
            <div
                id="draggableModalExterno"
                class="fixed bg-white w-[800px] max-h-[90vh] overflow-y-auto border border-gray-300 rounded-xl shadow-xl"
                style="top: 20%; left: 50%; transform: translate(-50%, 0); min-height: 400px;"
            >
                <div
                    id="modalHeaderExterno"
                    class="cursor-move flex justify-between items-center px-4 py-3 border-b bg-gray-100 "
                >
                    <h2 class="text-base font-semibold">Selecionar Paciente</h2>
                    <button @click="open = false" class="bg-red-600 text-white text-lg w-8 h-8 rounded">
                        &times;
                    </button>
                </div>

                @include('components.table-pacientes', ['paciente' => $pacientes])                
            </div>
        </div>
    </template>
</div>