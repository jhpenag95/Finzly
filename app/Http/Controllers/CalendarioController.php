<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    public function calendario()
    {
        return view('calendario.calendario');
    }
}
