<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Config;
use App\Models\Titulacion;
use App\Models\Matricula;
use App\Models\Coordina;
use App\Models\Imparte;
use App\Models\Compone;
use App\Models\Asigna;
use App\Models\Oferta;
use App\Models\Departamento;
use App\Models\Usuario;
use App\Models\Tutor;
use App\Models\Evalua;
use App\Models\Alumno;
use App\Models\Tribunal;
use Auth;

class CoordinadorController extends Controller
{

    /**
     * Students view
     */
    public function students(Request $req) {

        $anyo = Config::getCurrentYear();
        $coord = Auth::user()->idUsuario;
        $study_id = $req->route('id');

        if(!Coordina::isAllowed($anyo, $study_id, $coord)) {

            return \Redirect::route('administrator');

        } else {

            // TODO: Check duplicated DNI
            if($req->isMethod('post') && isset($req->nombreUsuario)) {

                // TODO: Check required values
                $user = new Usuario();
                $user->rolUsuario = env("ROL_ALUMNO") . "|";
                $user->nombreUsuario = $req->nombreUsuario;
                $user->apellidosUsuario = $req->apellidosUsuario;
                $user->emailUsuario = $req->emailUsuario;
                $user->telefonoUsuario = $req->telefonoUsuario;
                $user->dniUsuario = $req->dniUsuario;
                $user->hashUsuario = bcrypt($req->emailUsuario);
                $user->estadoUsuario = 0;
                $user->remember_token = str_random(100);
                $user->fechaRegistro = date('Y-m-d H:i:s');
                $user->save();

                $student = new Alumno();
                $student->idUsuario = $user->idUsuario;
                $student->expedienteAlumno = 0.0;
                $student->save();

                $course = new Matricula();
                $course->anyo = $anyo;
                $course->idTitulacion = $study_id;
                $course->idAlumno = $user->idUsuario;
                $course->save();
                
            }

        	$study = Titulacion::find($study_id);
	        $students = Matricula::where(["anyo" => Config::getCurrentYear(), 'idTitulacion' => $study_id])->get();
	        return view('back.studystudents', ['study' => $study, 'users' => $students]);

    	}
        
    }


    /**
     * New Student view
     */
    public function newstudent(Request $req) {

        $study_id = $req->route('id');

        if(!Coordina::isAllowed(Config::getCurrentYear(), $study_id, Auth::user()->idUsuario)) {

            return \Redirect::route('administrator');

        } else {

            $study = Titulacion::find($study_id);
            return view('back.newstudent', ['study' => $study, 'id' => $study]);

        }
    }

    /**
     * Tutors view
     */
    public function tutors(Request $req) {

        $anyo = Config::getCurrentYear();
        $coord = Auth::user()->idUsuario;
        $study_id = $req->route('id');

        if(!Coordina::isAllowed($anyo, $study_id, $coord)) {

            return \Redirect::route('administrator');

        } else {

            if($req->isMethod('post') && isset($req->emailUsuario) && isset($req->dniUsuario) && isset($req->departamentoUsuario)) {
                // TODO: Check is allowed and is not duplicated
                $usuario = new Usuario();
                $usuario->rolUsuario = env("ROL_TUTOR") . "|";
                $usuario->nombreUsuario = $req->nombreUsuario;
                $usuario->apellidosUsuario = $req->apellidosUsuario;
                $usuario->emailUsuario = $req->emailUsuario;
                $usuario->telefonoUsuario = $req->telefonoUsuario;
                $usuario->dniUsuario = $req->dniUsuario;
                $usuario->hashUsuario = Hash::make($req->emailUsuario);
                $usuario->fechaRegistro = date('Y-m-d H:i:s');               
                $usuario->save();
                $admin = new Tutor();
                $admin->idUsuario = $usuario->idUsuario;
                $admin->idDepartamento = $req->departamentoUsuario;
                $admin->save();
                $imparte = new Imparte();
                $imparte->anyo = Config::getCurrentYear();
                $imparte->idTutor = $usuario->idUsuario;
                $imparte->idTitulacion = $study_id;
                $imparte->save();                
            }            

        	$study = Titulacion::find($study_id);
	        $tutors = Imparte::where(["anyo" => Config::getCurrentYear(), 'idTitulacion' => $study_id])->get();
	        return view('back.studytutors', ['study' => $study, 'users' => $tutors]);

    	}
        
    }

