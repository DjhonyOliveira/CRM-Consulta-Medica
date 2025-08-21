<?php
    use App\EnumAcao;
    use App\UserTypes;
?>

<div>
    @livewire('shared.modal-buttons')

    @if($showModal)
        @if($action == EnumAcao::delete->value)
            <div>
                @livewire('components.modal-delete', [
                        "showModalDelete" => $showModal,
                        "action"          => $action,
                        "dados"           => $consulta,
                        "nomeRotina"      => "Consulta",
                        "route"           => "consulta.view"
                    ])
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
                        @if($action !== EnumAcao::create->value)
                            <input
                                type="number"
                                name="id"
                                value="{{ $consulta['id'] ?? '' }}"
                                placeholder="number"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                hidden>
                        @endif        

                        @if(!auth()->user()->isMedico())
                            <label class="block text-sm font-medium text-gray-700">Médico</label>
                            <p class="text-red-600 text-sm mt-1 error-message" data-field="medico_id"></p>
                            <div class="flex items-center space-x-2 mb-3">
                                <input type="text" id="medico_nome" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm" readonly placeholder="Selecione um médico"
                                 value="{{ $action !== EnumAcao::create->value && array_key_exists('medico_nome', $consulta) ? $consulta['medico_nome'] : ''}}">
                                 <input value="{{ $consulta['medico_id'] ?? '' }}" type="hidden" id="medico_id" name="medico_id">
                                 @if($action !== EnumAcao::view->value)
                                    <button type="button" class="btn btn-outline ml-2" onclick="abrirModalExternoMedico()"> 🔍 </button>
                                @endif
                            </div>
                        @else
                            <input value="{{ auth()->user()->isMedico() ? auth()->user()->id : '' }}" type="hidden" id="medico_id" name="medico_id">
                        @endif

                        <label class="block text-sm font-medium text-gray-700">Especialidade</label>
                        <p class="text-red-600 text-sm mt-1 error-message" data-field="especialidade_id"></p>
                        <select name="especialidade_id" id="especialidade_id" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-3" onchange="especialidadeSelecionada()"
                        {{ $action == EnumAcao::view->value ? 'disabled' : '' }}>
                            <option value="">Selecione</option>
                            @if(auth()->user()->isMedico())
                                @foreach($medico as $especialidade)
                                    <option value="{{ $especialidade->id }}"
                                    {{ $action !== EnumAcao::create->value && ($consulta['especialidade'] == $especialidade->id) ? 'selected' : '' }}>
                                    {{ $especialidade->nome }}
                                    </option>
                                @endforeach
                            @elseif(in_array($action,[EnumAcao::view->value, EnumAcao::update->value]))
                                @foreach($consulta['especialidades'] as $especialidade)
                                    <option value="{{ $especialidade->id }}"
                                    {{ $consulta['especialidade' == $especialidade->id ? 'selected' : ''] }}>
                                    {{ $especialidade->nome }}
                                    </option>
                                @endforeach
                            @endif
                        </select>

                        <label class="block text-sm font-medium text-gray-700">Horário</label>
                        <p class="text-red-600 text-sm mt-1 error-message" data-field="horario_id"></p>
                        <select name="horario_id" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-3"
                        {{ $action == EnumAcao::view->value ? 'disabled' : '' }}>
                            @if(in_array($action, [EnumAcao::view->value, EnumAcao::update->value]))
                                @foreach($consulta['horarios'] as $horario)
                                    <option value="{{ $horario->id }}"
                                    {{ $consulta['horario_id'] == $horario->id ? 'selected' : '' }} >
                                    Data: {{ \Carbon\Carbon::parse($horario->data)->format('d/m/Y') }}, 
                                    Inicio: {{ \Carbon\Carbon::parse($horario->fim)->format('H:i') }}, 
                                    Fim: {{ \Carbon\Carbon::parse($horario->fim)->format('H:i') }}</option>
                                @endforeach
                            @endif
                        </select>

                        @if(!auth()->user()->isPaciente())
                            <label class="block text-sm font-medium text-gray-700">Paciente</label>
                            <p class="text-red-600 text-sm mt-1 error-message" data-field="paciente_id"></p>
                            <div class="flex items-center space-x-2 mb-3">
                                <input type="text" value="{{ $consulta['paciente_nome'] ?? '' }}" id="paciente_nome" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm" readonly placeholder="Selecione um Paciente">
                                <input type="hidden" value="{{ $consulta['paciente_id'] ?? '' }}" id="paciente_id" name="paciente_id">
                                @if($action !== EnumAcao::view->value)
                                    <button type="button" class="btn btn-outline ml-2" onclick="abrirModalExternoPaciente()"> 🔍 </button>
                                @endif
                            </div>
                        @endif


                        <label class="block text-sm font-medium text-gray-700">Valor</label>
                        <input type="text" id="valor" value="{{ $consulta['valor'] ?? '' }}" name="valor" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-3" readonly>
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