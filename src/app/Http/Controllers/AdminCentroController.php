<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Config;
use App\Models\Administra;
use App\Models\Centro;
use App\Models\Titulacion;
use App\Models\Oferta;
use App\Models\Tema;
use App\Models\Tiene;
use App\Models\Usuario;
use App\Models\Coordina;
use App\Models\CoordTitulacion;
use Auth;

class AdminCentroController extends Controller
{

    /**
     * Get studies view
     */
    public function getstudies(Request $req) {

        $center_id = $req->route('id');
        $anyo = Config::getCurrentYear();
        $admCentro = Auth::user()->idUsuario;

        if(!Administra::isAllowed($anyo, $center_id, $admCentro)) {

            return \Redirect::route('administrator');

        } else {

            $studies = Oferta::where(['idCentro' => $center_id])->get();
            $center = Centro::find($center_id);
            $topics = Tiene::whereIn('idTitulacion', $studies->pluck('idTitulacion')->toArray())->get();

            if($req->isMethod('post') && isset($req->nombreTema) && isset($req->idTitulacion)) {

                    //TODO: Check user has permissions to add topics in this study
                    $tema = new Tema();
                    $tema->titulo = $req->nombreTema;
                    $tema->save();

                    $tiene = new Tiene();
                    $tiene->idTitulacion = $req->idTitulacion;
                    $tiene->idTema = $tema->idTema;
                    $tiene->save();

                    $topics = Tiene::whereIn('idTitulacion', $studies->pluck('idTitulacion')->toArray())->get();

                    return view('back.getstudies', [
                        'studies' => $studies,
                        'id' => $center_id,
                        'center' => $center,
                        'topics' => $topics,
                        'success' => __('messages.ok_new_topic')]);     


            } elseif($req->isMethod('post') && isset($req->idTema) && isset($req->idTitulacion)) {

                    // TODO: Check user has permissions to edit this topic

                    $duplicated = Tiene::where(['idTema' => $req->idTema, 'idTitulacion' => $req->idTitulacion])->count() > 0;

                    if($duplicated)
                        return view('back.getstudies', [
                            'studies' => $studies,
                            'id' => $center_id,
                            'center' => $center,
                            'topics' => $topics,
                            'error' => __('messages.error_assign_topic')]); 

                    $tiene = new Tiene();
                    $tiene->idTitulacion = $req->idTitulacion;
                    $tiene->idTema = $req->idTema;
                    $tiene->save();

                    $topics = Tiene::whereIn('idTitulacion', $studies->pluck('idTitulacion')->toArray())->get();

                    return view('back.getstudies', [
                        'studies' => $studies,
                        'id' => $center_id,
                        'center' => $center,
                        'topics' => $topics,
                        'success' => __('messages.ok_assign_topic')]); 


            } elseif($req->isMethod('post') && isset($req->idTitulacion) && isset($req->nombreTitulacion)) {

                if(Titulacion::isDuplicated($req->nombreTitulacion, $req->tipoTitulacion, $req->idTitulacion)) {

                    return view('back.getstudies', [
                        'studies' => $studies,
                        'id' => $center_id,
                        'center' => $center,
                        'topics' => $topics,
                        'error' => __('messages.error_duplicated_study')]);

                } else {

                    $titulacion = Titulacion::find($req->idTitulacion);
                    $titulacion->nombreTitulacion = $req->nombreTitulacion;
                    $titulacion->tipoTitulacion = $req->tipoTitulacion;
                    $titulacion->save();

                    return view('back.getstudies', [
                        'studies' => $studies,
                        'id' => $center_id,
                        'center' => $center,
                        'topics' => $topics,
                        'success' => __('messages.ok_edit_study_center')]);                    

                }
            
            } elseif($req->isMethod('post') && isset($req->nombreTitulacion)) {

                if(Titulacion::isDuplicated($req->nombreTitulacion, $req->tipoTitulacion)) {

                    return view('back.getstudies', [
                        'studies' => $studies,
                        'id' => $center_id,
                        'center' => $center,
                        'topics' => $topics,
                        'error' => __('messages.error_duplicated_study')]);

                } else {

                    $titulacion = new Titulacion();
                    $titulacion->nombreTitulacion = $req->nombreTitulacion;
                    $titulacion->tipoTitulacion = $req->tipoTitulacion;
                    $titulacion->save();
                    $idTitulacion = $titulacion->idTitulacion;

                    $oferta = new Oferta();
                    $oferta->idTitulacion = $idTitulacion;
                    $oferta->idCentro = $center_id;
                    $oferta->save();

                    $studies = Oferta::where(['idCentro' => $center_id])->get();
                    return view('back.getstudies', [
                        'studies' => $studies,
                        'id' => $center_id,
                        'center' => $center,
                        'topics' => $topics,
                        'success' => __('messages.ok_new_study_center')]);

                }
                
            }

            return view('back.getstudies', ['studies' => $studies, 'id' => $center_id, 'center' => $center, 'topics' => $topics]);

        }

    }

