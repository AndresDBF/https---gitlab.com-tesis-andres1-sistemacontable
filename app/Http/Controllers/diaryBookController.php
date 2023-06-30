<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asiento;
use App\Models\CatCuenta;
use App\Models\CatgSubCuenta;
use Dompdf\Dompdf;
use Dompdf\Options;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class diaryBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:diarybook')->only('index','storebook');
    }
    public function index(){
        return view('books.index');
    }
    
    public function storebook(Request $request){
        $this->validate($request, [
            'fechaDesde' => 'required',
            'fechaHasta' => 'required',
        ], [
            'fechaDesde.required' => 'La fecha desde es requerida.',
            'fechaHasta.required' => 'La fecha Hasta es requerida.',
        ]);  

        $fecini = $request->get('fechaDesde');
        
        $fecini = Carbon::createFromFormat('Y-m-d', $fecini)->format('Y-m-d');
       
        $fecfin = $request->get('fechaHasta');
        $fecfin = Carbon::createFromFormat('Y-m-d', $fecfin)->format('Y-m-d');
        /* $fecfin = Carbon::createFromFormat('YYYY-MM-DD', $fecfin)->format('Y-m-d'); */
       

        $sysdate = Carbon::now()->format('Y-m-d');
        $user = Auth::user();
        $nombreUsuario = $user->name;
        $accounts = DB::table('asientos as a')
                    ->join('catg_sub_cuentas as c1', 'a.idcta1', '=', 'c1.idcta')
                    ->join('catg_sub_cuentas as c2', 'a.idcta2', '=', 'c2.idcta')
                    ->select('a.fec_asi', 'c1.tipsubcta as idcta1', 'c2.tipsubcta as idcta2', 'a.monto_deb', 'a.monto_hab', 'a.descripcion')
                    ->get();
        
        $sumdeb = CatCuenta::join('asientos', 'cat_cuentas.idcta','=','asientos.idcta1')
        ->join('catg_sub_cuentas', 'cat_cuentas.idcta', '=', 'catg_sub_cuentas.idcta')
        ->select('asientos.fec_asi','catg_sub_cuentas.tipsubcta','catg_sub_cuentas.descripcion','asientos.monto_deb', 'asientos.monto_hab')
        ->where('asientos.fec_asi','>=',$fecini)//NO AGARRA EL FORMATO
        ->where('asientos.fec_asi','<=',$fecfin)
        ->orderBy('asientos.fec_asi','asc')
        ->sum('asientos.monto_deb');

        $sumhab = CatCuenta::join('asientos', 'cat_cuentas.idcta','=','asientos.idcta1')
        ->join('catg_sub_cuentas', 'cat_cuentas.idcta', '=', 'catg_sub_cuentas.idcta')
        ->select('asientos.fec_asi','catg_sub_cuentas.tipsubcta','catg_sub_cuentas.descripcion','asientos.monto_deb', 'asientos.monto_hab')
        ->where('asientos.fec_asi','>=',$fecini)//NO AGARRA EL FORMATO
        ->where('asientos.fec_asi','<=',$fecfin)
        ->orderBy('asientos.fec_asi','asc')
        ->sum('asientos.monto_hab');     
        
        $imagePath = storage_path("img/logo.png");
        $image = base64_encode(file_get_contents($imagePath));

        
        $options = new Options();
        $options->set('isRemoteEnabled', true); // Permite cargar imágenes desde URL
        $options->set('defaultFont', 'Arial'); // Fuente predeterminada
        $options->set('orientation', 'landscape'); // Orientación horizontal
        $options->set('size', 'letter'); // Tamaño de página: carta (letter)

        $dompdf = new Dompdf($options);

        $view = view('books.diarybook',compact('fecini','fecfin','accounts','sumdeb','sumhab','user','image'))->render();
        $dompdf->loadHtml($view);
        $dompdf->render();

        return $dompdf->stream("Libro_diario_". $sysdate ."pdf");
    }
}
