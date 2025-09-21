<?php

namespace App\View;

use stdClass;

/**
 * Classe base das Views do sistema
 * @package View
 * @author Djonatan R. de Oliveira
 */
abstract class View
{
    protected int $acao;
    protected stdClass $parametros;

    abstract protected function build();

    function __construct(int $acao, stdClass $parametros = new stdClass())
    {
        $this->setAcao($acao);
        $this->setParametros($parametros);
    }

    protected function setAcao(int $acao)
    {
        $this->acao = $acao;

        return $this;
    }

    protected function getAcao()
    {
        if(!isset($this->acao)){
            $this->acao = 0;
        }

        return $this->acao;
    }

    protected function setParametros(stdClass $parametros)
    {
        $this->parametros = $parametros;

        return $this;
    }

    protected function getparametros()
    {
        if(!isset($this->parametros)){
            $this->parametros = new stdClass();
        }

        return $this->parametros;
    }

    public function toJson()
    {
        return response()->json([
            "components" => $this->build()
        ]);
    }
}