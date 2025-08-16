<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;

abstract class Controller
{
    function __construct()
    {
        App::setLocale('pt_BR');
    }

    /**
     * Retorna o usuário logado no sistema
     * @return \App\Models\User
     */
    protected function getUsuarioLogado()
    {
        return auth()->user();
    }

    protected function getMensagemInsercaoOk()
    {
        return response()->json([
            "message" => "Dados inseridos com sucesso"
        ]);
    }

    protected function getMessageInsercaoError()
    {
        return response()->json([
            "message" => "Erro ao inserir os dados, tente novamente",
            "type"    => "error",
        ], 404);
    }

    protected function getMessageAlteracaoSucesso()
    {
        return response()->json([
            "message" => "Dados Alterados com sucesso",
        ]);
    }

    protected function getMessageAlteracaoError(){
        return response()->json([
            "message" => "Erro ao atualizar os dados, tente novamente",
            "type"    => "error",
        ], 404);
    }

    protected function getMessageDeleteSucesso()
    {
        return response()->json([
            "message" => "Registro deletado com sucesso"
        ]);
    }

    protected function getMessageDeleteError()
    {
        return response()->json([
            "message" => "Falha ao deletar o registro, tente novamente",
            "type"    => "error"
        ], 404);
    }

}