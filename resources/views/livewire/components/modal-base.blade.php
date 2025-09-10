<?php

use App\EnumAcao;

?>

<div>
    @if($show)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white w-1/2 rounded-xl shadow-xl p-6">
                
                <div class="flex justify-between items-center border-b pb-2 mb-4">
                    <h2 class="text-xl font-bold">{{ $title }}</h2>
                    <button wire:click="closeModal" class="bg-red-600 text-white w-8 h-8 rounded">&times;</button>
                </div>

                <form class="formModal" action="{{ $formAction }}" method="POST">
                    @csrf
                    @method($method)

                    @foreach($fields as $field)
                        {!! $field !!}
                    @endforeach

                    <div class="flex justify-end space-x-2 mt-4 border-t pt-3">
                        <button 
                            type="button" 
                            wire:click="closeModal" 
                            class="bg-gray-200 hover:bg-gray-300 text-black text-sm font-medium px-4 py-2 rounded">
                            {{ $action == EnumAcao::view->value ? 'Fechar' : 'Cancelar' }}
                        </button>

                        @if($action !== EnumAcao::view->value)
                            <button 
                                type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-black text-sm font-medium px-4 py-2 rounded">
                                Salvar
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>