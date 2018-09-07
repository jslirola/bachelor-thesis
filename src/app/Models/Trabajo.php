<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    protected $table = 'trabajo';
    protected $primaryKey = 'idTrabajo';
    public $timestamps = false;

    public function assignments() {
    	return $this->hasOne("App\Models\Asigna", "idTrabajo", "idTrabajo"); // TODO: Change if a project has many students
    }

    public function topics() {
        return $this->hasMany("App\Models\Clasifica", "idTrabajo", "idTrabajo");
    }

    public static function getProjectByCourt($anyo, $conv, $num) {
        $assignment =  Asigna::where(['anyo' => $anyo, 'convocatoria' => $conv, 'numero' => $num])->get(['idTrabajo']);
        return Trabajo::find($assignment);
    }

    public static function getStudentByCourt($anyo, $conv, $num) {
        $assignment =  Asigna::where(['anyo' => $anyo, 'convocatoria' => $conv, 'numero' => $num])->get(['idAlumno']);
        return Alumno::find($assignment);
    }    

    public static function getFreeProjects() {
        $assigned = Asigna::where(['anyo' => Config::getCurrentYear()])->pluck('idTrabajo')->toArray();
        return Trabajo::whereNotIn('idTrabajo', $assigned);
    }

}
