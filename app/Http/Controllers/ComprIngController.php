<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComprIngController extends Controller
{
    public function create(){
        return view("proof.create");
    }
}
