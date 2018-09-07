<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Centro extends Model
{
    protected $table = 'centro';
    protected $primaryKey = 'idCentro';
    public $timestamps = false;

    protected $fillable = array('idCentro', 'nombreCentro');

    public function admin() { // TODO: Check when we have two registers of the same center
    	return $this->hasOne("App\Models\Administra", "idCentro", "idCentro");
    }

    public function isManaged() {
    	return isset($this->admin->user) ? true : false;
    }

    public static function isDuplicated($name, $excluded_id = null) {
        if(isset($excluded_id)) {
            return (Centro::where(['nombreCentro' => $name])->where('idCentro','!=',$excluded_id)->count());
        } else
            return (Centro::where(['nombreCentro' => $name])->count() > 0);
    }


    public function getStudies() {
        return $this->hasMany("App\Models\Oferta", "idCentro", "idCentro")->get();
    }

}
