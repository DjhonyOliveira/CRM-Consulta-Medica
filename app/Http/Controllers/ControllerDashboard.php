<?php

namespace App\Http\Controllers;

use App\Models\ModelConsulta;
use App\Models\ModelEspecialidade;
use App\Models\ModelHorariosDisponiveis;
use App\Models\User;
use App\UserTypes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ControllerDashboard extends Controller
{
    public function dashboardMedico()
    {
        $userId = $this->getUsuarioLogado()->id;

        $consultasHoje = DB::table('consulta')
                        ->join('horarios_disponiveis', 'consulta.horario_id', '=', 'horarios_disponiveis.id')
                        ->where('horarios_disponiveis.data', today()->format('Y-m-d'))
                        ->where('consulta.medico_id', $userId)->get()
                        ->count();

        $consultasSemana = ModelConsulta::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->where('medico_id', $userId)->count();

        $horariosDisponiveis = ModelHorariosDisponiveis::where('medico_id', $userId)
            ->where('disponivel', true)
            ->where('inicio', '>', now())
            ->count();

        $consultasFuturas = ModelConsulta::with(['paciente', 'horario', 'especialidade'])
            ->join('horarios_disponiveis', 'consulta.horario_id', '=', 'horarios_disponiveis.id')
                        ->where('horarios_disponiveis.data', today()->format('Y-m-d'))
                        ->where('consulta.medico_id', $userId)->get();

        if($consultasFuturas){
            $consultasFuturas->map(function($consulta){
                $consulta->horario->inicio = Carbon::parse($consulta->horario->inicio)->format('H:i');
                $consulta->horario->fim    = Carbon::parse($consulta->horario->fim   )->format('H:i');
                $consulta->horario->data   = Carbon::parse($consulta->horario->data  )->format('d/m/Y');

                return $consulta;
            });
        }

        return view('dashboard.medico', compact(
            'consultasHoje',
            'consultasSemana',
            'horariosDisponiveis',
            'consultasFuturas'
        ));
    }

    public function dashboardPaciente()
    {
        $userId = $this->getUsuarioLogado()->id;

        $consultasFuturas = ModelConsulta::where('paciente_id', $userId)
            ->whereHas('horario', fn($q) => $q->where('inicio', '>', now()))
            ->count();

        $consultasRealizadas = ModelConsulta::where('paciente_id', $userId)
            ->whereHas('horario', fn($q) => $q->where('inicio', '<', now()))
            ->count();

        $especialidadesDisponiveis = ModelEspecialidade::count();

        $proximaConsulta = ModelConsulta::with(['medico', 'especialidade', 'horario'])
            ->where('paciente_id', $userId)
            ->whereHas('horario', fn($q) => $q->where('inicio', '>', now()))
            ->orderBy('horario_id')
            ->first();

        if($proximaConsulta){
            $proximaConsulta->map(function($consulta){
                $consulta->horario->inicio = Carbon::parse($consulta->horario->inicio)->format('H:i');
                $consulta->horario->fim    = Carbon::parse($consulta->horario->fim   )->format('H:i');
                $consulta->horario->data   = Carbon::parse($consulta->horario->data  )->format('d/m/Y');

                return $consulta;
            });
        }
        
        return view('dashboard.paciente', compact(
            'consultasFuturas',
            'consultasRealizadas',
            'especialidadesDisponiveis',
            'proximaConsulta'
        ));
    }

    public function dashboardAdmin()
    {
        $totalPacientes      = User::where('type_user', UserTypes::paciente->value)->count();
        $totalMedicos        = User::where('type_user', UserTypes::medico->value)->count();
        $totalAdmins         = User::where('type_user', UserTypes::admin->value)->count();
        $totalConsultas      = ModelConsulta::count();
        $totalEspecialidades = ModelEspecialidade::count();

        $consultasRecentes = ModelConsulta::with(['paciente', 'medico', 'especialidade'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('dashboard.admin', compact(
            'totalMedicos',
            'totalPacientes',
            'totalAdmins',
            'totalConsultas',
            'totalEspecialidades',
            'consultasRecentes'
        ));
    }

}
