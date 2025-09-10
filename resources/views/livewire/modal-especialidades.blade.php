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
            <div>
               {!! $modal !!}
            </div>
        @endif
    @endif
</div>