<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizacion</title>
    <!-- Bootstrap CSS -->
</head>
<body>
    <style>
/* @font-face {
    font-family: "mon-black";
    src: url("https://cotiseguros.com.ve/fonts/Montserrat-Black.ttf");
}

@font-face {
    font-family: "mon-bold";
    src: url("https://cotiseguros.com.ve/fonts/Montserrat-Bold.ttf");
}

@font-face {
    font-family: "mon-light";
    src: url("https://cotiseguros.com.ve/fonts/Montserrat-Light.ttf");
}

@font-face {
    font-family: "mon-medium";
    src: url("https://cotiseguros.com.ve/fonts/Montserrat-Medium.ttf");
}

@font-face {
    font-family: "mon-regular";
    src: url("https://cotiseguros.com.ve/fonts/Montserrat-Regular.ttf");
} */
body {
    font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
}
table {
    box-shadow: 0px 0px 5px 1px black;
    box-shadow: 0px 0px 5px 1px black;
    -webkit-box-shadow: 0px 0px 5px 1px black;
    -moz-box-shadow: 0px 0px 5px 1px black;
    border-radius: 20px !important;
}
table, th, td {
  border: 0px solid black;
  border-collapse: collapse;
  text-align: center ;
  font-size: 9px ;
}

table  tr:nth-child(odd) {
	background: white;
}
table tr:nth-child(even) {
	background: rgb(218,220,224);
}
        .img-lg {
            position: absolute;
            width: 100%;
            left: -200px ;
            bottom: -200px ;
        }
        a {
            color: blue ;
        }

        .title {
            color: rgb(18,42,85) ;
            text-align: center;
            font-size: 32px;
            font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            font-weight: bold;
            margin: 30px 0px ;
        }

        .w-50 {
            position: relative;
            float: left;
            width: 50% ;
        }
        .total {
            font-weight: bold ;
            font-size: 18px ;
        }

        /* p {
            font-size: 8px ;
        }  */
        /* h3 {
            margin: 0px ;
            padding: 0px ;
            font-size: 12px ;
            margin-top: 20px ;
        } */
        .footer {
            position: absolute ;
            left: 0px ;
            top: 960px ;
            width: 100% ;
            height: 15px ;
            z-index: 1000 ;
        }
        .logo-bg {
            position: absolute ;
            
            left: -200px ;
            width: 700px ;
            height: 700px ;
            z-index: -10000;
            opacity: 0.5 ;
            /*
            top: 40% ;
             */
        }
        .footer-img {
            position: absolute ;
           
            width: 120% ;
            bottom: -60px ;
            left: -80px ;
            padding: 10px;
            /*z-index: -100;
            ;
            
            */
        }
        .subtitle {
            font-size: 12px !important;
        }

        .desc {
            font-size: 10px !important;
        }
        .content-time {
            background: rgb(218,220,224) ;
            padding: 10px 0px ;
            padding-right: 3px ;
            width: 100% ;
            font-size: 12px ;
        }
    </style>
    @foreach ($cotizaciones as $cotizacion)
        <img class="logo-bg" src="https://cotiseguros.com.ve/storage/LOGO%20RGB_Icono%20full%20color.png" alt="" srcset="">
        
        <table width="100%">
            <tr>
                <td width="33%">
                    <img width="80%" style="left: 10% ;" src="https://cotiseguros.com.ve/storage/LOGO%20RGB_Color.png" alt="">
                </td>
                <td width="33%">
                    <img width="80%" style="left: 10% ;" src="https://cotiseguros.com.ve/storage/{{ $datos['image'] }}" alt="">
                </td>
                <td width="33%" style="text-align: right ;">
                    <div class="content-time">{{ date("d-m-y") }}</div>
                    <!-- <span style="background: rgb(218,220,224) ;width: 100% ;">
                        <span style="background: red ;width: 100% ;text-align: right ;padding-left: 60px ;font-size: 12px ;margin-top: 130px ;">{{ Carbon\Carbon::parse($cotizacion["created_at"])->format('d-m-y') }}</span> 
                    </span> -->
                </td>
            </tr>
        </table>
        <div class="title">Suma Asegurada:  ${{ number_format($cotizacion["coverage"]) }}</div>
        <!-- -->
        <table width="80%" style="margin:0px ;margin-left: 10% ;">
            <tr>
                <th colspan="2">Beneficio</th>
                <th>Suma</th>
                @foreach($members as $item)
                    <th width="10%">{{ $item["status"] }}<br>{{$item["date"]}} años</th>
                @endforeach
            </tr>
            <tr>
                <th width="15%">HCM</th>
                <th width="100%">El asegurado posee cobertura para hospitalización y cirugía en las clínicas afiliadas a la compañía, con cobertura del total de su suma asegurada.</th>
                <th width="10%">${{ number_format($cotizacion["coverage"]) }}</th>
                @foreach($members as $item)
                    <th>${{ number_format(1) }}</th>
                    @php
                        $item["total"] += 1;
                    @endphp
                @endforeach
            </tr>
            @foreach ($cotizacion["insurer"]["benefits_insurer"] as $item)
                @if($item["pay"] == 1 && $item["selected_benefit"] > 0 )
                    <tr>
                        <th width="15%">{{ $item["benefit"]["benefit"] }}</th>
                        <th width="100%">{!! $item["benefit"]["short_description"] !!}</th>
                        <th width="10%">${{ number_format($item["coverage"]) }}</th>
                        @foreach($members as $item2)
                            <th>${{ number_format($item["selected_benefit"]) }}</th>
                            @php
                                $item2["total"] += $item["selected_benefit"]
                            @endphp
                        @endforeach
                    </tr>
                @endif
                @if($item["pay"] == 0 )
                    <tr>
                        <th>{{ $item["benefit"]["benefit"] }}</th>
                        <th>{!! $item["benefit"]["short_description"] !!}</th>
                        <th width="5%"><img width="10" src="https://cotiseguros.com.ve/storage/check-solid.png" alt=""></th>
                        @foreach($members as $item2)
                            <th><img width="10" src="https://cotiseguros.com.ve/storage/check-solid.png" alt=""></th>
                        @endforeach
                    </tr>
                @endif
            @endforeach
            <tr>
                <td></td>
                <!-- <td></td> -->
                <td colspan="2">Total de la Prima por individuo</td>
                @foreach($members as $item)
                    @php
                        $total = 1;
                    @endphp
                    @foreach ($cotizacion["insurer"]["benefits_insurer"] as $item2)
                        @if($item2["pay"] == 1 && $item2["selected_benefit"] > 0 )
                            @php
                                $total += $item2["selected_benefit"];
                            @endphp
                        @endif
                    @endforeach
                    <td>${{ number_format($total) }}</td> 
                @endforeach
            </tr>
            <tr>
                <td></td>
                <!-- <td></td> -->
                <td colspan="2">Total de la anual de Prima</td>
                @php
                    $total = 0;
                @endphp
                @foreach($members as $item)
                    @php
                        $total += 1;
                    @endphp
                    @foreach ($cotizacion["insurer"]["benefits_insurer"] as $item2)
                        @if($item2["pay"] == 1 && $item2["selected_benefit"] > 0 )
                            @php
                                $total += $item2["selected_benefit"];
                            @endphp
                        @endif
                    @endforeach
                @endforeach
                <td colspan="2">${{ number_format($total) }}</td> 
            </tr>
        </table>
        <!-- -->
        <table width="80%" style="margin-top:50px; margin-bottom: 30px ; margin-left: 10% ;"">
            <tr>
                <th>Asegurados</th>
                <th>Prima</th>
                @php
                    $count = 0;
                @endphp
                @foreach ($cotizacion["insurer"]["benefits_insurer"] as $item)
                    @if ( $item["selected_benefit"] > 0 )
                        <th>{{ $item["benefit"]["benefit"] }}</th>
                        @php
                            $count++;
                        @endphp
                    @endif
                @endforeach

                @foreach ($frecuencies as $item)
                    <th>Prima {{ $item["name"] }}</th>
                    @php
                        $item["total"] = 0;
                    @endphp
                @endforeach
            </tr>
            
                @foreach ($members as $member)
                    @php
                        $total = 0;
                    @endphp
                    <tr>
                        <td>{{ $member["status"] }}</td>
                        <td>${{ number_format(1) }}</td>
                        @php
                            $total += 1;
                        @endphp
                        @foreach ($cotizacion["insurer"]["benefits_insurer"] as $item)
                            @if ( $item["selected_benefit"] > 0 )
                                <td>${{ number_format($item["selected_benefit"]) }}</td>
                                @php
                                    $total += $item["selected_benefit"];
                                @endphp
                            @endif
                        @endforeach

                        @foreach ($frecuencies as $item)
                            <td>${{ number_format(($total / $item["frequency"])) }}</td>
                            @php
                                $item["total"] += $total / $item["frequency"];
                            @endphp
                        @endforeach
                    </tr>
                @endforeach
                <tr>
                        <td>Total</td>
                        <td></td>
                        
                        @foreach ($cotizacion["insurer"]["benefits_insurer"] as $item)
                            @if ( $item["selected_benefit"] > 0 )
                                <td> @if( $loop->index + 1 == $count )  @endif</td>
                            @endif
                        @endforeach
                    @foreach ($frecuencies as $item)
                        <td>${{ number_format($item["total"]) }}</td> 
                    @endforeach
                </tr>
        </table>
        
        
        <p> <b class="subtitle">Coberturas incluidas:</b>
        <span class="desc">
        @foreach ($cotizacion["insurer"]["benefits_insurer"] as $item)
            @if( $item["pay"] == 0 ) {{ $item["benefit"]["benefit"] }}. @endif
        @endforeach
        </span> 
        </p>
        <p> 
            
        @if( count($cotizacion["insurer"]["benefits_insurer"]) > 0 ) <b class="subtitle">Coberturas opcionales:</b> @endif
        <span class="desc">
        @foreach ($cotizacion["insurer"]["benefits_insurer"] as $item)
            @if( $item["pay"] == 1  && $item["selected_benefit"] > 0 ) {{ $item["benefit"]["benefit"] }} ${{ $item["selected_benefit"] }}. @endif
        @endforeach
        </span> 
        </p>

        <h3 class="subtitle">PLAZOS DE ESPERA:</h3>
        <span class="desc">{!!$datos["plazos"]!!}</span>
        
    @endforeach
    
</body>
</html>