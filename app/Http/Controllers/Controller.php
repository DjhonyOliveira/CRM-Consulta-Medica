<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;

abstract class Controller
{
    function __construct()
    {
        App::setLocale('pt_BR');
    }

}
