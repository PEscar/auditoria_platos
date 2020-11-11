<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Models\Sede;
use Illuminate\Http\Request;

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
        return view('home', ['sedes' => Sede::all(), 'sectores' => Sector::all()]);
    }
}
