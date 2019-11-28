<?php

use Illuminate\Http\Request;
use App\Models\Oferta;
use App\Models\Asigna;
use App\Models\Config;
use App\Models\Dirige;
use App\Models\Imparte;
use App\Models\Matricula;
use App\Models\Compone;
use App\Models\Tribunal;
use App\Models\Trabajo;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/getFreeProjects', function () {
    return response()->json(Trabajo::getFreeProjects()->get(['tituloTrabajo','detalleTrabajo','tipoTrabajo']), 200);
});

Route::post('/getStudiesByCenter', function (Request $request) {

	$output = "";
	if(isset($request->center) && intval($request->center) > 0) {
		$offer = Oferta::where(['idCentro' => $request->center]);
		if($offer->count() > 0) {
		    $output = '<table id="table-small" class="table table-striped table-sm">';
		    $c = 0;
			foreach ($offer->get() as $v) {
				if($c==0) { $output .= '<tr><td>';
				} elseif($c%3==0) { $output .= '</tr><tr><td>';
				} else { $output .= '</td><td>'; }
				$output .= "<strong>".($c+1). ".</strong> ". $v->study->getFullName();
				$c++;
			}
			$output .= '</tr></table>';
		} else {
            $output = "Actualmente no oferta ninguna titulación."; // TODO: Change with messages
        }
	}
    return response()->json(["html" => $output], 200);

})->name('getStudiesByCenter');

Route::post('/getCourtMembers', function (Request $request) {

	$output = "";
	if(isset($request->num) && intval($request->num) > 0) {
		// TODO: Dynamic year and conv?
		$members = Compone::where(['anyo' => Config::getCurrentYear(), 'convocatoria' => Config::getCurrentConv(), 'numero' => $request->num]);
		if($members->count() > 0) {
		    $output = '<table id="table-small" class="table table-striped table-sm">';
		    $c = 0;
			foreach ($members->get() as $key => $v) {
				$output .= '<tr><td>';
				$output .= "<strong>".Tribunal::getRolName($v->rolTribunal). ":</strong> ". $v->user->getFullName();
				$output .= '</td></tr>';

			}
			$output .= '</table>';
		} else {
            $output = "No se encuentran los miembros del tribunal."; // TODO: Change with messages
        }
	}
    return response()->json(["html" => $output], 200);

})->name('getCourtMembers');

Route::post('/getAvailableTutors', function (Request $request) {

	$output = [];
	if(isset($request->student) && Matricula::where(['anyo' => Config::getCurrentYear(), 'idAlumno' => $request->student])->count() > 0) {

		$project_id = Asigna::where(['anyo' => Config::getCurrentYear(), 'idAlumno' => $request->student])->pluck('idTrabajo')->toArray();
		$student_tutors = Dirige::where(['anyo' => Config::getCurrentYear(), 'idTrabajo' => $project_id])->pluck('idTutor')->toArray();
		$tutors = Imparte::where(['anyo' => Config::getCurrentYear()])->whereNotIn('idTutor', $student_tutors)->get(['idTutor']);
		
		foreach ($tutors as $key => $value) {
			$output[$value->idTutor] = $value->user->getFullName();
		}

		return response()->json(["html" => $output], 200);

	}

	return response()->json(["html" => $output], 200);


})->name('getAvailableTutors');