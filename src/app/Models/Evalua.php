<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evalua extends Model
{
    protected $table = 'evalua';
    protected $primaryKey = ['anyo', 'convocatoria', 'numero', 'idTitulacion', 'idAlumno'];
    public $incrementing = false;    
    public $timestamps = false;

    public static function hasScore($anyo, $study, $num) {
    	$score = Evalua::where(["anyo" => $anyo, 'idTitulacion' => $study, 'numero' => $num])->first()->calificacion;
    	return isset($score);
    }

}