    public function studyadmins(Request $req) {
        if($req->isMethod('post') && isset($req->emailUsuario) && isset($req->dniUsuario) && isset($req->titulacionUsuario)) {
            // TODO: Check is allowed and is not duplicated
            $usuario = new Usuario();
            $usuario->rolUsuario = env("ROL_COORDINADOR") . "|";
            $usuario->nombreUsuario = $req->nombreUsuario;
            $usuario->apellidosUsuario = $req->apellidosUsuario;
            $usuario->emailUsuario = $req->emailUsuario;
            $usuario->telefonoUsuario = $req->telefonoUsuario;
            $usuario->dniUsuario = $req->dniUsuario;
            $usuario->hashUsuario = Hash::make($req->emailUsuario);
            $usuario->fechaRegistro = date('Y-m-d H:i:s');               
            $usuario->save();
            $admin = new CoordTitulacion();
            $admin->idUsuario = $usuario->idUsuario;
            $admin->save();
            $coordina = new Coordina();
            $coordina->anyo = Config::getCurrentYear();
            $coordina->idTitulacion = $req->titulacionUsuario;
            $coordina->idCoordTitulacion = $usuario->idUsuario;
            $coordina->save();
        }
        // TODO: Check is working.. Only users that manage studies of the own center admin
        $own_center = Administra::where(['anyo' => Config::getCurrentYear(), 'idAdmCentro' => Auth::user()->idUsuario])->get()[0];
        $usuarios = Coordina::where(['anyo' => Config::getCurrentYear()])->
        whereIn('idTitulacion', Oferta::where(['idCentro' => $own_center->idCentro])->pluck('idTitulacion')->toArray())->get();
        return view('back.studyadmins', ['users' => $usuarios]);
    }

    public function newstudyadmin(Request $req) {
        $anyo = Config::getCurrentYear();
        $studies_tmp = Administra::where(['anyo' => $anyo, 'idAdmCentro' => Auth::user()->idUsuario])->get();
        $managed_studies = Coordina::where(['anyo' => $anyo])->get();
        $studies = Oferta::
        whereIn('idCentro', $studies_tmp->pluck('idCentro')->toArray())->
        whereNotIn('idTitulacion', $managed_studies->pluck('idTitulacion')->toArray())->get();
        return view('back.newstudyadmin', ['studies' => $studies]);
    }

    /**
     * Edit center view
     */
    public function editcenter(Request $req) {

        $id = $req->route('id');
        $center = Centro::find($id);

        if(!Administra::isAllowed(Config::getCurrentYear(), $id, Auth::user()->idUsuario)) {

            return \Redirect::route('administrator');

        } else {

        	if($req->isMethod('post') && isset($req->nombreCentro)) {

	            if(Centro::isDuplicated($req->nombreCentro, $id)) {

	                return view('back.editcenter', ['id' => $id, 'center' => $center, 'error' => __('messages.error_forbidden_edit_center')]);

	            } else {

	                $centro = Centro::find($id);
	                $centro->nombreCentro = $req->nombreCentro;
	                $centro->direccionCentro = $req->direccionCentro;
	                $centro->telefonoCentro = $req->telefonoCentro;
	                $centro->save();
                    $msg = __('messages.ok_edit_center');
	                return view('back.editcenter', ['id' => $id, 'center' => $center, 'success' => $msg]);

	            }

	        }

            return view('back.editcenter', ['id' => $id, 'center' => $center]);

        }

    }

    public function newstudy(Request $req) {
        $center_id = $req->route('id'); // TODO: Check the center with the user
        return view('ajax.newstudy', ['id' => $center_id]);
    }    

    public function newtopic(Request $req) {
        $center_id = $req->route('id'); // TODO: Check the center with the user
        $studies = Oferta::where(['idCentro' => $center_id])->get();
        $topics = Tiene::whereIn('idTitulacion', $studies->pluck('idTitulacion')->toArray())->get();
        return view('ajax.newtopic', ['id' => $center_id, 'studies' => $studies, 'topics' => $topics]);
    }  


    public function editstudy(Request $req) {
        $center_id = $req->route('id'); // TODO: Check the center with the user
        $study = Titulacion::find($req->route('s_id'));
        return view('ajax.editstudy', ['id' => $center_id, 'study' => $study]);
    }


}
