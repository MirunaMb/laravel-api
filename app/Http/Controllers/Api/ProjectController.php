<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project; //importo il modello 

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
        $project = Project::with('technologies:id,name_technologies','type:id,name,color')->where('id',$id)->first(); 

        $project->cover_image = $project->getAbsUriImage();

        return response()->json($project);
    }

   

  
}
