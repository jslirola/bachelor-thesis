<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tribunal extends Model
{
    protected $table = 'tribunal';
    protected $primaryKey = ['anyo', 'convocatoria', 'numero'];
    public $incrementing = false;    
    public $timestamps = false;

    public static function getRolName($value) {
        $output = "";
        switch ($value) {
            case 1:
                $output = "Presidente";
                break;
            case 2:
                $output = "Secretario";
                break;
            case 3:
                $output = "Vocal";
                break;
            default:
                $output = "Sin definir";
                break;
        }
        return $output;
    }

    public static function getMembers($anyo, $conv, $num) {

        //die('test '.$num);
        $members = Compone::where(['anyo' => $anyo, 'convocatoria' => $conv, 'numero' => $num]);
        $users = " ";
        if ($members->count() > 0) {
            foreach ($members->get() as $u) {
                $users .= $u->user->getFullName() . ", ";
            }
        }
        return strlen($users) > 1 ? substr($users, 0, -2) : null;

    }

}
