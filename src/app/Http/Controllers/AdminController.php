<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\AdmCentro;
use App\Models\Centro;
use App\Models\Oferta;
use App\Models\Titulacion;
use App\Models\Departamento;
use App\Models\Usuario;
use App\Models\Config;
use App\Models\Admnistra;
use App\Models\Matricula;
use App\Models\Imparte;
use App\Models\Coordina;
use App\Models\Administra;

class AdminController extends Controller
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
     * Index view
     */
    public function admin(Request $req) {
        $students = Matricula::where(['anyo' => Config::getCurrentYear()])->count();
        $tutors = Imparte::where(['anyo' => Config::getCurrentYear()])->count();
        $coords = Coordina::where(['anyo' => Config::getCurrentYear()])->count();
        $centeradmins = Administra::where(['anyo' => Config::getCurrentYear()])->count();        
        $students_t = Matricula::all()->count();
        $tutors_t = Imparte::all()->count();
        $coords_t = Coordina::all()->count();
        $centeradmins_t = Administra::all()->count();
        return view('back.index', [
            's' => $students, 
            't' => $tutors, 
            'co' => $coords, 
            'ce' => $centeradmins,
            's_t' => $students, 
            't_t' => $tutors, 
            'co_t' => $coords, 
            'ce_t' => $centeradmins,
        ]);
    }

    /**
     * Config view
     */
    public function config(Request $req) {

        $output = array();
        for ($i=date("Y"); $i > date("Y")-5; $i--) { 
            $output[$i] = $i;
        }
        $conv = [0 => "Diciembre", 1 => "Junio", 2 => "Septiembre"];
        if($req->isMethod('post') && isset($req->anyoConfig)) {
            $config = (Config::count() == 0) ? new Config() : Config::first();
            $config->anyo_actual = $req->anyoConfig;
            $config->conv_actual = $req->convConfig;
            $config->fechaIniDefensa = Config::parseDatetime($req->fechaIniDefensa);
            $config->fechaFinDefensa = Config::parseDatetime($req->fechaFinDefensa);
            $config->save();
            $conf = Config::first();
            return view('back.config', ['anyos' => $output, 'conv' => $conv, 'conf' => $conf, 'success' => __('messages.ok_config_update')]);
        }
        $conf = Config::first();
        return view('back.config', ['anyos' => $output, 'conv' => $conv, 'conf' => $conf]);

    }

    /**
     * Centers view
     */
    public function centers(Request $req) {

        if($req->isMethod('post') && isset($req->nombreCentro)) {

            if(Centro::isDuplicated($req->nombreCentro)) {

                return view('back.newcenter', ['error' => __('messages.error_duplicated_center')]);

            } else {

                $centro = new Centro();
                $centro->nombreCentro = $req->nombreCentro;
                $centro->direccionCentro = $req->direccionCentro;
                $centro->telefonoCentro = $req->telefonoCentro;
                $centro->save();
                $centers = Centro::all();
                return view('back.centers', ['centers' => $centers, 'success' => __('messages.ok_new_center')]);

            }
        }

        $centers = Centro::all();
        return view('back.centers', ['centers' => $centers]);
    }

    /**
     * New center view
     */
    public function newcenter(Request $req) {
        return view('back.newcenter');
    }

    /**
     * New study view
     */
    public function newstudy(Request $req) {

        if ($req->isMethod('post')) {

            if (isset($req->nombreTitulacion)) {

                if(Titulacion::isDuplicated($req->nombreTitulacion, $req->tipoTitulacion)) {

                    return view('back.newstudy', [
                        'centers' => $this->getCentersToSelect(), 
                        'studies' => Titulacion::getStudiesToSelect() , 
                        'error' => __('messages.error_duplicated_study')]);

                } else {

                    $titulacion = new Titulacion();
                    $titulacion->nombreTitulacion = $req->nombreTitulacion;
                    $titulacion->tipoTitulacion = $req->tipoTitulacion;
                    $titulacion->save();
                    $idTitulacion = $titulacion->idTitulacion;

                }

            } elseif (isset($req->asignarTitulacion)) {
                $idTitulacion = $req->asignarTitulacion;
            }

            if (isset($idTitulacion) && isset($req->centroTitulacion)) {

                if(Oferta::isDuplicated($idTitulacion, $req->centroTitulacion)) {

                    return view('back.newstudy', [
                        'centers' => $this->getCentersToSelect(), 
                        'studies' => Titulacion::getStudiesToSelect() , 
                        'error' => __('messages.error_duplicated_offer')]);

                } else {

                    $oferta = new Oferta();
                    $oferta->idTitulacion = $idTitulacion;
                    $oferta->idCentro = $req->centroTitulacion;
                    $oferta->save();
                    $centers = Centro::all();
                    return view('back.centers', ['centers' => $centers]);

                }

            }

        }

        return view('back.newstudy', ['centers' => $this->getCentersToSelect(), 'studies' => Titulacion::getStudiesToSelect()]);
    }

    /**
     * New department view
     */
    public function newdepartment(Request $req) {
        // TODO: Check duplicated
        if($req->isMethod('post') && isset($req->nombreDepartamento)) {
            $dpto = new Departamento();
            $dpto->nombreDepartamento = $req->nombreDepartamento;
            $dpto->webDepartamento = $req->webDepartamento;       
            $dpto->save();
            return view('back.newdepartment', ['users' => $this->getTutorsToSelect(), 'success' => __('messages.ok_new_department')]);
        }
        return view('back.newdepartment', ['users' => $this->getTutorsToSelect()]);
    }

    /**
     * Center admins view
     */
    public function centeradmins(Request $req) {
        if($req->isMethod('post') && isset($req->emailUsuario) && isset($req->dniUsuario)) {
            $usuario = new Usuario();
            $usuario->rolUsuario = env("ROL_ADM_CENTRO") . "|";
            $usuario->nombreUsuario = $req->nombreUsuario;
            $usuario->apellidosUsuario = $req->apellidosUsuario;
            $usuario->emailUsuario = $req->emailUsuario;
            $usuario->telefonoUsuario = $req->telefonoUsuario;
            $usuario->dniUsuario = $req->dniUsuario;
            $usuario->hashUsuario = Hash::make($req->emailUsuario);
            $usuario->fechaRegistro = date('Y-m-d H:i:s');               
            $usuario->save();
            $admin = new AdmCentro();
            $admin->idUsuario = $usuario->idUsuario;
            $admin->save();
            $administra = new Administra();
            $administra->anyo = Config::getCurrentYear();
            $administra->idAdmCentro = $usuario->idUsuario;
            $administra->idCentro = $req->centroUsuario;
            $administra->save();
        }
        $users  = Administra::where(["anyo" => Config::getCurrentYear()])->get();
        return view('back.centeradmins', ['users' => $users]);
    }

    /**
     * New center admin view
     */
    public function newcenteradmin(Request $req) {
        return view('back.newcenteradmin', ['centers' => $this->getCentersToSelect("WITHOUT_ADMIN")]);
    }

    private function getCentersToSelect($filter = null) {
        $output = array();
        $centers = Centro::all();
        foreach ($centers as $center) {
            if(isset($filter) && $filter == "WITHOUT_ADMIN") {
                if(!$center->isManaged()) 
                    $output[$center["idCentro"]] = $center["nombreCentro"];
            } else
                $output[$center["idCentro"]] = $center["nombreCentro"];
        } 
        return $output;
    }

    // TODO: Export to Utils
    private function getTutorsToSelect($filter = null) {
        $output = array();
        $users = Usuario::where("rolUsuario", 'LIKE', "%" . env("ROL_ADM_CENTRO") . "%")->get();
        foreach ($users as $user) {
            $output[$user["idUsuario"]] = $user["nombreUsuario"] . " " . $user["apellidosUsuario"];
        } 
        return $output;
    }

}
