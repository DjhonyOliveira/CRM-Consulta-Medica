<?php

use App\Http\Controllers\ControllerConsulta;
use App\Http\Controllers\EspecialidadeController;
use App\Http\Controllers\ValorConsultaController;
use App\Http\Controllers\MedicoEspecialidade;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\MedicoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Models\User;
use App\UserTypes;

use function PHPSTORM_META\map;

App::setLocale('pt_BR');

Route::aliasMiddleware('checkMedico', \App\Http\Middleware\CheckMedico::class);
Route::aliasMiddleware('checkAdmin', \App\Http\Middleware\CheckAdmin::class);
Route::aliasMiddleware('checkMedicoAdmin', \App\Http\Middleware\CheckAdminMedico::class);

Route::get('/', function () {
    return view('welcome');
});

/**
 * Rotas para retorno de informações para tratamento via ajax
 */
Route::get('/components/toast', function () {
    $type    = request('type', 'success');
    $message = request('message', '');

    return view('components.toast', compact('type', 'message'));
});

Route::get('medicos/{id}/especialidades', [MedicoController::class, 'especialidades']);
Route::get('consultas/valor', [ControllerConsulta::class, 'valorConsulta']);


/**
 * Rota dashboard
 */
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/**
 * Rota padrão breeze referente a usuários
 */
Route::middleware('auth')->group(function () {
    Route::get   ('/profile', [ProfileController::class, 'edit']   )->name('profile.edit');
    Route::patch ('/profile', [ProfileController::class, 'update'] )->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * Rotas de usuário interno no sistema
 */
Route::middleware(['auth', 'verified', 'checkMedicoAdmin'])->group(function(){
    Route::get   ('/usuario', [UsuarioController::class, 'renderView'])->name('usuario.index');
    Route::post  ('/usuario', [UsuarioController::class, 'create']    )->name('usuario.store');
    Route::put   ('/usuario', [UsuarioController::class, 'update']    )->name('usuario.update');
    Route::delete('/usuario', [UsuarioController::class, 'delete']    )->name('usuario.delete');
});

/**
 * Rota de visualização de pacientes
 */
Route::middleware(['auth', 'checkMedicoAdmin'])->group(function(){
    Route::get('pacientes', function(){
        return view('pacientes', [
            "pacientes" => user::paginate(10)->filter(function($paciente){
                return $paciente->type_user == UserTypes::paciente->value;
            })
        ]);
    })->name('pacientes.index');
});


/**
 * Rota de visualização de médicos
 */
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/medico', function () {
        return view('medicos', [
            'medicos' => User::where('type_user', UserTypes::medico->value)
                            ->with('especialidades')
                            ->paginate(10)
        ]);
    })->name('medicos.index');
});

/**
 * Rotas para manipulação de informações dos médicos
 */
Route::middleware(['auth', 'checkMedico'])->group(function(){
    Route::get   ('/medico/perfil', [MedicoController::class, 'renderView'])->name('medico.perfil.view');
    Route::post  ('/medico/perfil', [MedicoController::class, 'create']    )->name('medico.perfil.post');
    Route::put   ('/medico/perfil', [MedicoController::class, 'update']    )->name('medico.perfil.update');
    Route::delete('/medico/perfil', [MedicoController::class, 'delete']    )->name('medico.perfil.delete');
});

Route::middleware(['auth', 'checkMedico'])->group(function(){
    Route::get   ('/medico/perfil/especialidade', [MedicoEspecialidade::class, 'renderView'])->name('medico.perfil.especialidade.view'  );
    Route::post  ('/medico/perfil/especialidade', [MedicoEspecialidade::class, 'create']    )->name('medico.perfil.especialidade.create');
    Route::delete('/medico/perfil/especialidade', [MedicoEspecialidade::class, 'delete']    )->name('medico.perfil.especialidade.delete');
});

Route::middleware(['auth', 'checkMedico'])->group(function(){
    Route::get   ('/medico/perfil/valorConsulta', [ValorConsultaController::class, 'renderView'])->name('medico.perfil.valorConsulta.view'  );
    Route::post  ('/medico/perfil/valorConsulta', [ValorConsultaController::class, 'create']    )->name('medico.perfil.valorConsulta.create');
    Route::put   ('/medico/perfil/valorConsulta', [ValorConsultaController::class, 'update']    )->name('medico.perfil.valorConsulta.update');
    Route::delete('/medico/perfil/valorConsulta', [ValorConsultaController::class, 'delete']    )->name('medico.perfil.valorConsulta.delete');
});

/**
 * Rotas rotina de consulta
 */
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get   ('/consulta', [ControllerConsulta::class, 'renderView'])->name('consulta.view'  );
    Route::post  ('/consulta', [ControllerConsulta::class, 'create']    )->name('consulta.create');
    Route::put   ('/consulta', [ControllerConsulta::class, 'update']    )->name('consulta.update');
    Route::delete('/consulta', [ControllerConsulta::class, 'delete']    )->name('consulta.delete');

    /** Rotas de requisição AJAX */
    Route::get('/consulta/horarios-disponiveis/{medicoId}/{especialidadeId}', [ControllerConsulta::class, 'getHorariosDisponiveisByMedico']);
    Route::get('/consulta/valor-consulta/{medicoId}/{especialidadeId}', [ControllerConsulta::class, 'getValorConsultaByMedicoEspecialidade']);
});

/**
 * Rotas de controle admin
 */
Route::middleware(['auth', 'checkAdmin'])->group(function(){
    Route::get   ('/especialidade', [EspecialidadeController::class, 'renderView'])->name('especialidade.view'  );
    Route::post  ('/especialidade', [EspecialidadeController::class, 'create']    )->name('especialidade.create');
    Route::put   ('/especialidade', [EspecialidadeController::class, 'renderView'])->name('especialidade.update');
    Route::delete('/especialidade', [EspecialidadeController::class, 'delete']    )->name('especialidade.delete');
});

require __DIR__.'/auth.php';