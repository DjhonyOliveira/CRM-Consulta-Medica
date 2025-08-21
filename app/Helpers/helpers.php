<?php

use Carbon\Carbon;

/**
 * Realiza o tratamento de um valor string para float
 * @param string $sValor
 * @return float
 */
function trataValorDecimal(string $sValor): float
{
    $valorLimpo   = str_replace(['', 'R$:', ' '], '', $sValor);
    $valorDecimal = str_replace(',', '.', $valorLimpo);

    return (float) $valorDecimal;
}

/**
 * Retorna o usuário logado no sistema
 * @return \App\Models\User
 */
function getUsuarioLogado()
{
    return auth()->user();
}

/**
 * Formata uma string de data para o padrão BR (d/m/a)
 * @param string $data
 * @return string
 */
function formataDataBr(string $data)
{
    return Carbon::parse($data)->format('d/m/Y');
}

/**
 * Formata uma string de horário para o padrão BR (h/m)
 * @param string $horario
 * @return string
 */
function formataHorarioBr(string $horario)
{
    return Carbon::parse($horario)->format('H:i');
}