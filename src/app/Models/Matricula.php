<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $table = 'matricula';
    protected $primaryKey = ['anyo', 'idTitulacion', 'idAlumno'];
    public $incrementing = false;    
    public $timestamps = false;

    public function study() {
    	return $this->belongsTo("App\Models\Titulacion", "idTitulacion", "idTitulacion");
    }

    public function user() {
    	return $this->belongsTo("App\Models\Usuario", "idAlumno", "idUsuario");
    }

    public static function isAllowed($anyo, $study, $student) {
        return (Matricula::where(['anyo' => $anyo, 'idTitulacion' => $study, 'idAlumno' => $student])->count() == 1);
    }

}
