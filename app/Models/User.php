<?php

namespace App\Models;

use App\Enums\UserTypes;
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
            'password'          => 'hashed',
        ];
    }

    public function getId()
    {
        return $this->attributes['id'];
    }

    public function getNome()
    {
        return $this->attributes['name'];
    }

    public function setNome(string $nome)
    {
        $this->attributes['name'] = $nome;

        return $this;
    }

    public function getEmail()
    {
        return $this->attributes['email'];
    }

    public function setEmail(string $email)
    {
        $this->attributes['email'] = $email;
    }

    public function setSenha(string $senha)
    {
        $this->attributes['password'] = $senha;
    }

    public function getTipoUsuario()
    {
        return $this->attributes['type_user'];
    }

    public function setTipoUsuario(int $tipoUsuario)
    {
        $this->attributes['type_user'] = $tipoUsuario;

        return $this;
    }

    /**
     * Apenas usuários admin podem alterar a senha de usuário pela rotina de usuários.
     * @return bool
     */
    public static function podeAlterarSenha(): bool
    {
        $usuarioLogado = getUsuarioLogado();

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
        if(getUsuarioLogado()->type_user == UserTypes::admin->value){
            return true;
        }

        if(getUsuarioLogado()->type_user == UserTypes::medico->value){
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