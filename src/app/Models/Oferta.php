<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    protected $table = 'oferta';
    protected $primaryKey = ['idTitulacion', 'idCentro'];
    public $incrementing = false;    
    public $timestamps = false;

    public static function isDuplicated($study, $center) {
    	return (Oferta::where(['idTitulacion' => $study, 'idCentro' => $center])->count() > 0);
    }

    public static function getCenterByStudy($study) {
        return Oferta::where(['idTitulacion' => $study])->groupBy('idCentro');
    }

    public function study() {
    	return $this->belongsTo("App\Models\Titulacion", "idTitulacion", "idTitulacion");
    }

}
