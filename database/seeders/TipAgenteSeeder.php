<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoAgente;

class TipAgenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return 'V'oid
     */
    public function run()
       /*  $data = [ 
            array('concepto' => 'HONORARIOS PROFESIONALES',				      'porcentajereten' =>                                  'V'),
            array('concepto' => 'HONORARIOS PROFESIONALES',	                  'porcentajereten' =>  '3%'	'750,00'	    '22,50'	        'V'
            array('concepto' => 'PREPARADORES DE ANIMALES',	                  'porcentajereten' =>  '3%'	'750,00'	    '22,50'	        'V'
            array('concepto' => 'HONORARIOS PROF. EN CLINICAS',	              'porcentajereten' =>  '3%'	'750,00'	    '22,50'	        'V'
            array('concepto' => 'COMISIONES ENAJENACIÓN INMUEBLES',	          'porcentajereten' =>  '3%'	'750,00'	    '22,50'	        'V'
            array('concepto' => 'COMISIONES MERCANTILES',	                  'porcentajereten' =>      '3%'	'750,00'	    '22,50'	        'V'
            array('concepto' => 'INTERESES ART N° 27 # 2 L.1.S.R.',			  'porcentajereten' =>  	                            'V'
            array('concepto' => 'INTERESES ART N° 53 PAR 1°',				  'porcentajereten' =>                                      'V'
            array('concepto' => 'INTERESES',	                              'porcentajereten' =>      '3%'	'750,00'	    '22,50'	        'V'
            array('concepto' => 'AGENCIAS DE NOTICIAS INTERNACIONAL',		  'porcentajereten' =>	    	                            'V'
            array('concepto' => 'FLETES Y GTOS DE TRANSP.INTERNAC.',		  'porcentajereten' =>	    	                            'V'
            array('concepto' => 'FLETES EN EL PAIS A EMP. INTERNAC.',		  'porcentajereten' =>	    	                            'V'
            array('concepto' => 'EXHIBICIÓN DE PELÍCULAS ART 27 # 15',		  'porcentajereten' =>  		                        'V'
            array('concepto' => 'REGALIAS ART 27 # 16',				          'porcentajereten' =>                                  'V'
            array('concepto' => 'ASISTENCIA TECNICA ART 27 # 16',			  'porcentajereten' =>	                                    'V'
            array('concepto' => 'SERVICIOS TECNOLÓGICOS ART 27 # 16',         'porcentajereten' =>                                    'V'
            array('concepto' => 'PRIMAS DE SEGURO-REASEG. ART27 #18',         'porcentajereten' =>                                    'V'
            array('concepto' => 'GANANCIAS S/JUEGOS Y APUESTAS',	          'porcentajereten' =>      '34%'	'TODO PAGO'		            'V'
            array('concepto' => 'PREMIOS LOT. E HIP. ART 65 Y 66',	          'porcentajereten' =>  '16%'	'TODO PAGO'		            'V'
            array('concepto' => 'PREMIOS DE ANIMALES DE CARRERA',	          'porcentajereten' =>      '3%'	'750,00'	    '1,00'	        'V'
            array('concepto' => 'SERVICIOS(lncluyendo suministro de bienes)', 'porcentajereten' =>	    '1%'	'750,00'	    '7,50'	        'V'
            array('concepto' => 'ARRENDAMIENTO BIENES INMUEBLES',	          'porcentajereten' =>      '3%'	'750,00'	    '22,50'	        'V'
            array('concepto' => 'ARRENDAMIENTO BIENES MUEBLES',	              'porcentajereten' =>  '3%'	'750,00'	    '22,50'	        'V'
            array('concepto' => 'PAGOS DE TARJETAS DE CRÉDITO',	              'porcentajereten' =>  '3%'	'TODO PAGO'		            'V'
            array('concepto' => 'VENTA DE GASOLINA CON T. DE CREDITO',	      'porcentajereten' =>  '1%'	'TODO PAGO'	                'V'
            array('concepto' => 'FLETES Y GTOS DE TRANSP.NACIONAL',	          'porcentajereten' =>  '1%'	'750,00'	    '7,50	        'V'
            array('concepto' => 'PAGO DE EMP.DE SEGURO A CORREDORES	',        'porcentajereten' =>    '3%'	'750,00'	    '22,50'	        'V'
            array('concepto' => 'PAGO REP. BIENES Y ATENC. HOSP ASEG.',	      'porcentajereten' =>  '3%'	'750,00'	    '22,50'	        'V'
            array('concepto' => 'VENTA DE FONDOS DE COMERCIO',	              'porcentajereten' =>  '3%'	'750,00'	    '22,50'	        'V'
            array('concepto' => 'PUBLICIDAD Y PROPAGANDA',	                  'porcentajereten' =>  '3%'	'750,00'	    '22,50'	        'V'       
            array('concepto' => 'PUBLICIDAD Y PROPAGANDA RADIO',			  'porcentajereten' =>	                                    'V'       
            array('concepto' => 'VENTA DE ACCIONES EN BOLSA',	              'porcentajereten' =>      '1%'	'TODO PAGO'		            'V'
            array('concepto' => 'VENTA DE ACCIONES FUERA DE BOLSA',	          'porcentajereten' =>  '3%'	'750,00'	    '22,50'	        'V'
            array('concepto' => 'HONORARIOS PROFESIONALES',				      'porcentajereten' =>                                  'J'       
            array('concepto' => 'HONORARIOS PROFESIONALES',	                  'porcentajereten' =>  '5%'	0	        '0,00'	        'J'       
            array('concepto' => 'PREPARADORES DE ANIMALES',				      'porcentajereten' =>                                  'J'
            array('concepto' => 'HONORARIOS PROF. EN CLINICAS',				  'porcentajereten' =>                                  'J'
            array('concepto' => 'COMISIONES ENAJENACIÓN INMUEBLES',	          'porcentajereten' =>  '5%'	0	        '0,00'	        'J'
            array('concepto' => 'COMISIONES MERCANTILES',	                  'porcentajereten' =>      '5%'	0	        '0,00'	        'J'       
            array('concepto' => 'INTERESES ART N° 27 # 2 L.1.S.R.',			  'porcentajereten' =>  	                            'J'       
            array('concepto' => 'INTERESES ART N° 53 PAR 1°',				  'porcentajereten' =>                                      'J'
            array('concepto' => 'INTERESES',	                              'porcentajereten' =>      '5%'	0	        '0,00'	        'J'
            array('concepto' => 'AGENCIAS DE NOTICIAS INTERNACIONAL',		  'porcentajereten' =>	    	                            'J'
            array('concepto' => 'FLETES Y GTOS DE TRANSP.INTERNAC.',		  'porcentajereten' =>	    	                            'J'
            array('concepto' => 'FLETES EN EL PAIS A EMP. INTERNAC.',		  'porcentajereten' =>	    	                            'J'
            array('concepto' => 'EXHIBICIÓN DE PELÍCULAS ART 27 # 15',		  'porcentajereten' =>  		                        'J'
            array('concepto' => 'REGALIAS ART 27 # 16',				          'porcentajereten' =>                                  'J'       
            array('concepto' => 'ASISTENCIA TECNICA ART 27 # 16',			  'porcentajereten' =>	                                    'J'       
            array('concepto' => 'SERVICIOS TECNOLÓGICOS ART 27 # 16',		  'porcentajereten' =>	    	                            'J'
            array('concepto' => 'PRIMAS DE SEGURO-REASEG. ART27 #18',		  'porcentajereten' =>	    	                            'J'
            array('concepto' => 'GANANCIAS S/JUEGOS Y APUESTAS',	          'porcentajereten' =>      '34%'	'TODO PAGO'		            'J'
            array('concepto' => 'PREMIOS LOT. E HIP. ART 65 Y 66',	          'porcentajereten' =>  '16%'	'TODO PAGO'		            'J'
            array('concepto' => 'PREMIOS DE ANIMALES DE CARRERA	',            'porcentajereten' =>    '5%'	0	        '0,00'	        'J'       
            array('concepto' => 'SERVICIOS(lncluyendo suministro de bienes)', 'porcentajereten' =>	    '2%'	0	        '0,00'            'J'
            array('concepto' => 'ARRENDAMIENTO BIENES INMUEBLES',	          'porcentajereten' =>      '5%'	0	        '0,00'	        'J'
            array('concepto' => 'ARRENDAMIENTO BIENES MUEBLES',	              'porcentajereten' =>  '5%'	0	        '0,00'	        'J'
            array('concepto' => 'PAGOS DE TARJETAS DE CRÉDITO',	              'porcentajereten' =>  '5%'	'TODO PAGO'		            'J'
            array('concepto' => 'VENTA DE GASOLINA CON T. DE CREDITO',	      'porcentajereten' =>  '1%'	'TODO PAGO'	                'J'
            array('concepto' => 'FLETES Y GTOS DE TRANSP.NACIONAL',	          'porcentajereten' =>  '3%'	0	        '0,00'	        'J'
            array('concepto' => 'PAGO DE EMP.DE SEGURO A CORREDORES',	      'porcentajereten' =>      '5%'	0	        '0,00'	        'J'
            array('concepto' => 'PAGO REP. BIENES Y ATENC. HOSP ASEG.',	      'porcentajereten' =>  '5%'	0	        '0,00'	        'J'
            array('concepto' => 'VENTA DE FONDOS DE COMERCIO',	              'porcentajereten' =>  '5%'	0	        '0,00'	        'J'
            array('concepto' => 'PUBLICIDAD Y PROPAGANDA',	                  'porcentajereten' =>  '5%'	0	        '0,00'	        'J'
            array('concepto' => 'PUBLICIDAD Y PROPAGANDA RADIO',	          'porcentajereten' =>      '3%'	'TODO PAGO'		            'J'
            array('concepto' => 'VENTA DE ACCIONES EN BOLSA',	              'porcentajereten' =>      '1%'	'TODO PAGO'		            'J'
            array('concepto' => 'VENTA DE ACCIONES FUERA DE BOLSA',	          'porcentajereten' =>  '5%'	0	        '0,00'	        'J'
       */
            ),
        ]
    }
}
