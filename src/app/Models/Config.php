<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'config';
    protected $primaryKey = 'idConfig';
    public $timestamps = false;

    protected $fillable = array('anyo_actual', 'conv_actual', 'fechaIniDefensa', 'fechaFinDefensa');

    public function getFechaIniDefensa() {
    	return Config::parseDatetime($this->fechaIniDefensa, "d/m/Y");
    }

    public function getFechaFinDefensa() {
    	return Config::parseDatetime($this->fechaFinDefensa, "d/m/Y");
    }

    public static function getCurrentYear() {
    	return Config::first()->anyo_actual;
    }

    public static function getCurrentConv() {
        return Config::first()->conv_actual;
    }

    public static function isDefensaAvailable() {
        $conf = Config::first();
        $now = date('Y-m-d');
        //$now=date('Y-m-d', strtotime($now));
        $defIni = Config::parseDatetime($conf->getFechaIniDefensa(), 'Y-m-d');
        $defFin = Config::parseDatetime($conf->getFechaFinDefensa(), 'Y-m-d');
        return ($now >= $defIni) && ($now <= $defFin);
    }

    public static function getConvName($value) {
        $output = "";
        switch ($value) {
            case 0:
                $output = "Diciembre";
                break;
            case 1:
                $output = "Junio";
                break;
            case 2:
                $output = "Septiembre";
                break;
            default:
                $output = "Sin definir";
                break;
        }
        return $output;
    }

    // TODO: Export to Utils
    public static function parseDatetime($date, $format = 'Y-m-d H:i:s') {
        $date = str_replace('/', '-', $date);
        return date($format, strtotime($date));
    }

}
