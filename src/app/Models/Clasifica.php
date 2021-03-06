<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clasifica extends Model
{
    protected $table = 'clasifica';
    protected $primaryKey = ['idTrabajo', 'idTitulacion', 'idTema'];
    public $incrementing = false;    
    public $timestamps = false;

    public function study() {
    	return $this->belongsTo("App\Models\Titulacion", "idTitulacion", "idTitulacion");
    }

    public function topic() {
    	return $this->belongsTo("App\Models\Tema", "idTema", "idTema");
    }    

}