    /**
     * Courts view
     */
    public function courts(Request $req) {

        $anyo = Config::getCurrentYear();
        $conv = Config::getCurrentConv();
        $coord = Auth::user()->idUsuario;
        $study_id = $req->route('id');

        if(!Coordina::isAllowed($anyo, $study_id, $coord)) {

            return \Redirect::route('administrator');

        } else { // TODO: Check $req->idAlumno is registered this year

            $study = Titulacion::find($study_id);

            if($req->isMethod('post') && isset($req->idAlumno) 
                && isset($req->tutor1) && isset($req->rol1)
                && isset($req->tutor2) && isset($req->rol2)
                && isset($req->tutor3) && isset($req->rol3)) {

                $num = (Compone::where(['idTitulacion' => $study_id, 'anyo' => $anyo, 'convocatoria' => $conv])->count()) + 1;

                $member1 = new Compone();
                $member1->idTutor = $req->tutor1;
                $member1->idTitulacion = $study_id;
                $member1->anyo = $anyo;
                $member1->convocatoria = $conv;
                $member1->numero = $num;
                $member1->rolTribunal = $req->rol1;
                $member1->save();

                $member2 = new Compone();
                $member2->idTutor = $req->tutor2;
                $member2->idTitulacion = $study_id;
                $member2->anyo = $anyo;
                $member2->convocatoria = $conv;
                $member2->numero = $num;
                $member2->rolTribunal = $req->rol2;
                $member2->save();

                $member3 = new Compone();
                $member3->idTutor = $req->tutor3;
                $member3->idTitulacion = $study_id;
                $member3->anyo = $anyo;
                $member3->convocatoria = $conv;
                $member3->numero = $num;
                $member3->rolTribunal = $req->rol3;
                $member3->save();

                $court = new Tribunal();
                $court->anyo = $anyo;
                $court->convocatoria = $conv;
                $court->numero = $num;

                $evaluation = new Evalua();
                $evaluation->anyo = $anyo;
                $evaluation->convocatoria = $conv;
                $evaluation->numero = $num;
                $evaluation->idTitulacion = $study_id;
                $evaluation->idAlumno = $req->idAlumno;
                $evaluation->calificacion = null;
                $evaluation->save();

            } elseif (isset($req->scoreProject) && isset($req->number)) {
                
                $evaluation = Evalua::where(["anyo" => $anyo, 'idTitulacion' => $study_id, 'numero' => $req->number]);
                $courts = Compone::where(["anyo" => Config::getCurrentYear(), 'idTitulacion' => $study_id])->groupBy('numero','convocatoria')->get();

                if(!Coordina::isAllowed($anyo, $study_id, $coord)) {

                    return view('back.studycourts', ['study' => $study, 'users' => $courts, 'error' => __('messages.error_set_score')]);

                } elseif ($evaluation->count() == 0) {

                    return view('back.studycourts', ['study' => $study, 'users' => $courts, 'error' => __('messages.error_set_score2')]);

                } else { // TODO: Check if the project has score

                    //$evaluation->calificacion = $req->scoreProject;
                    $evaluation->update(['calificacion' => $req->scoreProject]);
                    return view('back.studycourts', ['study' => $study, 'users' => $courts, 'success' => __('messages.ok_set_score')]);

                }

            }

	        $courts = Compone::where(["anyo" => Config::getCurrentYear(), 'idTitulacion' => $study_id])->groupBy('numero','convocatoria')->get();
	        return view('back.studycourts', ['study' => $study, 'users' => $courts]);

    	}
        
    }

    /**
     * New court view
     */
    public function newcourt(Request $req) {

        $anyo = Config::getCurrentYear();
        $coord = Auth::user()->idUsuario;
        $study_id = $req->route('id');
        $evaluation = Evalua::where(["anyo" => $anyo, 'idTitulacion' => $study_id, 'convocatoria' => Config::getCurrentConv()])->pluck('idAlumno')->toArray();
        $students = Asigna::where(["anyo" => $anyo, 'idTitulacion' => $study_id, 'defensa' => 1, 'convocatoria' => Config::getCurrentConv()])->
            whereNotIn('idAlumno', $evaluation)->get();


		if(Config::isDefensaAvailable() || !Coordina::isAllowed($anyo, $study_id, $coord)) {

            return \Redirect::route('administrator');

        } elseif ($students->count() == 0) {

            return view('ajax.newcourt', ['id' => $study_id, 'error' => __('messages.error_new_court')]);

        } else {

            $studies = Oferta::whereIn('idCentro', Oferta::getCenterByStudy($study_id)->pluck('idCentro')->toArray());
	        $tutors = Imparte::where(["anyo" => $anyo])->whereIn('idTitulacion', $studies->pluck('idTitulacion')->toArray())->get();
            //var_dump($studies->toSql());
            //var_dump($tutors->toSql());
            //die();
	        return view('ajax.newcourt', ['id' => $study_id, 'tutors' => $tutors, 'students' => $students]);

    	}
    }   

    /**
     * New tutor view
     */
    public function newtutor(Request $req) {
        $study_id = $req->route('id');
        $study = Titulacion::find($study_id);
        $departments = Departamento::all();
        return view('back.newtutor', ['id' => $study_id, 'study' => $study, 'departments' => $departments]);
    }   

    /**
     * Score of court view
     */
    public function setscore(Request $req) {

        $anyo = Config::getCurrentYear();
        $coord = Auth::user()->idUsuario;
        $study_id = $req->route('id');
        $evaluation = Evalua::where(["anyo" => $anyo, 'idTitulacion' => $study_id, 'numero' => $req->num]);

        if(!Coordina::isAllowed($anyo, $study_id, $coord)) {

            return view('ajax.setscore', ['id' => $study_id, 'error' => __('messages.error_set_score')]);

        } elseif ($evaluation->count() == 0) {

            return view('ajax.setscore', ['id' => $study_id, 'error' => __('messages.error_set_score2')]);

        } else { // TODO: Check if the project has score

            $student = $evaluation->get()[0]->idAlumno;
            $conv = $evaluation->get()[0]->convocatoria;
            $project = Asigna::where(['anyo' => $anyo, 'convocatoria' => $conv, 'idAlumno' => $student])->get()[0]->project;
            return view('ajax.setscore', ['id' => $study_id, 'project' => $project, 'number' => $req->num]);

        }

    }

}
