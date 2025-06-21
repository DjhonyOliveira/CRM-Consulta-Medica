<?php

namespace App\Livewire;

use App\Models\User;
use App\UserTypes;
use Livewire\Component;

class TableUsuario extends Component
{

    protected $listeners = [
        "dadosAtualizados" => "render" 
    ];
    protected $paginationTheme = 'tailwind';

    public function render()
    {
        return view('livewire.table-usuario', [
            "usuarios" => User::paginate(10)->map(function($usuario){
                $usuario->type_user = UserTypes::from($usuario->type_user)->label();

                return $usuario;
            })
        ]);
    }
}
