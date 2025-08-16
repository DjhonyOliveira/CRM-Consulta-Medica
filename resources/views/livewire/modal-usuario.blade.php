<?php

    use App\EnumAcao;
    use App\UserTypes;
    
?>

<div>
    @livewire('shared.modal-buttons')

    @if($showModal)
        @if($action == EnumAcao::delete->value && isset($usuario['id']))
            <div>
                @livewire('components.modal-delete', [
                        "showModalDelete"  => $showModal,
                        "action"           => $action,
                        "dados"            => $usuario,
                        "nomeRotina"       => "Usuário",
                        "actionRoute"      => "consulta.view"
                    ])
            </div>
        @else 
            <div id="draggableModal"
                class="fixed top-1/2 left-1/2 w-96 bg-white text-black border border-gray-300 rounded-xl shadow-xl z-50"
                style="transform: translate(-50%, -50%);">

                <div id="modalHeader" class="cursor-move flex justify-between items-center px-4 py-3 border-b bg-gray-100 rounded-t-xl">
                    <h2 class="text-base font-semibold">{{ $actionName }} Usuário</h2>
                    <button
                        wire:click="closeModal"
                        class="bg-red-600 text-gray-900 text-lg w-8 h-8 rounded">
                        &times;
                    </button>
                </div>

                <form id="formModal" action="{{ route('usuario.store') }}" method="POST">
                    @csrf
                    @method($method)

                    <div class="px-4 py-4">

                        @if($usuario && $action == EnumAcao::update->value)
                            <input
                                type="number"
                                name="id"
                                value="{{ $usuario['id'] ?? '' }}"
                                placeholder="number"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                hidden>
                        @endif

                            <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                            <p class="text-red-600 text-sm mt-1 error-message" data-field="name"></p>
                            <input
                                type="text"
                                value="{{ $usuario['name'] ?? '' }}"
                                name="name"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                {{ $action == EnumAcao::view->value ? 'readonly' : '' }}
                                required>

                            <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                            <p class="text-red-600 text-sm mt-1 error-message" data-field="email"></p>
                            <input
                                type="email"
                                name="email"
                                value="{{ $usuario['email'] ?? '' }}"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                {{ $action == EnumAcao::view->value ? 'readonly' : '' }}
                                required>

                        @if($podeAlterarSenha)
                            <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                            <p class="text-red-600 text-sm mt-1 error-message" data-field="password"></p>
                            <input
                                type="password"
                                name="password"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                {{ $action == EnumAcao::view->value ? 'readonly' : '' }}
                                required>

                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirme sua Senha</label>
                            <input
                                type="password"
                                name="password_confirmation"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                {{ $action == EnumAcao::view->value ? 'readonly' : '' }}
                                required>
                        @endif
                        
                        @if($action !== EnumAcao::update->value)
                            <label for="type_user" class="block text-sm font-medium text-gray-700">Tipo de Usuário</label>
                            <p class="text-red-600 text-sm mt-1 error-message" data-field="type_user"></p>
                            <select 
                                id="type_user" 
                                name="type_user" 
                                class="bg-gray-50 border border-gray-300 text-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-300 dark:placeholder-gray-300 dark:text-gray-500 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                {{ $action == EnumAcao::view->value ? 'disabled' : '' }}>
                                <option value=""  {{ $action == EnumAcao::create->value ? 'selected' : '' }}>Tipo de Usuário</option>
                                @foreach ($tipoUsuario as $key => $value)
                                    <option value="{{ $value }}"  {{ $action !== EnumAcao::create->value && array_key_exists('tipo', $usuario) && $usuario['tipo'] == $value ? 'selected' : '' }}>{{ $key }}</option>
                                @endforeach
                            </select>
                        @endif

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