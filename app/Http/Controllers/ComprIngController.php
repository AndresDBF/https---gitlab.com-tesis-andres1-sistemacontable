<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComprIngController extends Controller
{
    public function searchInvoice(){
        return view("proof.find");
    }

    public function findInvoice(Request $request){

    }
}
