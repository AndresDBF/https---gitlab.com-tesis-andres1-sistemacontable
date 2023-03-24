<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConceptoFact;

class FacturasController extends Controller
{
    public function createinvoiceing(){
        $conceptoFact = new ConceptoFact();
        $query = ConceptoFact::orderBy('idcfact','desc')
                               ->take(1)
                               ->get();
                               
            $values = count($query);
            if ($values == 0){
                $idcfact = 1;
                
                
            }
            else{
                $idcfact = $query[0]->idcfact+1;
                
            }
            $conceptoFact->idcfact = $idcfact;
        
        return view('invoice/index')
                ->with('idcfact',$idcfact);
    }

    public function storeinvoiceing(){

    }
    
}
