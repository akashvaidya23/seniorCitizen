<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\relations;

class RelationController extends Controller
{
    public function index()
    {
        if(in_array('4_1',session('access')))
        {
            $relation = relations::all();
            return view('CreateRelation',compact('relation'));
        }
        else
        {
            return view('unauth');
        }
    }

    public function insert(Request $request)
    {
        if(in_array('4_2',session('access')) && in_array('4_5',session('access')))
        {
            if($request->id == '')
            {
                $relation = relations::insert([
                    'type_of_relation'=>$request->relation,
                    'Active'=>$request->deactivate,
                ]);
            }
            elseif(in_array('4_3',session('access')) && in_array('4_5',session('access')))
            {
                $relation = relations::find($request->id)->update([
                    'type_of_relation'=>$request->relation,
                    'Active'=>$request->deactivate,
                ]);
            }       
            $relations = relations::all();
            return view('ListRelations',compact('relations'));
        }
        else
        {
            return view('unauth');
        }
    }
}
