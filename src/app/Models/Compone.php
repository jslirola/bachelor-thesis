<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compone extends Model
{
    protected $table = 'compone';
    protected $primaryKey = ['idTutor', 'idTitulacion', 'anyo', 'convocatoria', 'numero', 'rolTribunal'];
    public $incrementing = false;    
    public $timestamps = false;

    public function user() {
        return $this->belongsTo("App\Models\Usuario", "idTutor", "idUsuario");
    }

}
