<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dirige extends Model
{
    protected $table = 'dirige';
    protected $primaryKey = ['anyo', 'idTitulacion', 'idTutor', 'idTrabajo'];
    public $incrementing = false;    
    public $timestamps = false;

    public function study() {
    	return $this->belongsTo("App\Models\Titulacion", "idTitulacion", "idTitulacion");
    }

    public function project() {
    	return $this->belongsTo("App\Models\Trabajo", "idTrabajo", "idTrabajo");
    }

    public function user() {
        return $this->belongsTo("App\Models\Usuario", "idTutor", "idUsuario");
    }

    public static function getUsers($study, $project) {
        $data = Dirige::where(["anyo" => Config::getCurrentYear(), "idTitulacion" => $study, "idTrabajo" => $project]);
        $users = " ";
        if ($data->count() > 0) {
            foreach ($data->get() as $u) {
                $users .= $u->user->nombreUsuario . " " . $u->user->apellidosUsuario . ", ";
            }
        }
        return substr($users, 0, -2);
    }

    public static function getNumberProjects($user, $anyo = null) {
        $anyo = isset($anyo) ? $anyo : Config::getCurrentYear();
        return Dirige::where(["anyo" => $anyo, "idTutor" => $user])->count(); // TODO: Change if a project will contains more than one student
    }

    public static function isAllowed($anyo, $study, $tutor, $project) {
        return (Dirige::where(['anyo' => $anyo, 'idTitulacion' => $study, 'idTutor' => $tutor, 'idTrabajo' => $project])->count() > 0);
    }

}
