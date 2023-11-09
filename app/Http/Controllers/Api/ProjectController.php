<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project; //importo il modello 
use App\Models\Type; //importo il modello di Type
class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    $projects = Project::select("id","type_id","title","slug")
        ->where('published', 1)
        ->with('technologies:id,name_technologies','type:id,name,color')
        ->paginate(10); 

        foreach ($projects as $project) {
            $project->cover_image = $project->getAbsUriImage();
        }
     
    return response()->json($projects);
}
    

   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::with('technologies:id,name_technologies','type:id,name,color')
        ->where('published', 1)
        ->where('id',$id)
        ->first(); 

        $project->cover_image = $project->getAbsUriImage();
        if(!$project)
        abort(404,'Category not found');

        return response()->json($project);
    }
    
   public function projectByType($type_id){
    //manca il nome della type 
    //come facciamo a sostiture il nome_type con il type ?
    //mi trovo il type
    $type = Type::select('id','name','color')
    ->where('id', $type_id)
    ->first();
    if(!$type)
    abort(404,'Category not found');

    //come lo recupero da dentro il metodo questo parametro ?passandogli come parametro type_id 
    //mi trovo i progetti
    $projects = Project::select("id","type_id","title","slug")
    ->where("type_id", $type_id)  //dobbiamo prendere tutti progetti dove type_id sia uguale a quello che ci arriva dentro l' URL
    ->where('published', 1)
    ->with('technologies:id,name_technologies','type:id,name,color') //quali sono i type e i projects associati ?

    ->orderByDesc('id')
    ->paginate(10);

    //si usa o paginate oppure get ,non entrambi 
    // ->get(); si usa per chiudere la querry ,quanti risultati producera questa querry ?Tanti, quindi usiamo get ,che ci dara una collection
    foreach ($projects as $project) {
        $project->cover_image = $project->getAbsUriImage();
    }
 
    return response()->json([
        'type'=> $type,
        'projects'=> $projects
    ]);

   }
}
