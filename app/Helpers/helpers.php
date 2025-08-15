<?php

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