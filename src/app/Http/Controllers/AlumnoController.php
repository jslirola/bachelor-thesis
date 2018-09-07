<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\Matricula;
use App\Models\Asigna;
use App\Models\Trabajo;
use App\Models\Dirige;
use App\Models\Evalua;
use App\Models\Tribunal;
use App\Models\Compone;
use Auth;

class AlumnoController extends Controller
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
     * Profile view
     */
    public function dashboard(Request $req) {

        if (Auth::user()->hasRolGeneral()) {
            return \Redirect::route('administrator');
        }

        $user = Auth::user()->idUsuario;
    	$study_tmp = Matricula::where(['anyo' =>  Config::getCurrentYear(),  'idAlumno' => $user]);
    	$study = $study_tmp->count() > 0 ? $study_tmp->first()->study->getFullName() : __('messages.error_unassigned_study');
        $hasProject = Asigna::hasProject(Config::getCurrentYear(), $user);
        $project_id = $hasProject ? Asigna::where(['anyo' => Config::getCurrentYear(), 'idAlumno' => $user])->get()[0]->idTrabajo : 0;
        $tutor = $hasProject ? Dirige::where(['anyo' => Config::getCurrentYear(), 'idTrabajo' => $project_id])->get()[0]->getUsers($study_tmp->first()->idTitulacion, $project_id) : __('messages.error_unassigned_tutor');
        $project = $hasProject ? Trabajo::find($project_id)->tituloTrabajo : __('messages.error_unassigned_project');
        return view('front.dashboard', ['study' => $study, 'project' => $project, 'tutor' => $tutor]);
    }

    /**
     * My project view
     */
    public function project(Request $req) {
        $user = Auth::user()->idUsuario;
        $anyo = Config::getCurrentYear();
        $hasProject = Asigna::hasProject($anyo, $user);
        $hasDefense = Asigna::hasProjectDefense($anyo, Config::getCurrentConv(), $user);

        if(!$hasProject) { 

            return \Redirect::route('index');

        } elseif($req->isMethod('post') && isset($req->requestProjectDefense)) {

            if($hasDefense)
                return \Redirect::route('index');

            $assignment = Asigna::where(['anyo' => $anyo, 'idAlumno' => $user])->update(['defensa' => 1, 'convocatoria' => Config::getCurrentConv()]);
            $hasDefense = Asigna::hasProjectDefense($anyo, Config::getCurrentConv(), $user);

        }

        $study_tmp = Matricula::where(['anyo' =>  $anyo,  'idAlumno' => $user]);
        $project_id = $hasProject ? Asigna::where(['anyo' => $anyo, 'idAlumno' => $user])->get()[0]->idTrabajo : 0;
        $tutor = $hasProject ? Dirige::where(['anyo' => $anyo, 'idTrabajo' => $project_id])->get()[0]->getUsers($study_tmp->first()->idTitulacion, $project_id) 
                             : __('messages.error_unassigned_tutor');
        $project = $hasProject ? Trabajo::find($project_id) : __('messages.error_unassigned_project');
        $score = $hasProject && Evalua::where(['anyo' => $anyo, 'idAlumno' => $user])->count() > 0? Evalua::where(['anyo' => $anyo, 'idAlumno' => $user])->get()[0] : null;
        $court = isset($score->idAlumno) ? Tribunal::getMembers($anyo, $score->convocatoria, $score->numero) : null;
        return view('front.project', ['project' => $project, 'tutor' => $tutor, 'hasDefense' => $hasDefense, 'score' => $score, 'court' => $court]);

    }

}
