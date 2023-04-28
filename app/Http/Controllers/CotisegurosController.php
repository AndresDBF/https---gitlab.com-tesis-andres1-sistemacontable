<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CotisegurosController extends Controller
{
    public function index(){
        return view("cotizador");
    }
}
