<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asiento;
use Dompdf\Dompdf;
use Dompdf\Options;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class ReportIngGastController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:reporting')->only('reporting','storeing');
        $this->middleware('can:reportgast')->only('reportgast','storegast');
    }

    public function reporting(){
       return view('reportinggast.income.index') ;
    }

    public function storeing(Request $request){
        $this->validate($request, [
            'fechaDesde' => 'required',
            'fechaHasta' => 'required',
        ], [
            'fechaDesde.required' => 'La fecha desde es requerida.',
            'fechaHasta.required' => 'La fecha Hasta es requerida.',
        ]);  
        $income = Asiento::select(
            'asientos.idasi',
            'asientos.fec_asi',
            'asientos.descripcion',
            DB::raw('CASE WHEN cat_cuentas1.idcta = catg_sub_cuentas1.idcta THEN catg_sub_cuentas1.tipsubcta ELSE NULL END AS tipsubcta1'),
            DB::raw('CASE WHEN cat_cuentas2.idcta = catg_sub_cuentas2.idcta THEN catg_sub_cuentas2.tipsubcta ELSE NULL END AS tipsubcta2'),
            DB::raw('CASE WHEN cat_cuentas2.cta1 BETWEEN 4 AND 4 THEN 0 ELSE asientos.monto_deb END AS monto_deb'),
            DB::raw('CASE WHEN cat_cuentas1.cta1 BETWEEN 4 AND 4 THEN 0 ELSE asientos.monto_hab END AS monto_hab')
        )
        ->join('cat_cuentas as cat_cuentas1', 'asientos.idcta1', '=', 'cat_cuentas1.idcta')
        ->join('cat_cuentas as cat_cuentas2', 'asientos.idcta2', '=', 'cat_cuentas2.idcta')
        ->leftJoin('catg_sub_cuentas as catg_sub_cuentas1', 'cat_cuentas1.idcta', '=', 'catg_sub_cuentas1.idcta')
        ->leftJoin('catg_sub_cuentas as catg_sub_cuentas2', 'cat_cuentas2.idcta', '=', 'catg_sub_cuentas2.idcta')
        ->where(function ($query) {
            $query->whereBetween('cat_cuentas1.cta1', [4, 4])
                ->orWhereBetween('cat_cuentas2.cta1', [4, 4]);
        })
        ->get();

        $fecini = $request->get('fechaDesde');
        
        $fecini = Carbon::createFromFormat('Y-m-d', $fecini)->format('Y-m-d');
       
        $fecfin = $request->get('fechaHasta');
        $fecfin = Carbon::createFromFormat('Y-m-d', $fecfin)->format('Y-m-d');
        /* $fecfin = Carbon::createFromFormat('YYYY-MM-DD', $fecfin)->format('Y-m-d'); */
       

        $sysdate = Carbon::now()->format('Y-m-d');
        $user = Auth::user();
        $imagePath = storage_path("img/logo.png");
        $image = base64_encode(file_get_contents($imagePath));

        
        $options = new Options();
        $options->set('isRemoteEnabled', true); // Permite cargar imágenes desde URL
        $options->set('defaultFont', 'Arial'); // Fuente predeterminada
        $options->set('orientation', 'landscape'); // Orientación horizontal
        $options->set('size', 'letter'); // Tamaño de página: carta (letter)

        $dompdf = new Dompdf($options);

        $view = view('reportinggast.income.report',compact('fecini','fecfin','user','image','income'))->render();
        $dompdf->loadHtml($view);
        $dompdf->render();

        return $dompdf->stream("Reporte_ingresos_". $sysdate .".pdf");
    }

    public function reportgast(){
        return view('reportinggast.expenses.index');
    }

    public function storegast(Request $request){
        $this->validate($request, [
            'fechaDesde' => 'required',
            'fechaHasta' => 'required',
        ], [
            'fechaDesde.required' => 'La fecha desde es requerida.',
            'fechaHasta.required' => 'La fecha Hasta es requerida.',
        ]);  
        $expenses = Asiento::select(
            'asientos.idasi',
            'asientos.fec_asi',
            'asientos.descripcion',
            DB::raw('CASE WHEN cat_cuentas1.idcta = catg_sub_cuentas1.idcta THEN catg_sub_cuentas1.tipsubcta ELSE NULL END AS tipsubcta1'),
            DB::raw('CASE WHEN cat_cuentas2.idcta = catg_sub_cuentas2.idcta THEN catg_sub_cuentas2.tipsubcta ELSE NULL END AS tipsubcta2'),
            DB::raw('CASE WHEN cat_cuentas2.cta1 BETWEEN 6 AND 6 THEN 0 ELSE asientos.monto_deb END AS monto_deb'),
            DB::raw('CASE WHEN cat_cuentas1.cta1 BETWEEN 6 AND 6 THEN 0 ELSE asientos.monto_hab END AS monto_hab')
        )
        ->join('cat_cuentas as cat_cuentas1', 'asientos.idcta1', '=', 'cat_cuentas1.idcta')
        ->join('cat_cuentas as cat_cuentas2', 'asientos.idcta2', '=', 'cat_cuentas2.idcta')
        ->leftJoin('catg_sub_cuentas as catg_sub_cuentas1', 'cat_cuentas1.idcta', '=', 'catg_sub_cuentas1.idcta')
        ->leftJoin('catg_sub_cuentas as catg_sub_cuentas2', 'cat_cuentas2.idcta', '=', 'catg_sub_cuentas2.idcta')
        ->where(function ($query) {
            $query->whereBetween('cat_cuentas1.cta1', [6, 6])
                ->orWhereBetween('cat_cuentas2.cta1', [6, 6]);
        })
        ->get();

        $fecini = $request->get('fechaDesde');
        
        $fecini = Carbon::createFromFormat('Y-m-d', $fecini)->format('Y-m-d');
       
        $fecfin = $request->get('fechaHasta');
        $fecfin = Carbon::createFromFormat('Y-m-d', $fecfin)->format('Y-m-d');
        /* $fecfin = Carbon::createFromFormat('YYYY-MM-DD', $fecfin)->format('Y-m-d'); */
       

        $sysdate = Carbon::now()->format('Y-m-d');
        $user = Auth::user();
        $imagePath = storage_path("img/logo.png");
        $image = base64_encode(file_get_contents($imagePath));

        
        $options = new Options();
        $options->set('isRemoteEnabled', true); // Permite cargar imágenes desde URL
        $options->set('defaultFont', 'Arial'); // Fuente predeterminada
        $options->set('orientation', 'landscape'); // Orientación horizontal
        $options->set('size', 'letter'); // Tamaño de página: carta (letter)

        $dompdf = new Dompdf($options);

        $view = view('reportinggast.expenses.report',compact('fecini','fecfin','user','image','expenses'))->render();
        $dompdf->loadHtml($view);
        $dompdf->render();

        return $dompdf->stream("Reporte_Egresos_". $sysdate .".pdf");
    }
}
