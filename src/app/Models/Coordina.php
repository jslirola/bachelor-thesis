<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coordina extends Model
{
    protected $table = 'coordina';
    protected $primaryKey = ['anyo', 'idTitulacion'];
    public $incrementing = false;    
    public $timestamps = false;

    public function study() {
    	return $this->belongsTo("App\Models\Titulacion", "idTitulacion", "idTitulacion");
    }

    public function user() {
    	return $this->belongsTo("App\Models\Usuario", "idCoordTitulacion", "idUsuario");
    }

    public static function isAllowed($anyo, $study, $admCoord) {
        return (Coordina::where(['anyo' => $anyo, 'idTitulacion' => $study, 'idCoordTitulacion' => $admCoord])->count() > 0);
    }

}
