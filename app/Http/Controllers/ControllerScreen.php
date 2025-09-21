<?php

namespace App\Http\Controllers;

use App\Enums\EnumRotina;
use Illuminate\Http\Request;

/**
 * Controller de instancia e retorno JSON das views do sistema
 */
class ControllerScreen extends Controller
{
    public function show($request)
    {
        $codigoRotina = (int) $request->get("rotina");
        $acao         = (int) $request->get("acao");

        $rotina = EnumRotina::fromCode($codigoRotina);

        if(!$rotina){
            return response()->json([
                "error" => "Rotina inválida"
            ], 404);
        }

        $class = $rotina->screenClass();
        $view  = new $class($acao);

        return $view->toJson()->additional([
            "rotina" => [
                "codigo" => $codigoRotina,
                "nome"   => $rotina->label()
            ]
        ]);
    }
}