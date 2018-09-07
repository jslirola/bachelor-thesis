<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Config;
use App\Models\Dirige;
use App\Models\Titulacion;
use App\Models\Matricula;
use Auth;

class GuestController extends Controller
{

    /**
     * Projects view
     */
    public function projects(Request $req) {

        $anyo = Config::getCurrentYear();
        //$tutor = Auth::user()->idUsuario;
        $projects = Dirige::where(["anyo" => Config::getCurrentYear()])->groupBy("anyo","idTitulacion","idTrabajo")->orderBy("idTitulacion","DESC")->get();
        return view('front.projects', ['projects' => $projects]);
        
    }


}
