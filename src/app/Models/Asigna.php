<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asigna extends Model
{
    protected $table = 'asigna';
    protected $primaryKey = ['anyo', 'idTrabajo'];
    public $incrementing = false;    
    public $timestamps = false;

    public static function hasProject($anyo, $student) {
        return (Asigna::where(['anyo' => $anyo, 'idAlumno' => $student])->count() > 0);
    }

    public static function hasProjectDefense($anyo, $conv, $student) {
        return (Asigna::where(['anyo' => $anyo, 'convocatoria' => $conv, 'defensa' => 1, 'idAlumno' => $student])->count() > 0);
    }

    public static function isAssigned($project) {
        return (Asigna::where(['anyo' => \App\Models\Config::getCurrentYear(), 'idTrabajo' => $project])->count() > 0);
    }

    public function project() {
    	return $this->belongsTo("App\Models\Trabajo", "idTrabajo", "idTrabajo");
    }

    public function user() {
    	return $this->belongsTo("App\Models\Usuario", "idAlumno", "idUsuario");
    }

}
