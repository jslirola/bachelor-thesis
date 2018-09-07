<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Auth;

class Usuario extends Model implements AuthenticatableContract
{
	use Authenticatable;

    protected $table = 'usuario';
    protected $primaryKey = 'idUsuario';
    public $timestamps = false;

    protected $fillable = array('dniUsuario', 'hashUsuario');

	public function getAuthPassword()
	{
	    return $this->hashUsuario;
	}
    
    public function roles() 
    {
        $roles = explode(env("ROL_SEPARADOR"), $this->rolUsuario);
    	return $roles;
    }

    public function hasRolBackend()
    {
        $backend = array(env("ROL_ADM_CENTRO"), env("ROL_COORDINADOR"), env("ROL_TUTOR"));
        return (count(array_intersect($backend, $this->roles())) || $this->hasRolGeneral()) && !in_array(env("ROL_ALUMNO"), $this->roles());
    }

    public function hasRolGeneral()
    {
        return in_array(env("ROL_ADM_GRAL"), $this->roles()) && Auth::user()->idUsuario == 1;
    }

    public function hasRolAdmCentro()
    {
        return in_array(env("ROL_ADM_CENTRO"), $this->roles()) && !in_array(env("ROL_ALUMNO"), $this->roles());
    }

    public function hasRolCoordinador()
    {
        return in_array(env("ROL_COORDINADOR"), $this->roles()) && !in_array(env("ROL_ALUMNO"), $this->roles());
    }


    public function hasRolTutor()
    {
        return in_array(env("ROL_TUTOR"), $this->roles()) && !in_array(env("ROL_ALUMNO"), $this->roles());
    }

    public function hasRolAlumno()
    {
        return in_array(env("ROL_ALUMNO"), $this->roles());
    }

    public static function getCenter($id) {
        return Administra::where("idAdmCentro", "=", $id)->first()->idCentro;
    }

    public function getStudiesTaught() {
        return Imparte::where(["anyo" => Config::getCurrentYear(), "idTutor" => $this->idUsuario])->get();
    }

    public function getStudiesManaged() {
        return Coordina::where(["anyo" => Config::getCurrentYear(), "idCoordTitulacion" => $this->idUsuario])->get();
    }

    public function getCentersManaged() {
        return Administra::where(["anyo" => Config::getCurrentYear(), "idAdmCentro" => $this->idUsuario])->get();
    }

    public function getFullName() {
        return $this->nombreUsuario . " " . $this->apellidosUsuario;
    }   

    public static function getStudentProject($user) {
        $study_tmp = Matricula::where(['anyo' =>  Config::getCurrentYear(),  'idAlumno' => $user]);
        $study = $study_tmp->count() > 0 ? $study_tmp->first()->study->getFullName() : __('messages.error_unassigned_study');
        $hasProject = Asigna::hasProject(Config::getCurrentYear(), $user);
        $project_id = $hasProject ? Asigna::where(['anyo' => Config::getCurrentYear(), 'idAlumno' => $user])->get()[0]->idTrabajo : 0;
        return $hasProject ? Trabajo::find($project_id)->tituloTrabajo : __('messages.error_unassigned_project');        
    }
    /*public function getRol()
    {
        $array = preg_replace("/G/", "Administrador General", $roles);
        $array = preg_replace("/A/", "Administrador de Centro", $array);
        $array = preg_replace("/E/", "Alumno", $array);
        $array = preg_replace("/C/", "Coordinador de Centro", $array);
        $array = preg_replace("/T/", "Tutor", $array);
        return count($this->roles()) > 1 ? implode(", ", $this->roles()) : $this->roles()[0];
    }*/

}
