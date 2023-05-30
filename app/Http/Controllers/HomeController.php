<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\PrimerSlider;
use App\CuartoSlider;
use App\SextoSlider;
use App\OptavoSlider;
use App\NovenoSlider;
use App\Footer;
use App\TypeInsurer;
use App\Package;
use App\BenefitDescription;
use App\Insurer;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getHome(){
        return [
            "primer_slider" => PrimerSlider::all()
        ];
    }
    public function index()
    {
        //return PrimerSlider::all();
        return view('home',[
            "primer_slider" => PrimerSlider::all(),
            "typeInsurer" => TypeInsurer::all(),
            "packages" => Package::all(),
            "cuarto_slider" => CuartoSlider::all(),
            "sexto_slider" => SextoSlider::all(),
            "optavo_slider" => OptavoSlider::all(),
            "noveno_slider" => NovenoSlider::all(),
            "benefitDescriptions" => BenefitDescription::all(),
            "insurers" => Insurer::all(),
            "footer" => Footer::first(),
        ]);
    }
}
