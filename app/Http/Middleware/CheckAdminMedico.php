<?php

namespace App\Http\Middleware;

use App\Enums\UserTypes;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminMedico
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if(!$user || $user->type_user == UserTypes::paciente->value){
            abort('403', 'Acesso negado. Apenas médicos e administradores tem acesso a esta rotina no sistema');
        }
        
        return $next($request);
    }
}
