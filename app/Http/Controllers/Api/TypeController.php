<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type; //importo il modello di Type

class TypeController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function index(){
        $type = Type::select('id','name','color')->get();
        return response()->json( $type);
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //manca il nome della type 
        //come facciamo a sostiture il nome_type con il type ?
        //mi trovo il type
        $type = Type::select('id','name','color')
         ->where('id', $id)
        ->first();

        if(!$type)
        abort(404,'Category not found');

        return response()->json($type);
    }
    
}
