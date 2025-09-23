<?php

namespace App\Http\Controllers;

use App\Enums\EnumAcao;
use App\Enums\EnumRotina;
use Illuminate\Http\Request;

/**
 * Controller de instancia e retorno JSON das views do sistema
 * @package Controller
 * @author Djonatan R. de Oliveira
 */
class ControllerScreen extends Controller
{

    /**
     * Realiza a instancia da View solicitada pelo frontEnd e retorna o JSON para instancia do componente no cliente
     * @param mixed $request
     * @return string
     */
    public function show($request): string
    {
        $codigoRotina  = (int) $request->get("rotina");
        $acao          = (int) $request->get("acao");
        $bIsManutencao = $acao == EnumAcao::index->value ? false : true;

        $rotina = EnumRotina::fromCode($codigoRotina);

        if(!$rotina){
            return response()->json([
                "message" => "Rotina inválida",
                "type"    => "error"
            ], 404);
        }

        $class = $rotina->screenClass($bIsManutencao);
        $view  = new $class($acao);

        return $view->toJson()->additional([
            "rotina" => [
                "codigo" => $codigoRotina,
                "nome"   => $rotina->label()
            ]
        ]);
    }
}