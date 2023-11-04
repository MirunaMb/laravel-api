<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Project; //importo il modello 
use App\Http\Controllers\Api\ProjectController; //importo il controller api  che gestisce questa route

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
//Questa route mi darra l'indirizzo api con cui faro la richiesta ad axios
Route:: apiResource("projects", ProjectController::class)->only(["index","show"]);