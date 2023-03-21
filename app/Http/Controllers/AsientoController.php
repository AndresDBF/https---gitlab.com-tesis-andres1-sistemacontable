<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AsientoController extends Controller
{
    public function index()
    {
        return view('asientos.index');
    }
}
