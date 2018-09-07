<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumno';
    protected $primaryKey = 'idUsuario';
    public $timestamps = false;

    public function user() {
    	return $this->belongsTo("App\Models\Usuario", "idUsuario", "idUsuario");
    }

}
