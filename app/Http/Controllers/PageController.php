<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function index()
    {
        if(in_array('4_1',session('access')))
        {
            $page = Page::all();
            return view ('CreatePage',compact('page'));
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
                $page = Page::insert([
                    'name'=>$request->Page,
                    'Active' =>$request->deactivate,
                ]);
            }
            elseif(in_array('4_3',session('access')) && in_array('4_5',session('access')))
            {            
                $page = Page::find($request->id)->update([
                    'name'=>$request->Page,
                    'Active' =>$request ->deactivate,
                ]);
            }

            $pages = Page::all();
            return view('Listpages',compact('pages'));
        }
        else
        {
            return view('unauth');
        }
    }
}
