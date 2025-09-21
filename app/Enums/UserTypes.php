<?php

namespace App\Enums;

enum UserTypes: int
{
    case paciente = 1;
    case medico   = 2;
    case admin    = 3;

    public function label(): string
    {
        return match($this){
            self::paciente => 'Paciente',
            self::medico   => 'Médico',
            self::admin    => 'Admin'
        };
    }

    /**
     * Retorna uma lista de tipo de usuários com base no usuário logado, 
     * ou seja, apenas as opções permitidas para edição e visualização
     * @param bool $bMostraTodos
     * @return array
     */
    public static function getArrayListaTipoPessoa($bMostraTodos = false): array
    {
        if(!$bMostraTodos){
            if(getUsuarioLogado()->type_user == self::admin->value){
                return [
                    "Admin"    => self::admin->value,
                    "Médico"   => self::medico->value,
                    "Paciente" => self::paciente->value
                ];
            }
            else if(getUsuarioLogado()->type_user == self::medico->value){
                return ["Paciente" => self::paciente->value];
            }
        }

        return [
            "Admin"    => self::admin->value,
            "Médico"   => self::medico->value,
            "Paciente" => self::paciente->value
        ];
    }
}