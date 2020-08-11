<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $docente = Auth::user()->docentes()->first();
        if (!$docente) { return "No sos docente!"; }
        $username = $docente->nombre . " " . $docente->apellido;
        return view('home', ['nombre' => $username]);
    }
}
