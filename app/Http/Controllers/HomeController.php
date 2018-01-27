<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Categoria;
use App\Models\Proyecto;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categoria::with('carrera')->get();
        $carreras = Carrera::all();
        $proyectos = Proyecto::where('carrera_id', Auth::user()->carrera_id)
            ->with('carrera')
            ->with('categoria')
            ->get();

        $data = array(
            'categorias' => $categorias,
            'carreras' => $carreras,
            'proyectos' => $proyectos
        );
        return view('home', compact('data'));
    }
}
