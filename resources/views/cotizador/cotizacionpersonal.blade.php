@extends('layouts.app')

@section('content')
    <?php    //echo "<pre>"; print_r($coverages);    ?>
    <style>
        .custom-loader {
        width:100px;
        height:100px;
        border-radius:50%;
        border:16px solid;
        border-color:#766DF4 #0000;
        animation:s1 1s infinite;
        margin-top: 20%;
        margin-left: 50%;
        z-index: 100;
        }
        @keyframes s1 {to{transform: rotate(.5turn)}}
    </style>
    
    <div class="w-100 d-flex flex-column flex-md-row justify-content-center pt-2">
        {{-- @for ($i = 0; $i < 3; $i++)
            @include('../components/card-x')
        @endfor --}}
    </div>
    <div class="container my-5">
        <div class="w-100 d-flex flex-column align-items-center justify-content-center mb-3">
            <h2 class="text-uppercase mon-black text-wine text-center mt-5">Coberturas que te ofrecemos personal</h2>
          </div>
        <div id="cotizacionpesonal" class="my-5">
            <div class="row bg-light py-4 px-5 rounded shadow mx-2">
                <div  class="col-12 col-md-4 d-flex flex-column mt-3" id="divcoverages">
                    <!--
                    <h6 class="text-uppercase text-center mon-black">tu cobertura o suma asegurada</h6>
                    <select  
                        class="form-select shadow-none border-0 bg-grey w-100 align-self-start" 
                        aria-label="Default select example"
                        onChange ="changeCoverage()"    
                    >
                    @foreach ($coverages as $c)
                        <option  value="{{ $c->coverage}}"> {{ $c->coverage}} $</option>
                    @endforeach
                    </select>
                    -->
                    <select  
                        class="form-select shadow-none border-0 bg-grey w-100 align-self-start" 
                        aria-label="Default select example"
                        onChange ="changeCoverage()"    
                        id ="selectcoverage"
                    >
                    </select>
                </div>
                <div class="col-12 col-md-5 mt-3">
                    <h6 class="text-uppercase text-center mon-black">Formas de pago</h6>
                    <div class="d-flex justify-content-around align-items-center p-3 mt-3">
                    @foreach ($frequency as $f)
                        <div  class=''>
                             <input class='' name="frecuency" type="radio" onChange ="changeFrequency('{{$f->name}}', '{{$f->frequency}}')"/> {{$f->name}}
                        </div>
                    @endforeach

                    </div>
                </div>
                <div class="col-12 col-md-3 mt-3 d-flex flex-column justify-content-center align-items-center">
                    <h6 class="text-uppercase text-center mon-black">Opciones</h6>
                    <div class='pt-2 d-flex justify-content-around align-items-center w-100'>
                        <div onClick="openModalMembers()" class='btn bg-white shadow d-flex p-2 px-3 rounded-pill' data-toggle="modal" data-target="#exampleModal">
                            <img src="/storage/anadir-grupo-04.png" width="20" />
                            <span class='ps-2 mon-regular fs-10 d-flex justify-content-center align-items-center'>Editar integrantes</span>
                            
                        </div>
                    </div>
                    <div class='pt-2 d-flex justify-content-around align-items-center w-100'>
                        <div onClick="generartodo()" class='btn bg-white shadow d-flex p-2 px-3 rounded-pill' data-toggle="modal" data-target="#exampleModal">
                            
                            <span class='ps-2 mon-regular fs-10 d-flex justify-content-center align-items-center'>Cotizar todo</span>
                        </div>
                    </div>

                </div>
                
            </div>
            <!-- -->
            <div class="custom-loader" id ="carga" sytyle="display:none"></div>
            <!-- -->
            <div class="accordion px-3"  id="accordionExample">

            </div>
            <!-- -->

        </div>
        
    </div>
    <a class="text-decoration-none bg-white rounded-pill text-wine fw-bold p-2 ms-3 shadow" style="position: fixed ;top: 75px ;" href="javascript: history.go(-1)">Volver atrás</a>
    <script> 
        
        let members =[];
        //let frequencySelected =["frequency" : 1 , "name" : "Anual"] 
        let frequencySelected = {frequency:"1", name:"Anual"}; //console.log(frequencySelected);
        let coverages =[];
        let coverageSelected =[];
        let coveragesList=[];
        let quote =[];
        let familiar ='';
        let htmlacordeon ='';
        let htmlbenefit='';
        let htmlmiembreso ='';
        let htmlbenefit2='';
        $( document ).ready(function() 
        {
            //console.log( "ready!" );
            $("#carga").css('display','block');
            buscarcoverages()
            buscarprimas()
            //$("#carga").css('display','none');
        });
        function buscarprimas()
        {
            //
            fetch(`/api/salud/cotizacion/${ window.location.href.split("/")[window.location.href.split("/").length - 1] }`)
            .then((response) => response.json())
            .then((data) => 
            {
                if(data.status == false)
                {
                    //setLoad("none");
                    //setLock("block");
                    //console.log('bloqueado')
                } 
                else 
                {
                    quote =data;
                    coverageSelected =data.coverage;
                    coverages =data.arrayCoverages;
                    members =data.memberquote;
                    //console.log('quote',quote);
                    //console.log('coverages',coverages);
                    //console.log('members',members)
                    const m = data.memberquote;
                    for (let index = 0; index < m.length; index++) 
                    {
                        m[index].show = true;
                    }
                    familiar =m;
                    localStorage.setItem("coverages", data.id );
                    //
                    coverages.map((coverage,indexCoverages) =>{

                        console.log(indexCoverages)
                        //console.log( coverage,indexCoverages)
                        htmlacordeon +=
                        `<div class="accordion-item row my-3 shadow">
                            <div class="col-12 col-md-2 d-flex flex-column">
                                <div class="w-100 h-100 d-flex justify-content-center align-items-center py-3">
                                    <img class="img-insurer" src="/storage/${coverage.insurer.image}" />
                                </div>
                            </div>
                            <div class="col-12 col-md-2 d-flex flex-column justify-content-center align-items-center">
                                <div class="w-100 text-uppercase text-center mon-black text-pink">cobertura hcm</div>
                                <div class="w-100 text-uppercase text-center mon-black text-pink">${ new Intl.NumberFormat().format(coverage.coverage) } usd 1</div>
                            </div>
                            <div class="col-12 col-md-3 d-flex flex-column">
                                <h6 class="mon-black text-uppercase text-center mt-2" id ="nombreprima">prima ${ frequencySelected.name }</h6>
                                ${ miembros(indexCoverages) }
                                <div class="w-100 d-flex">
                                    <div class="w-100 text-uppercase text-start mon-black h3 text-pink">total</div>
                                    <div class="w-100 text-uppercase text-end mon-black h3 text-pink" id ="total_${indexCoverages}">${ totalForCoverage(indexCoverages) }  USD 2</div>
                                </div>
                            </div>
                            
                            <div class="m-0 p-0 col-12 col-md-2 d-flex flex-column justify-content-center align-items-center">
                                <div  
                                    data-bs-toggle="collapse"
                                    data-bs-target="${`#collapse${indexCoverages}`}" 
                                    aria-expanded="false" aria-controls="${`#collapse${indexCoverages}`}" 
                                    class="btn btn-benefit bg-pink py-2 px-3 rounded-pill mon-black d-flex my-2"
                                >
                                    <img src="/storage/Enmascarargrupo24.png" />
                                    <div
                                        data-bs-toggle="collapse" 
                                        data-bs-target="${`#collapse${indexCoverages}`}" 
                                        aria-expanded="false" aria-controls="${`#collapse${indexCoverages}`}"  
                                        class="w-100 h-100 d-flex justify-content-start align-items-center mon-black text-start ps-2 text-white">Ver detalles</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 d-flex justify-content-center align-items-center px-3">
                                <div  class="btn btn-benefit bg-pink py-2 px-3 rounded-pill mon-black d-flex align-items-center my-2">
                                    <i class="bi bi-send-fill h3 text-white mb-0"></i>
                                    <div 
                                        class="w-100 h-100 d-flex justify-content-start align-items-center mon-black text-start ps-2 text-white"
                                        onclick ="sendQuote(${indexCoverages})";
                                    >
                                        Enviar cotizacion
                                    </div>
                                </div>
                                
                            </div>

                            <div id ="collapse${indexCoverages}" class="accordion-collapse collapse col-12" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="row" id="#${indexCoverages}">
                                    <div class='col-12'>
                                        <div class='col-12'>
                                            <p class='mon-black font-weight-bold p-0 m-0'>${ (coverage.insurer.note) ? 'Nota:' : '' } ${ coverage.insurer.note }</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 border-end">
                                        <h3 class="text-uppercase text-success mon-black h3 pt-3 mb-4">beneficios incluidos</h3>
                                        ${ benefit(indexCoverages)}
                                    </div>
                                    <div class="col-12 col-md-6 border-end">
                                        <h3 class="text-uppercase text-success mon-black h3 pt-3 mb-4">beneficios pagos</h3>
                                        ${ benefit_2(indexCoverages)}
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    } );

                    $("#accordionExample").html(htmlacordeon);
                    //
                }
                $("#carga").css('display','none');
            });
            //
        }
        function changeFrequency(nombre,frecuency)
        {
            
            frequencySelected = {frequency:frecuency, name:nombre};
            console.log('coverages',coverages)
            $("#nombreprima").html('');
            $("#nombreprima").html(' Prima '+nombre);
            for(let i = 0; i < coverages.length ; i++)
            {
                coverages[i].total = 0;
            }
            coverages =coverages;
            //console.log('coverages 2 ',coverages)
            coverages.map((coverage,indexCoverages) =>
            {
                miembros2(indexCoverages)
            })
            
        }
        function miembros(indexCoverages)
        {
            htmlmiembreso =''; 
            members.map((member,indexMember) =>{
                htmlmiembreso +=`<div  class="w-100 d-flex">
                                    <div class="w-100 text-start mon-black text-dark"> ${member.status} </div>
                                    <div class="w-100 text-uppercase text-end mon-black text-pink" id="indexCoverages${indexCoverages}_${indexMember}">
                                        ${ rateForMember(indexCoverages,indexMember) + totalBenefits(indexCoverages) } USD 3
                                    </div>
                                </div>`;
            });
            
            return htmlmiembreso;
        }
        function miembros2(indexCoverages)
        {
            htmlmiembreso ='';
            members.map((member,indexMember) =>
            {
                
               let t1 =rateForMember(indexCoverages,indexMember); console.log(t1);
               let t2 =totalBenefits(indexCoverages); console.log(t2);
               console.log('indexCoverages'+indexCoverages+'_'+indexMember)
               if (   (parseFloat(t1) + parseFloat(t2))>0 )
                $("#indexCoverages"+indexCoverages+'_'+indexMember).html( (parseFloat(t1) + parseFloat(t2))+' USD' ); 

                totalForCoverage2(indexCoverages)
            });
            
            return htmlmiembreso;
        }
        function benefit(indexCoverages)
        {
            
            coverages[indexCoverages].insurer.benefits_insurer.map((benefit,indexBenefit)=>
            {
                htmlbenefit +=`
                <div  id="${indexBenefit}" class="${ (benefit.pay == 0) ? "d-block" : "d-none" }">
                    <div class="w-100 my-2 d-flex text-start text-uppercase mon-black align-items-center h4">
                        <img class="img-benefit" src="/storage/${benefit.benefit.image}" />
                        <span class="ms-2 text-pink h5">${ benefit.benefit.benefit }</span> 
                    </div>     
                    <div class="row">
                        <div 
                            style="${{ "display" : checkCoverage(benefit.pay_benefit.length)} }" 
                            class="py-3 col-6 col-md-6 justify-content-start align-items-center"
                        >
                            <h3 class="text-uppercase mon-normal h5">cobertura de</h3>
                        </div>
                        <div 
                            style="${{ "display" : checkCoverage(benefit.pay_benefit.length)} }" 
                            class="py-3 col-6 col-md-6 justify-content-end align-items-center">
                                ${pay_benefit(benefit)}                                       
                        </div>
                        <div class="col-12 my-3">
                            <p class="mon-light"> ${benefit.benefit.description}</p>
                        </div>
                    </div>           
                </div>`;
            });
            return htmlbenefit;
        }
        function benefit_2(indexCoverages)
        {
            
            coverages[indexCoverages].insurer.benefits_insurer.map((benefit,indexBenefit)=>
            {
                htmlbenefit2 +=`
                <div  id="${indexBenefit}" class="${ (benefit.pay == 1) ? "d-block" : "d-none" }">
                    <div class="w-100 my-2 d-flex text-start text-uppercase mon-black align-items-center h4">
                        <img class="img-benefit" src="/storage/${benefit.benefit.image}" />
                        <span class="ms-2 text-pink h5">${ benefit.benefit.benefit }</span> 
                    </div>     
                    <div class="row">
                        <div class="col-6 col-md-6 d-flex justify-content-start align-items-center">
                            <h3 class="text-uppercase mon-normal h5">cobertura de</h3>
                        </div>
                        <div class="col-6 col-md-6">
                            <select 
                                class="form-select shadow-none border-0 bg-grey w-100 align-self-start" 
                                id ="sebeneficio${indexBenefit}"
                                onChange ="selectPayBenefit(${indexCoverages},${indexBenefit} )"
                                style="height: 58px;" 
                                aria-label="Default select example">
                                <option value="-1"> Beneficio desactivado</option>
                                ${selectbenficio(benefit.pay_benefit) }                        
                            </select>                         
                        </div>
                        <div 
                            class=${ (coverages[indexCoverages].insurer.benefits_insurer[indexBenefit].selected_benefit > 0) ? "col-6 col-md-6 d-flex justify-content-start align-items-center my-3" : "d-none" } >
                            <h3 class="text-uppercase mon-black h5">prima de</h3>
                        </div>
                        <div class=${ (coverages[indexCoverages].insurer.benefits_insurer[indexBenefit].selected_benefit > 0) ? "col-6 col-md-6 d-flex justify-content-start align-items-center my-3" : "d-none" }>
                            <h3 class="text-uppercase mon-black h5 text-pink">{ coverages[indexCoverages].insurer.benefits_insurer[indexBenefit].selected_benefit } usd 4 </h3>
                        </div>
                        <div class="col-12 my-3">
                            <p class="mon-light"> ${benefit.benefit.description}</p>
                        </div>
                    </div>           
                </div>`;
            });
            return htmlbenefit2;
        }
        function pay_benefit(benefit)
        {
            htmlbenefit ='';
            benefit.pay_benefit.map((payBenefit,indexPayBenefit) =>
            {
                //console.log('ingresa',payBenefit.rate)
                htmlbenefit =` <h3 id="${indexPayBenefit}" class="text-uppercase mon-black text-pink h5 text-right">${ `${payBenefit.rate} USD 5`  }</h3>`;
            });
            
            return htmlbenefit;
        }
        function totalForCoverage(indexCoverage) 
        {
          let total = 0;
          for (let index = 0; index < members.length; index++) 
          {
              total += rateForMember(indexCoverage,index) + totalBenefits(indexCoverage);
          }
          return total;
        }
        function totalForCoverage2(indexCoverage) 
        {
          let total = 0;
          for (let index = 0; index < members.length; index++) 
          {
              total += rateForMember(indexCoverage,index) + totalBenefits(indexCoverage);
          }
          $("#total_"+indexCoverage).html(total+' USD')
        }
        function checkCoverage(a)
        {
            if(a > 0)
            {
                return "flex";
            } 
            else 
            {
                return "none";
            }
        }
        function rateForMember (indexCoverages,indexMember)  
        {
        
            for (let index = 0; index < coverages[indexCoverages].rates.length; index++) 
            {
                if(members[indexMember].date >= coverages[indexCoverages].rates[index].from  && members[indexMember].date <= coverages[indexCoverages].rates[index].to)
                {
                    return (coverages[indexCoverages].rates[index].rate / frequencySelected.frequency) ;
                }
            }
            return 0;
        }
        function totalBenefits (indexCoverage)  
        {
          let total = 0;
          for (let index = 0; index < coverages[indexCoverage].insurer.benefits_insurer.length; index++) 
          {
              total += coverages[indexCoverage].insurer.benefits_insurer[index].selected_benefit;
          }
          
          return total / frequencySelected.frequency;
        }
        function selectbenficio(pay_benefit)
        {
            htmlselectbenficio ='';
            {pay_benefit.map((payBenefit,indexPayBenefit) =>
                htmlselectbenficio += ` <option value="${indexPayBenefit}">${ `${ new Intl.NumberFormat().format( payBenefit.coverage ) } $` }</option>`
            )}
            return htmlselectbenficio;
        }
        function selectPayBenefit(i,j)
        {
           let sebeneficio= $("#sebeneficio"+j).val();
           console.log(`Coverages antes `,coverages);
           if(sebeneficio > -1 )
           {
            
                coverages[i].insurer.benefits_insurer[j].selected_benefit = coverages[i].insurer.benefits_insurer[j].pay_benefit[sebeneficio].rate;
                coverages[i].insurer.benefits_insurer[j].pay_benefit[sebeneficio].selected = 1;
                coverageSelected =coverageSelected
                coverages =coverages;
                console.log(`Coverages `,coverages);
            }   
            else
            {
                coverages[i].insurer.benefits_insurer[j].selected_benefit = 0;
                for(let x = 0; x < coverages[i].insurer.benefits_insurer[j].pay_benefit.length ; x++ )
                {
                    coverages[i].insurer.benefits_insurer[j].pay_benefit[x].selected = 0;
                }
                coverages = coverages;
                console.log(`Coverages despues `,coverages);

            }
            // ordernar montos
            coverages.map((coverage,indexCoverages) =>
            {
                console.log('aqui',indexCoverages)
                miembros2(indexCoverages);
            });
        }
        function sendQuote (indexCoverage)  
        {
            //window.open(`https://wa.me/${ window.location.href.split("/")[window.location.href.split("/").length - 1] }?text=hola`, '_blank');
            /*
            let space = "%20";
            let enter = "%0A";
            let message = "";
            console.log(frequencySelected);
            message += `*Cliente:* ${quote.name} ${quote.last_name} ${enter}`;
            console.log(quote.name,quote.last_name);
            message += `*Seguro:* ${coverages[indexCoverage].insurer.name} ${enter}`;
            console.log(coverages[indexCoverage].insurer.name);
            message += `*Cobertura:* ${coverages[indexCoverage].coverage} ${enter}`;
            console.log(coverages[indexCoverage].coverage);
            message += `*Frecuencia de pago:* ${frequencySelected.name} ${enter}${enter}`;
            message += `*Beneficiados:* ${enter}${enter}`;
            for( let j = 0 ; j < members.length ; j++ )
            {
                message += `*${members[j].status} ${members[j].gender, members[j].date}*: ${rateForMember(indexCoverage,j) + totalBenefits(indexCoverage)} ${enter}`;
                console.log( members[j].status, members[j].gender, members[j].date ,rateForMember(indexCoverage,j) + totalBenefits(indexCoverage) )
            }
            message += `${enter}${enter}*Beneficios Pagos:* ${enter}`;
            for( let i = 0 ; i < coverages[indexCoverage].insurer.benefits_insurer.length ; i++ )
            {
                if(coverages[indexCoverage].insurer.benefits_insurer[i].pay == 1 && coverages[indexCoverage].insurer.benefits_insurer[i].selected_benefit > 0 )
                {
                    message += `*${coverages[indexCoverage].insurer.benefits_insurer[i].benefit.benefit}*: ${coverages[indexCoverage].insurer.benefits_insurer[i].selected_benefit}${enter}`;
                    console.log(coverages[indexCoverage].insurer.benefits_insurer[i].benefit.benefit,coverages[indexCoverage].insurer.benefits_insurer[i].pay,coverages[indexCoverage].insurer.benefits_insurer[i].selected_benefit);
                }
            }
            //window.open(`https://wa.me/584247089641?text=${message}`, '_blank');
            //console.log(totalForCoverage(indexCoverage));
            */
            sendCotizacion(indexCoverage)
        }
        function changeCoverage()
        {
            let selectcoverage = $("#selectcoverage").val(); console.log(selectcoverage)
            //fetch(`/api/salud/cotizacion/${ window.location.href.split("/")[window.location.href.split("/").length - 1] }/${selectcoverage}`)
            fetch(`/api/changeCoverage/${ window.location.href.split("/")[window.location.href.split("/").length - 1] }/${selectcoverage}`)
            .then((response) => response.json())
            .then((data) => 
            {
                coverageSelected = data.coverage;
                coverages =data.arrayCoverages;
                members =data.memberquote;

                console.log('quote',quote);
                console.log('coverages',coverages);
                console.log('members',members)
            });
            //fetch(`/api/salud/cotizacion/${ window.location.href.split("/")[window.location.href.split("/").length - 1] }`)
            //const data = await resp.json();
            
           
            /*
            setLoad("none");
            setCoverageSelected(data.coverage);  coverageSelected
            setCoverages(data.arrayCoverages); coverages
            setMembers(data.memberquote); members
            console.log("Coverages = ",coverageSelected,coverages);
            */
        }

        function sendCotizacion(indexCoverage)
        {
            $("#accordionExample").css('display','none');
            $("#carga").css('display','block');
            let url ='';
            console.log('enviar');
            console.log('coverages',coverages,indexCoverage);
            console.log('members',members)
            phone ='/+5804247574613';
    
            let formData = new FormData();
            formData.append("members", members);
            formData.append("phone", phone);
            fetch("/api/sendCotizacionlotes", 
            {
                headers: {
                    'X-CSRF-TOKEN': window.CSRF_TOKEN, // <--- aquí el token
                    "Content-type": "application/json; charset=UTF-8"
                },
                method: "POST",
                body: JSON.stringify({
                    members: members,
                    coverage: coverages[indexCoverage],
                  phone: phone
                }),
            })
            .then(r => r.json())
            .then(r => 
            {
                //console.log(r);
                console.log(r['file']);
                url = r['file'];
                $("#accordionExample").css('display','block');
                $("#carga").css('display','none');
            }).finally(()=>
                {
                    abrirvenatan(url)
                });
            
        }
        function abrirvenatan(url)
        {
            window.open(url, "_blank");
            download(url, 'toco.pdf');
        }
        function buscarcoverages()
        {
            let divcoverages ='';
            fetch("/api/coverages").then((response) => response.json())
            .then((data) => 
            {
                coveragesList =data;
                coveragesList.map((coverage,indexCoverage) =>    $("#selectcoverage").append(`<option  value=${coverage.coverage}> ${ new Intl.NumberFormat().format(coverage.coverage) }$</option>`))
            });
        }
        function generartodo()
        {
            
            $("#accordionExample").css('display','none');
            $("#carga").css('display','block');
            let url ='';
            console.log('enviar');
            console.log('coverages',coverages);
            console.log('members',members)
            phone ='/+5804247574613';
    
            let formData = new FormData();
            formData.append("members", members);
            formData.append("phone", phone);
            fetch("/api/sendCotizacionlotes2", 
            {
                headers: {
                    'X-CSRF-TOKEN': window.CSRF_TOKEN, // <--- aquí el token
                    "Content-type": "application/json; charset=UTF-8"
                },
                method: "POST",
                body: JSON.stringify({
                    members: members,
                    coverage: coverages,
                  phone: phone
                }),
            })
            .then(r => r.json())
            .then(r => 
            {
                //console.log(r);
                console.log(r['file']);
                url = r['file'];
                $("#accordionExample").css('display','block');
                $("#carga").css('display','none');
            }).finally(()=>
                {
                    abrirvenatan(url)
                });
            
        }
        async function  generartodo2() 
        {
            const url = "https://example.com/api/users"
            const body = {
                //  ...
            }
            
            const response = await fetch(url, body)
            const jsonResponse = await response.json()
        }
    </script>
@endsection