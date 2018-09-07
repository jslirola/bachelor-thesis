<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Titulacion extends Model
{
    protected $table = 'titulacion';
    protected $primaryKey = 'idTitulacion';
    public $timestamps = false;

    public static function isDuplicated($name, $type, $excluded_id = null) {
        if(isset($excluded_id)) {
            return (Titulacion::where(['nombreTitulacion' => $name, 'tipoTitulacion' => $type])->where('idTitulacion','!=',$excluded_id)->count());
        } else
            return (Titulacion::where(['nombreTitulacion' => $name, 'tipoTitulacion' => $type])->count() > 0); 
    }

    public static function getTypeName($type) {
        return $type == 1 ? "Grado" : "Máster";
    }

    public function getFullName() {
        $t = $this->tipoTitulacion == 1 ? "Grado" : "Máster";
        return $t . " en " . $this->nombreTitulacion;
    }

    public static function getStudiesToSelect($filter = null) {
        $output = array();
        $studies = Titulacion::all(); // TODO: Join with oferta to get studies that are offering this year instead all
        foreach ($studies as $study) {
            $output[$study["idTitulacion"]] = $study->getFullName();
        } 
        return $output;
    }

    public function topics() {
        return $this->hasMany("App\Models\Tiene", "idTitulacion", "idTitulacion");
    }

}
