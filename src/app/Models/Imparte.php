<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imparte extends Model
{
    protected $table = 'imparte';
    protected $primaryKey = ['anyo', 'idTitulacion', 'idTutor'];
    public $incrementing = false;    
    public $timestamps = false;

    public function study() {
    	return $this->belongsTo("App\Models\Titulacion", "idTitulacion", "idTitulacion");
    }

    public function user() {
        return $this->belongsTo("App\Models\Usuario", "idTutor", "idUsuario");
    }

    public static function isAllowed($anyo, $study, $tutor) {
    	return (Imparte::where(['anyo' => $anyo, 'idTitulacion' => $study, 'idTutor' => $tutor])->count() > 0);
    }

}
