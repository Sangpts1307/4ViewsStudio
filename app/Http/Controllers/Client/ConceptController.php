<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use Illuminate\Http\Request;

class ConceptController extends Controller
{
    public function home()
    {
        $concepts = Concept::all();
        return view("clients.home", compact("concepts"));
    }

    public function concept()
    {
        $concepts = Concept::all();
        return view("clients.concept", compact("concepts"));
    }

    public function conceptDetail($id)
    {
      
        $concept = Concept::find($id);
        return view('clients.concept-detail', compact('concept'));
    }

    
}
