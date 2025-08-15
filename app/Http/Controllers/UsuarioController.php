<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UsuarioController extends Controller
{

    public function renderView(Request $request)
    {
        return view('usuarios');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password'  => ['required', 'confirmed', Password::defaults()],
            'type_user' => 'required|integer|in:1,2,3'
        ]);

        $pessoa = new User();
        $pessoa->name      = $request->name;
        $pessoa->email     = $request->email;
        $pessoa->password  = Hash::make($request->password);
        $pessoa->type_user = $request->type_user;

        if($pessoa->save()){
            return $this->getMensagemInsercaoOk();
        }

        return $this->getMessageInsercaoError();
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'        => 'required|int',
            'name'      => 'string|max:255',
            'email'     => 'string|lowercase|email|max:255|unique:'.User::class
        ]);

        $oModelUser = User::find($request->id);

        if(!User::podeAlterarUsuarioFromModelUser($oModelUser)){
            return response()->json([
                "message" => "Você não tem privilégio para alterar este usuário, contate um administrador do sistema caso necessário",
                "type"    => "warning",
            ]);
        }

        if($request->filled('name')){
            $oModelUser->name = $request->name;
        }

        if($request->filled('email')){
            $oModelUser->email = $request->email;
        }

        if($oModelUser->save()){
            return $this->getMessageAlteracaoSucesso();
        }

        return $this->getMessageAlteracaoError();
    }

    public function delete(Request $request)
    {
        $idUsuario  = $request->id;
        $oModelUser = User::find($idUsuario);

        if($oModelUser->delete()){
            return $this->getMessageDeleteSucesso();
        } 
        
        return $this->getMessageDeleteError();
    }

}