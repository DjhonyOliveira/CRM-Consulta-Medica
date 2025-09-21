<?php

use App\Enums\EnumRotina;

?>

<x-nav-link 
    :href="route('dashboard')" 
    :active="request()->routeIs('dashboard', 'dashboard.paciente', 'dashboard.medico', 'dashboard.admin')">

    {{ __('Dashboard') }}
</x-nav-link>

@if (!auth()->user()->isPaciente())
    <x-nav-link 
        :href="route('usuario.index')" 
        :active="request()->routeIs('usuario.index')">

        {{ __('Usuários') }}
    </x-nav-link>

    <x-nav-link 
        :href="route('pacientes.index')" 
        :active="request()->routeIs('pacientes.index')">

        {{ __('Pacientes') }}
    </x-nav-link>
@endif

<x-nav-link 
    :href="route('medicos.index')" 
    :active="request()->routeIs('medicos.index', 'medico.perfil.view', 'medico.perfil.especialidade.view', 'medico.perfil.valorConsulta.view')">

    {{ __('Médicos') }}
</x-nav-link>

@if(auth()->user()->isAdmin())
    <x-nav-link 
        :href="route('especialidade.view', ['rotina' =>  EnumRotina::especialidades->value])" 
        :active="request()->routeIs('especialidade.view')">

        {{ __('Especialidades Médicas') }}
    </x-nav-link>
@endif

<x-nav-link 
    :href="route('consulta.view')" 
    :active="request()->routeIs('consulta.view')">

    {{ __('Consultas') }}
</x-nav-link>