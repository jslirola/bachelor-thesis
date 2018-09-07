<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administra extends Model
{
    protected $table = 'administra';
    protected $primaryKey = ['anyo', 'idAdmCentro'];
    public $incrementing = false;    
    public $timestamps = false;

    public function user() {
    	return $this->belongsTo("App\Models\Usuario", "idAdmCentro", "idUsuario");
    }

    public function center() {
    	return $this->belongsTo("App\Models\Centro", "idCentro", "idCentro");
    }

    public static function isAllowed($anyo, $center, $admCenter) {
        return (Administra::where(['anyo' => $anyo, 'idCentro' => $center, 'idAdmCentro' => $admCenter])->count() > 0);
    }

}
