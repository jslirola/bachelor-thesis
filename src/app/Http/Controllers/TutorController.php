<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Tutor;
use App\Models\Trabajo;
use App\Models\Imparte;
use App\Models\Config;
use App\Models\Dirige;
use App\Models\Titulacion;
use App\Models\Usuario;
use App\Models\Matricula;
use App\Models\Asigna;
use App\Models\Clasifica;
use Auth;

class TutorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Projects view
     */
    public function projects(Request $req) {

        $id = $req->route('id');
        $study = Titulacion::find($id)->getFullName();
        $anyo = Config::getCurrentYear();
        $tutor = Auth::user()->idUsuario;
        $projects = Dirige::where(["anyo" => $anyo, "idTitulacion" => $id, "idTutor" => $tutor])->orderBy("idTrabajo","DESC")->get();

        if(!Imparte::isAllowed($anyo, $id, $tutor)) {

            return \Redirect::route('administrator');

        } else {

            if($req->isMethod('post') && isset($req->tituloTrabajo) && !isset($req->temaTrabajo)) {

                // TODO: Check values of fields: tipoTrabajo, propuestaAlumno
                $project = new Trabajo();
                $project->tituloTrabajo = $req->tituloTrabajo;
                $project->detalleTrabajo = $req->detalleTrabajo;
                $project->tipoTrabajo = Titulacion::find($id)->tipoTitulacion;
                $project->estadoTrabajo = 1;
                $project->propuestaAlumno = $req->propuestaAlumno;
                $project->fechaRegistro = date('Y-m-d H:i:s');
                $project->save();

                $manage = new Dirige();
                $manage->anyo = $anyo;
                $manage->idTitulacion = $id;
                $manage->idTutor = $tutor;
                $manage->idTrabajo = $project->idTrabajo;
                $manage->save();

                if(isset($req->idCotutor)) {
                    $manage = new Dirige();
                    $manage->anyo = $anyo;
                    $manage->idTitulacion = $id;
                    $manage->idTutor = $req->idCotutor;
                    $manage->idTrabajo = $project->idTrabajo;
                    $manage->save();
                }
                $projects = Dirige::where(["anyo" => $anyo, "idTitulacion" => $id, "idTutor" => $tutor])->orderBy("idTrabajo","DESC")->get();
                
            } elseif ($req->isMethod('post') && isset($req->temaTrabajo) && isset($req->idTrabajo)) {

                // TODO: Check the topic belongs to the study of project
                if(Clasifica::where(['idTrabajo' => $req->idTrabajo, 'idTitulacion' => $id, 'idTema' => $req->temaTrabajo])->count() == 0) {

                    $topics = new Clasifica();
                    $topics->idTrabajo = $req->idTrabajo;
                    $topics->idTitulacion = $id;
                    $topics->idTema = $req->temaTrabajo;
                    $topics->save();
                    $msg = __('messages.ok_assign_project_topic');
                    return view('back.projects', ['projects' => $projects, 'study' => $study, 'id' => $id, 'success' => $msg]);  

                } else {

                    $msg = __('messages.error_assign_project_topic');
                    return view('back.projects', ['projects' => $projects, 'study' => $study, 'id' => $id, 'error' => $msg]);

                }
              


            } elseif ($req->isMethod('post') && isset($req->idUsuario) && isset($req->idTrabajo)) {

                $project_id = $req->idTrabajo;

                if(!Dirige::isAllowed($anyo, $id, $tutor, $project_id)) {

                    $error = __('messages.error_forbidden_assign_project');
                    return view('back.projects', ['projects' => $projects, 'study' => $study, 'id' => $id, 'error' => $error]);

                } elseif(!Matricula::isAllowed($anyo, $id, $req->idUsuario)) {

                    $error = __('messages.error_forbidden_assign_project2');
                    return view('back.projects', ['projects' => $projects, 'study' => $study, 'id' => $id, 'error' => $error]);

                } elseif(Asigna::hasProject($anyo, $req->idUsuario)) {

                    $error = __('messages.error_forbidden_assign_project3');
                    return view('back.projects', ['projects' => $projects, 'study' => $study, 'id' => $id, 'error' => $error]);

                } else {

                    $num = (Asigna::where(['anyo' => $anyo, 'idTitulacion' => $id])->count()) + 1;
                    $assignment = new Asigna();
                    $assignment->anyo = $anyo;
                    $assignment->idTrabajo = $project_id;
                    $assignment->numero = $num;
                    $assignment->idAlumno = $req->idUsuario;
                    $assignment->idTitulacion = $id;
                    $assignment->save();
                    $msg = __('messages.ok_assign_project');
                    return view('back.projects', ['projects' => $projects, 'study' => $study, 'id' => $id, 'success' => $msg]);

                }
                
            }

            return view('back.projects', ['projects' => $projects, 'study' => $study, 'id' => $id]);

        }

    }

    /**
     * New Project view
     */
    public function newproject(Request $req) {

        $study_id = $req->route('id');
        if(!Imparte::isAllowed(Config::getCurrentYear(), $study_id, Auth::user()->idUsuario)) {

            return \Redirect::route('administrator');

        } else {

            $study = Titulacion::find($study_id)->getFullName();
            $users  = Imparte::where(["anyo" => Config::getCurrentYear(), 'idTitulacion' => $study_id])->where('idTutor', '!=', Auth::user()->idUsuario)->get();
            return view('back.newproject', ['study' => $study, 'id' => $study_id, 'users' => $users]);

        }

    }

    /**
     * Assign Project view
     */
    public function assignproject(Request $req) {

        $id = $req->route('id');
        $project_id = $req->route('project');
        if(!Dirige::isAllowed(Config::getCurrentYear(), $id, Auth::user()->idUsuario, $project_id)) {

            return __('messages.error_forbidden_assign_project');

        } else {

            $project = Trabajo::find($project_id)->tituloTrabajo;
            return view('ajax.assignproject', [
                'students' => $this->getStudentsToSelect("WITHOUT_PROJECT", $id), 
                'id' => $id, 
                'project' => $project,
                'project_id' => $project_id,
            ]);

        }

    }    

    // TODO: Export to Utils
    private function getStudentsToSelect($filter = null, $study = 0) {
        $output = array();
        $anyo = Config::getCurrentYear();
        $students = Matricula::where(["anyo" => $anyo, "idTitulacion" => $study])->get();
        foreach ($students as $s) {
            if(isset($filter) && $filter == "WITHOUT_PROJECT") {
                if(!Asigna::hasProject($anyo, $s["idAlumno"])) 
                    $output[$s["idAlumno"]] = $s->user->getFullName();
            } else
                $output[$s["idAlumno"]] = $s->user->getFullName();
        } 
        return $output;
    }

}
