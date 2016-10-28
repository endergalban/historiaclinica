<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CitasController extends Controller
{
    public function index()
    {
        
        return  view('citas.index');
    }
}
