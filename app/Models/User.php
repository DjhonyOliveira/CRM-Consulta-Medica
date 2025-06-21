<?php

namespace App\Models;

use App\UserTypes;
use DragonCode\Contracts\Cashier\Auth\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type_user'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Apenas usuários admin podem alterar a senha de usuário pela rotina de usuários.
     * @return bool
     */
    public static function podeAlterarSenha(): bool
    {
        $usuarioLogado = auth()->user();

        if($usuarioLogado->type_user == UserTypes::admin->value){
            return true;
        }

        return false;
    }

    /**
     * Valida se pode ou não realizar a alteração do usuário com base no usuário logado
     * @param \App\Models\User $oModel
     * @return bool
     */
    public static function podeAlterarUsuarioFromModelUser(User $oModel): bool
    {
        if(auth()->user()->type_user == UserTypes::admin->value){
            return true;
        }

        if(auth()->user()->type_user == UserTypes::medico->value){
            if($oModel->type_user == UserTypes::paciente->value){
                return true;
            }
        }

        return false;
    }

    public function isMedico(): bool
    {
        return $this->type_user == UserTypes::medico->value;
    }

    public function isPaciente(): bool
    {
        return $this->type_user == UserTypes::paciente->value;
    }

    public function isAdmin(): bool
    {
        return $this->type_user == UserTypes::admin->value;
    }

    public function especialidades()
    {
        return $this->belongsToMany(ModelEspecialidade::class, 'medico_especialidade', 'medico_id', 'especialidade_id');
    }

    public function consultasPaciente()
    {
        return $this->hasMany(ModelConsulta::class, 'paciente_id');
    }

    public function consultasMedico()
    {
        return $this->hasMany(ModelConsulta::class, 'medico_id');
    }

}
