<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Project; //importo il modello 
use App\Http\Controllers\Api\ProjectController; //importo il controller api  che gestisce questa route
use App\Http\Controllers\Api\TypeController; //importo il controller api  che gestisce questa route
use App\Http\Controllers\Api\TechnologyController; //importo il controller api  che gestisce questa route

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

// # PROJECT API
//Questa route mi darra l'indirizzo api con cui faro la richiesta ad axios
Route:: apiResource("projects", ProjectController::class)->only(["index","show"]);
//rotta che porta a '/project-by-type/{type_id},chi la gestisce ?come la chiamiamo ?
//questo metodo/rotta va messa nel post controller
Route::get('/project-by-type/{type_id}',[ProjectController::class, 'projectByType']);
Route::get('get-projects-by-filters',[ProjectController::class, 'projectByFilters']);



// # TYPE API
Route::apiResource('type', TypeController::class)->only(['index','show']);


// # TECHNOLOGY API
Route::apiResource('technology', TechnologyController::class)->only(['index']);

