<?php
    use App\Enums\EnumAcao;
?>

<div class="top-24 left-4 z-50 bg-white border border-gray-300 shadow-md px-4 py-2 flex gap-2">
    @if($permiteIncluir)
        <button 
            id="adicionar"
            class="bg-green-500 hover:bg-green-600 text-white text-sm font-medium py-1 px-3 rounded-md transition duration-200 btn-crud"
            data-acao="<?= EnumAcao::create->value ?>">
            ➕ Adicionar
        </button>
    @endif
    
    @if($permiteDeletar)
        <button
            id="delete"
            data-acao="<?= EnumAcao::delete->value ?>"
            class="bg-red-500 hover:bg-red-600 text-white text-sm font-medium py-1 px-3 rounded-md transition duration-200 btn-crud">
            🗑 Excluir
        </button>
    @endif
    
    @if($permiteVisualizar)
        <button
            id="visualizar"
            data-acao="<?= EnumAcao::view->value ?>"
            class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-1 px-3 rounded-md transition duration-200 btn-crud">
            👁 Visualizar
        </button>
    @endif
    
    @if($permiteAlterar)
        <button
            id="alterar"
            data-acao="<?= EnumAcao::update->value ?>"
            class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium py-1 px-3 rounded-md transition duration-200 btn-crud">
            ✏️ Alterar
        </button>
    @endif
    

    @foreach ($extraButtons as $btn)
        @if(is_array($btn) && isset($btn['label']))
            @if(!empty($btn['route']))
                <a
                    href="{{ $btn['route'] }}"
                    id="{{ $btn['id'] ?? '' }}"
                    data-acao="{{ $btn['acao'] ?? '' }}"
                    class="{{ $btn['color'] ?? 'bg-gray-500' }} text-white text-sm font-medium py-1 px-3 rounded-md transition duration-200 inline-block">
                    {{ $btn['label'] }}
                </a>
            @else
                <button
                    id="{{ $btn['id'] ?? '' }}"
                    data-acao="{{ $btn['acao'] ?? '' }}"
                    class="{{ $btn['color'] ?? 'bg-gray-500' }} text-white text-sm font-medium py-1 px-3 rounded-md transition duration-200">
                    {{ $btn['label'] }}
                </button>
            @endif
        @endif
    @endforeach
</div>