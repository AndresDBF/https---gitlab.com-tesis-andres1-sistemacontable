import React from 'react';
import ReactDOM from 'react-dom';
import { useState, useEffect,useContext,createContext } from "react";
import Parser from 'html-react-parser';
import CotizadorModal from './CotizadorModal';

import { GlobalProvider } from "./GlobalProvider";
import { GlobalContext } from "./GlobalProvider";

export const Cotizacion = () => {
    const [quote, setQuote] = useState();
    const [coverageSelected, setCoverageSelected] = useState(0);
    const [coveragesList, setCoveragesList] = useState([]);
    const [frequencies, setFrequencies] = useState([]);
    const [coverages, setCoverages] = useState([]);
    const [members, setMembers] = useState([]);
    const [frequencySelected, setFrequencySelected] = useState({ "frequency" : 1 , "name" : "Anual" });
    const [booleanBenefit, setBooleanBenefit] = useState(0);
    const [load, setLoad] = useState("block");
    const [lock, setLock] = useState("none");
    const [listDesc, setListDesc] = useState([]);
    const [modal,setModal] = useState({ "display" : "none" });
    const [test,setTest] = useState("hola mundo");
    const {familiar, setFamiliar} = useContext(GlobalContext);
    //const {mem,setMem} = useContext(GlobalContext);

    const [insurers, setInsurers] = useState([
        {
            state : false
        },
        {
            state : false
        }
    ]);

    const selectInsurer = (i) => {
        for (let index = 0; index < insurers.length; index++) {
            insurers[index].state = false;
        }
        insurers[i].state = true;
        setInsurers([...insurers]);
        //console.log(insurers)
    }

    const addTotal = (rate,index) => {
        //coverages[index].total += rate;
        //console.log(coverages);
        //setCoverages([...coverages]);
        //setCoverages(coverages);
        return rate / frequencySelected.frequency;
    }

    const optionBenefits = (index) => {
        let benefitSelected = false;
        
        for(let i = 0; i < coverages[index].insurer.benefits_insurer.length ; i++ ){
            coverages[index].insurer.total_benefit = 0;
            for(let j = 0 ; j < coverages[index].insurer.benefits_insurer[i].pay_benefit.length ; j++){
                if( coverages[index].insurer.benefits_insurer[i].pay_benefit[j].selected == 1 ){
                    coverages[index].insurer.total_benefit += coverages[index].insurer.benefits_insurer[i].pay_benefit[j].rate
                }
            }
        }
        for(let i = 0; i < coverages.length ; i++){
            coverages[i].total = 0;
        }
        //(coverages[index].total * -1 + 33;
        setCoverages([...coverages]);
    }

    const selectPayBenefit = (e,i,j) => {
        if(e.target.value > -1 ){
            // for(let x = 0; x < coverages[i].insurer.benefits_insurer[j].pay_benefit.length ; x++ ){
            //     coverages[i].insurer.benefits_insurer[j].pay_benefit[x].selected = 0;
            // }
            //console.log(coverages[i].insurer.benefits_insurer[j].pay_benefit[e.target.value].rate);
            coverages[i].insurer.benefits_insurer[j].selected_benefit = coverages[i].insurer.benefits_insurer[j].pay_benefit[e.target.value].rate;
            coverages[i].insurer.benefits_insurer[j].pay_benefit[e.target.value].selected = 1;
            setCoverageSelected(coverageSelected);
            setCoverages([...coverages]);
            console.log(`Coverages `,coverages);
        } else {
            //coverages[i].insurer.benefits_insurer[j].pay_benefit[e.target.value].selected = 0;
            coverages[i].insurer.benefits_insurer[j].selected_benefit = 0;
            for(let x = 0; x < coverages[i].insurer.benefits_insurer[j].pay_benefit.length ; x++ ){
                coverages[i].insurer.benefits_insurer[j].pay_benefit[x].selected = 0;
            }
            setCoverages([...coverages]);
            console.log(`Coverages `,coverages);
            //coverages[i].insurer.benefits_insurer[j].selected_benefit = 0;
            
            //setCoverages(coverages);
        }
    }

    const changeFrequency = (e) => {
        setFrequencySelected( JSON.parse(e));
        for(let i = 0; i < coverages.length ; i++){
            coverages[i].total = 0;
        }
        setCoverages(coverages);
    }

    const sendQuote = (indexCoverage) => {
        //window.open(`https://wa.me/${ window.location.href.split("/")[window.location.href.split("/").length - 1] }?text=hola`, '_blank');
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
        for( let j = 0 ; j < members.length ; j++ ){
            message += `*${members[j].status} ${members[j].gender, members[j].date}*: ${rateForMember(indexCoverage,j) + totalBenefits(indexCoverage)} ${enter}`;
            console.log( members[j].status, members[j].gender, members[j].date ,rateForMember(indexCoverage,j) + totalBenefits(indexCoverage) )
        }
        message += `${enter}${enter}*Beneficios Pagos:* ${enter}`;
        for( let i = 0 ; i < coverages[indexCoverage].insurer.benefits_insurer.length ; i++ ){
            if(coverages[indexCoverage].insurer.benefits_insurer[i].pay == 1 && coverages[indexCoverage].insurer.benefits_insurer[i].selected_benefit > 0 ){
                message += `*${coverages[indexCoverage].insurer.benefits_insurer[i].benefit.benefit}*: ${coverages[indexCoverage].insurer.benefits_insurer[i].selected_benefit}${enter}`;
                console.log(coverages[indexCoverage].insurer.benefits_insurer[i].benefit.benefit,coverages[indexCoverage].insurer.benefits_insurer[i].pay,coverages[indexCoverage].insurer.benefits_insurer[i].selected_benefit);
            }
        }
        window.open(`https://wa.me/584247089641?text=${message}`, '_blank');
        console.log(totalForCoverage(indexCoverage));
    }

    const changeCoverage = async (e) => {
        const resp = await fetch(`/api/salud/cotizacion/${ window.location.href.split("/")[window.location.href.split("/").length - 1] }/${e.target.value}`)
        const data = await resp.json();
        setLoad("none");
        setCoverageSelected(data.coverage);
        setCoverages(data.arrayCoverages);
        setMembers(data.memberquote);
        console.log("Coverages = ",coverageSelected,coverages);
        //setLoad("none");
        //setCoverageSelected(data.coverage);
        //setCoverages(data.coverages);
        //console.log("Coverages = ",coverages);
        /*
        fetch(`/api/salud/cotizacion/${ window.location.href.split("/")[window.location.href.split("/").length - 1] }/${e.target.value}`)
          .then((response) => response.json())
          .then((data) => {
                if(data){
                    console.log(data);
                    setLoad("none");
                    setCoverageSelected(data.coverage);
                    //setCoverages([data.coverages]);
                    setCoverages(data.coverages);
                    console.log("Coverages = ",coverages);
                } else {
                    setLoad("none");
                    setLock("block");
                }
                
          });*/
    }

    const openBenefit = (i) => {
        setBooleanBenefit(i)
    }

    useEffect(() => {

        fetch("/api/frequency")
          .then((response) => response.json())
          .then((data) => {
                //console.log(data);
                setFrequencies([...data]);
          });

        fetch("/api/coverages")
          .then((response) => response.json())
          .then((data) => {
                //console.log(data);
                setCoveragesList([...data]);
          });

        fetch(`/api/salud/cotizacion/${ window.location.href.split("/")[window.location.href.split("/").length - 1] }`)
          .then((response) => response.json())
          .then((data) => {
                console.log("aaa = ",data)
                if(data.status == false){
                    setLoad("none");
                    setLock("block");
                } else {
                    setLoad("none");
                    setQuote(data);
                    setCoverageSelected(data.coverage);
                    setCoverages([...data.arrayCoverages]);
                    setMembers([...data.memberquote]);
                    console.log(data);
                    const m = data.memberquote;
                    for (let index = 0; index < m.length; index++) {
                        m[index].show = true;
                    }
                    setFamiliar(m);
                    console.log( "Fam " , familiar );
                    console.log("lista = ",listDesc);
                    localStorage.setItem("coverages", data.id );
                    console.log("cov2 = ",data);
                }
                
          });

      },[]);

      const rateForMember = (indexCoverages,indexMember) => {
        
        for (let index = 0; index < coverages[indexCoverages].rates.length; index++) {
            if(members[indexMember].date >= coverages[indexCoverages].rates[index].from  && members[indexMember].date <= coverages[indexCoverages].rates[index].to){
                //console.log("Beenfit ",totalBenefits(indexCoverages) / frequencySelected.frequency);
                return (coverages[indexCoverages].rates[index].rate / frequencySelected.frequency) ;
            }
        }
        return 0;
      }

      const rateForMemberToShow = (indexCoverages) => {
        let bool = "none";
        for (let index = 0; index < coverages[indexCoverages].rates.length; index++) {
            for( let j = 0; j < members.length ; j++ ){
                if(members[j].date >= coverages[indexCoverages].rates[index].from  && members[j].date <= coverages[indexCoverages].rates[index].to){
                    bool = "display";
                }
            }
            
        }
        return bool;
      }

      const totalForCoverage = (indexCoverage) => {
          let total = 0;
          for (let index = 0; index < members.length; index++) {
              total += rateForMember(indexCoverage,index) + totalBenefits(indexCoverage);
          }
          console.log("Total", total );
          return total;
      }

      const totalBenefits = (indexCoverage) => {
          let total = 0;
          for (let index = 0; index < coverages[indexCoverage].insurer.benefits_insurer.length; index++) {
              //const element = array[index];
              total += coverages[indexCoverage].insurer.benefits_insurer[index].selected_benefit;
          }

          return total / frequencySelected.frequency;
      }

      const showDesc = (id,desc) => {
        console.log("#" + id,`#0-2-covid`,desc)
        //console.log($(`#${id}`))
        //console.log("AAAAAAAAAAA",`#${id}`,desc)
        //setListDesc([ ...listDesc,{ "id" : id , "desc" : desc } ]);
        $("#" + id).html(desc)
        //$(`#0-2-covid`).html("<b>holaaaa</b>")
      }

    const checkCoverage = (a) => {
        if(a > 0){
            return "flex";
        } else {
            return "none";
        }
    }

    const closeModalMember = () => {
        
        setModal({ "display" : "none" });
    }

    const openModalMembers = () => {
        const m = familiar;
        for (let index = 0; index < m.length; index++) {
            m[index].show = true;
        }
        setFamiliar(m);
        setModal({ "display" : "flex" });
    }

    return (
            <div>
            <div className="row bg-light py-4 px-5 rounded shadow mx-2">
                <div className="col-12 col-md-4 d-flex flex-column mt-3">
                    <h6 className="text-uppercase text-center mon-black">tu cobertura o suma asegurada</h6>
                    <select value={ coverageSelected } onChange={ changeCoverage } className="form-select shadow-none border-0 bg-grey w-100 align-self-start" style={{"height" : "58px" }} aria-label="Default select example">
                    {coveragesList.map((coverage,indexCoverage) =>
                        <option key={indexCoverage} value={coverage.coverage}>{ new Intl.NumberFormat().format(coverage.coverage) }$</option>
                    )}
                    </select>
                </div>
                <div className="col-12 col-md-5 mt-3">
                    <h6 className="text-uppercase text-center mon-black">Formas de pago</h6>
                    <div className='d-flex justify-content-around align-items-center p-3 mt-3'>
                    {frequencies.map((frequency,indexfrequency) =>
                        <div key={`radio${indexfrequency}`} className=''>
                             <input className='' name="frecuency" type="radio" onChange={ (e) => changeFrequency(e.target.value) } value={ JSON.stringify( frequency )} /> {frequency.name}
                        </div>
                    )}
                    </div>
                </div>
                <div className="col-12 col-md-3 mt-3 d-flex flex-column justify-content-center align-items-center">
                <h6 className="text-uppercase text-center mon-black">Opciones</h6>
                    <div className='pt-2 d-flex justify-content-around align-items-center w-100'>
                        <div onClick={ openModalMembers } className='btn bg-white shadow d-flex p-2 px-3 rounded-pill' data-toggle="modal" data-target="#exampleModal">
                            <img src="/storage/anadir-grupo-02.png" width={20} />
                            <span className='ps-2 mon-regular fs-10 d-flex justify-content-center align-items-center'>Editar integrantes</span>
                        </div>
                    </div>
                </div>
            </div>
            <div className="accordion px-3 " id="accordionExample">
                <div style={{ "display" : load }} className='w-100 py-5 my-5 text-center mon-black text-wine h3'>
                    Cargando...
                </div>
                <div style={{ "display" : lock }} className='w-100 py-5 my-5 text-center mon-black text-wine h3'>
                    Usuario bloqueado comuniquese con nuestros agentes
                </div>
            {coverages.map((coverage,indexCoverages) =>
                <div key={indexCoverages} className="accordion-item row my-3 shadow">
                    <div className="col-12 col-md-2 d-flex flex-column">
                         <div className="w-100 h-100 d-flex justify-content-center align-items-center py-3">
                             <img className="img-insurer" src={`/storage/${coverage.insurer.image}` } />
                         </div>
                     </div>
                     <div className="col-12 col-md-2 d-flex flex-column justify-content-center align-items-center">
                        <div className="w-100 text-uppercase text-center mon-black text-pink">cobertura hcm</div>
                        <div className="w-100 text-uppercase text-center mon-black text-pink">{ new Intl.NumberFormat().format(coverage.coverage) } usd</div>
                     </div>
                     <div className="col-12 col-md-3 d-flex flex-column">
                         <h6 className="mon-black text-uppercase text-center mt-2">prima { frequencySelected.name }</h6>
                         {members.map((member,indexMember) =>
                             <div key={indexMember} className="w-100 d-flex">
                                <div className="w-100 text-start mon-black text-dark">{member.status}</div>
                                <div className="w-100 text-uppercase text-end mon-black text-pink">
                                    { rateForMember(indexCoverages,indexMember) + totalBenefits(indexCoverages) } USD
                                </div>
                            </div>
                        )}
                        <div className="w-100 d-flex">
                            <div className="w-100 text-uppercase text-start mon-black h3 text-pink">total</div>
                            <div className="w-100 text-uppercase text-end mon-black h3 text-pink">{ totalForCoverage(indexCoverages) } USD</div>
                        </div>
                    </div>
                    <div className="m-0 p-0 col-12 col-md-2 d-flex flex-column justify-content-center align-items-center">
                        <div data-bs-toggle="collapse" data-bs-target={`#collapse${indexCoverages}`} aria-expanded="false" aria-controls={`#collapse${indexCoverages}`} className="btn btn-benefit bg-pink py-2 px-3 rounded-pill mon-black d-flex my-2">
                            <img src="/storage/Enmascarar grupo 24.png" />
                            <div className="w-100 h-100 d-flex justify-content-start align-items-center mon-black text-start ps-2 text-white">Ver detalles</div>
                        </div>
                    </div>
                    <div className="col-12 col-md-3 d-flex justify-content-center align-items-center px-3">
                        <div onClick={() => sendQuote(indexCoverages) } className="btn btn-benefit bg-pink py-2 px-3 rounded-pill mon-black d-flex align-items-center my-2">
                            <i className="bi bi-send-fill h3 text-white mb-0"></i>
                            <div className="w-100 h-100 d-flex justify-content-start align-items-center mon-black text-start ps-2 text-white">Enviar cotizacion</div>
                        </div>
                        {/* <i onClick={() => sendQuote(coverage) } className="bi bi-send-fill display-6 text-success"></i> */}
                    </div>
                    
                    

                    <div id={`collapse${indexCoverages}`} className="accordion-collapse collapse col-12" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                         <div className="row" key={indexCoverages}>
                            <div className='col-12'>
                                <div className='col-12'>
                                    <p className='mon-black font-weight-bold p-0 m-0'>{ (coverage.insurer.note) ? 'Nota:' : '' }{ coverage.insurer.note }</p>
                                </div>
                            </div>
                             <div className="col-12 col-md-6 border-end">
                                 <h3 className="text-uppercase text-success mon-black h3 pt-3 mb-4">beneficios incluidos</h3>
                             {coverages[indexCoverages].insurer.benefits_insurer.map((benefit,indexBenefit) => 
                                    <div key={indexBenefit} className={ (benefit.pay == 0) ? "d-block" : "d-none" }>
                                        <div className="w-100 my-2 d-flex text-start text-uppercase mon-black align-items-center h4">
                                            <img className="img-benefit" src={ `/storage/${benefit.benefit.image}` } />
                                            <span className="ms-2 text-pink h5">{ benefit.benefit.benefit }</span> 
                                        </div>
                                        <div className="row">
                                            <div style={{ "display" : checkCoverage(benefit.pay_benefit.length)} } className="py-3 col-6 col-md-6 justify-content-start align-items-center">
                                                <h3 className="text-uppercase mon-normal h5">cobertura de</h3>
                                            </div>
                                            <div style={{ "display" : checkCoverage(benefit.pay_benefit.length)} } className="py-3 col-6 col-md-6 justify-content-end align-items-center">
                                                
                                                {benefit.pay_benefit.map((payBenefit,indexPayBenefit) =>
                                                        // <option key={indexPayBenefit} value={indexPayBenefit}>{ `${payBenefit.coverage} USD` }</option>
                                                    //   <h3 key={indexPayBenefit} className="text-uppercase mon-black text-pink h5 text-right">{ ( payBenefit.coverage == coverageSelected ) ? `${payBenefit.rate} USD` : "--" }</h3>
                                                    <h3 key={indexPayBenefit} className="text-uppercase mon-black text-pink h5 text-right">{ `${payBenefit.rate} USD`  }</h3>
                                                )}
                                            </div>
                                            <div className="col-12 my-3">
                                                <p className="mon-light" dangerouslySetInnerHTML={{ __html: `${benefit.benefit.description}` }}></p>
                                                {/* <p className="mon-light" id={ `${indexCoverages}-${benefit.benefit.id}-${benefit.benefit.benefit.split(" ").join("-")}-incluido` }>{ showDesc(`${indexCoverages}-${benefit.benefit.id}-${benefit.benefit.benefit.split(" ").join("-") }-incluido`,benefit.benefit.description) }</p> */}
                                            </div>
                                        </div>
                                        <hr className="w-100 m-0 p-0" />
                                    </div>
                                )}
                            </div>
                            <div className="col-12 col-md-6 pb-2">
                            <h3 className="text-uppercase text-warning mon-black h3 pt-3 mb-4">beneficios pagos</h3>
                                {coverages[indexCoverages].insurer.benefits_insurer.map((benefit,indexBenefit) => 
                                    <div key={indexBenefit} className={ (benefit.pay == 1) ? "d-block" : "d-none" }>
                                        <div className="w-100 my-2 d-flex text-start text-uppercase mon-black align-items-center h4">
                                            <img className="img-benefit" src={ `/storage/${benefit.benefit.image}` } />
                                            <span className="ms-2 text-pink h5">{ benefit.benefit.benefit }</span> 
                                        </div>
                                        <div className="row">
                                            <div className="col-6 col-md-6 d-flex justify-content-start align-items-center">
                                                <h3 className="text-uppercase mon-normal h5">cobertura de</h3>
                                            </div>
                                            <div className="col-6 col-md-6">
                                                <select onChange={ (e) => selectPayBenefit(e,indexCoverages,indexBenefit) } className="form-select shadow-none border-0 bg-grey w-100 align-self-start" style={{height: "58px"}} aria-label="Default select example">
                                                    <option value={-1}>{ `Beneficio desactivado` }</option>
                                                    {benefit.pay_benefit.map((payBenefit,indexPayBenefit) =>
                                                        <option key={indexPayBenefit} value={indexPayBenefit}>{ `${ new Intl.NumberFormat().format( payBenefit.coverage ) } $` }</option>
                                                    )}
                                                </select>
                                            </div>
                                            <div className={ (coverages[indexCoverages].insurer.benefits_insurer[indexBenefit].selected_benefit > 0) ? "col-6 col-md-6 d-flex justify-content-start align-items-center my-3" : "d-none" } >
                                                <h3 className="text-uppercase mon-black h5">prima de</h3>
                                            </div>
                                            <div className={ (coverages[indexCoverages].insurer.benefits_insurer[indexBenefit].selected_benefit > 0) ? "col-6 col-md-6 d-flex justify-content-start align-items-center my-3" : "d-none" }>
                                                <h3 className="text-uppercase mon-black h5 text-pink">{ coverages[indexCoverages].insurer.benefits_insurer[indexBenefit].selected_benefit } usd</h3>
                                            </div>
                                            <div className="col-12 my-3">
                                                <p className="mon-light" dangerouslySetInnerHTML={{ __html: `${benefit.benefit.description}` }}></p>
                                                {/* <p className="mon-light" id={ `${indexCoverages}-${benefit.benefit.id}-${benefit.benefit.benefit.split(" ").join("-")}-pago` }>{ showDesc(`${indexCoverages}-${benefit.benefit.id}-${benefit.benefit.benefit.split(" ").join("-") }-pago`,benefit.benefit.description) }</p> */}
                                            </div>
                                        </div>
                                        <hr className="w-100 m-1 p-0" />
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>


                </div>
                // <div key={coverage.id} className="row my-2 bg-light shadow mx-2 py-1">
                //     <div className="col-12 col-md-3 d-flex flex-column">
                //         <div className="w-100 h-100 d-flex justify-content-center align-items-center py-3">
                //             <img className="img-insurer" src={`/storage/${coverage.insurer.image}` } />
                //         </div>
                //     </div>
                //     <div className="col-12 col-md-3 d-flex flex-column">
                //         <h6 className="mon-black text-uppercase text-center">prima { frequencySelected.name }</h6>
                //         {members.map((member,indexMember) =>
                //             <div key={indexMember} className="w-100 d-flex">
                //             <div className="w-100 text-start mon-black text-dark">{member.status}</div>
                //                 <div className="w-100 text-uppercase text-end mon-black text-pink">
                //                     { rateForMember(indexCoverages,indexMember) + totalBenefits(indexCoverages) } USD
                //                 </div>
                //             </div>
                //         )}
                //         <div className="w-100 d-flex">
                //             <div className="w-100 text-uppercase text-start mon-black h3 text-pink">total</div>
                //             <div className="w-100 text-uppercase text-end mon-black h3 text-pink">{ totalForCoverage(indexCoverages) } USD</div>
                //         </div>
                //     </div>
                //     <div className="col-12 col-md-3 d-flex flex-column justify-content-center align-items-center px-3">
                //         <div data-bs-toggle="collapse" data-bs-target={`#collapse${indexCoverages}`} aria-expanded="false" aria-controls={`#collapse${indexCoverages}`} className="btn btn-benefit bg-pink py-2 px-3 rounded-pill mon-black d-flex my-2">
                //             <img src="/storage/Enmascarar grupo 24.png" />
                //             <div className="w-100 h-100 d-flex justify-content-start align-items-center mon-black text-start ps-2 text-white">Ver detalles</div>
                //         </div>
                //     </div>
                //     <div className="col-12 col-md-3 d-flex justify-content-center align-items-center px-3">
                //         <div onClick={() => sendQuote(indexCoverages) } className="btn btn-benefit bg-pink py-2 px-3 rounded-pill mon-black d-flex align-items-center my-2">
                //             <i className="bi bi-send-fill h3 text-white mb-0"></i>
                //             <div className="w-100 h-100 d-flex justify-content-start align-items-center mon-black text-start ps-2 text-white">Enviar cotizacion</div>
                //         </div>
                //         {/* <i onClick={() => sendQuote(coverage) } className="bi bi-send-fill display-6 text-success"></i> */}
                //     </div>
                //     <div className="col-12 collapse" id={`collapse${indexCoverages}`}>
                //         <div className="row">
                //             <div className="col-12 col-md-6 border-end">
                //                 <h3 className="text-uppercase text-success mon-black h5 pt-3 mb-4">beneficios incluidos</h3>
                //             {coverages[indexCoverages].insurer.benefits_insurer.map((benefit,indexBenefit) => 
                //                     <div key={indexBenefit} className={ (benefit.pay == 0) ? "d-block" : "d-none" }>
                //                         <div className="w-100 my-2 d-flex text-start text-uppercase mon-black align-items-center h4">
                //                             <img className="img-benefit" src={ `/storage/${benefit.benefit.image}` } />
                //                             <span className="ms-2 text-pink h5">{ benefit.benefit.benefit }</span> 
                //                         </div>
                //                         <div className="row">
                //                             <div className="py-3 col-12 col-md-6 d-flex justify-content-start align-items-center">
                //                                 <h3 className="text-uppercase mon-black h5">cobertura de</h3>
                //                             </div>
                //                             <div className="py-3 col-12 col-md-6 d-flex justify-content-end align-items-center">
                                                
                //                                 {benefit.pay_benefit.map((payBenefit,indexPayBenefit) =>
                //                                         // <option key={indexPayBenefit} value={indexPayBenefit}>{ `${payBenefit.coverage} USD` }</option>
                //                                         <h3 key={indexPayBenefit} className="text-uppercase mon-black text-pink h5 text-right">{ ( payBenefit.coverage == coverageSelected ) ? `${payBenefit.rate} USD` : "" }</h3>
                //                                 )}
                //                             </div>
                //                             <div className="col-12 my-2">
                //                                 <p className="mon-light">{benefit.benefit.description}</p>
                //                             </div>
                //                         </div>
                //                         <hr className="w-100 m-0 p-0" />
                //                     </div>
                //                 )}
                //             </div>
                //             <div className="col-12 col-md-6">
                //             <h3 className="text-uppercase text-warning mon-black h5 pt-3 mb-4">beneficios pagos</h3>
                //                 {coverages[indexCoverages].insurer.benefits_insurer.map((benefit,indexBenefit) => 
                //                     <div key={indexBenefit} className={ (benefit.pay == 1) ? "d-block" : "d-none" }>
                //                         <div className="w-100 my-2 d-flex text-start text-uppercase mon-black align-items-center h4">
                //                             <img className="img-benefit" src={ `/storage/${benefit.benefit.image}` } />
                //                             <span className="ms-2 text-pink h5">{ benefit.benefit.benefit }</span> 
                //                         </div>
                //                         <div className="row">
                //                             <div className="col-12 col-md-6 d-flex justify-content-start align-items-center">
                //                                 <h3 className="text-uppercase mon-black h5">cobertura de</h3>
                //                             </div>
                //                             <div className="col-12 col-md-6">
                //                                 <select onChange={ (e) => selectPayBenefit(e,indexCoverages,indexBenefit) } className="form-select shadow-none border-0 bg-grey w-100 align-self-start" style={{height: "58px"}} aria-label="Default select example">
                //                                     <option value={-1}>{ `Beneficio desactivado` }</option>
                //                                     {benefit.pay_benefit.map((payBenefit,indexPayBenefit) =>
                //                                         <option key={indexPayBenefit} value={indexPayBenefit}>{ `${payBenefit.coverage} USD` }</option>
                //                                     )}
                //                                 </select>
                //                             </div>
                //                             <div className={ (coverages[indexCoverages].insurer.benefits_insurer[indexBenefit].selected_benefit > 0) ? "col-12 col-md-6 d-flex justify-content-start align-items-center my-3" : "d-none" } >
                //                                 <h3 className="text-uppercase mon-black h5">prima de</h3>
                //                             </div>
                //                             <div className={ (coverages[indexCoverages].insurer.benefits_insurer[indexBenefit].selected_benefit > 0) ? "col-12 col-md-6 d-flex justify-content-start align-items-center my-3" : "d-none" }>
                //                                 <h3 className="text-uppercase mon-black h5 text-pink">{ coverages[indexCoverages].insurer.benefits_insurer[indexBenefit].selected_benefit } usd</h3>
                //                             </div>
                //                             <div className="col-12 my-2">
                //                                 <p className="mon-light">{benefit.benefit.description}</p>
                //                             </div>
                                            
                //                         </div>
                //                         <hr className="w-100 m-1 p-0" />
                //                     </div>
                //                 )}
                //             </div>
                //         </div>
                //     </div>
                // </div>
            )}
            </div>
            <div className='position-fixed w-100 h-100 start-0 top-0 zi-1000 justify-content-center align-items-center' style={modal}>
                <div className='row w-100'>
                    <div className='col-12 col-md-10 offset-md-1 bg-white shadow'>
                    <div className='row'>
            <div className="col-10">
                <h3 className='mon-black text-wine text-center py-3'>Integrantes</h3>
            </div>
            <div className="col-2 d-flex justify-content-end align-items-center">
                <button onClick={closeModalMember} type="button" className="btn bg-pink text-white rounded-pill  px-2 py-2 m-2">Cerrar</button>
            </div>
            </div>
                <CotizadorModal/>
                        
                    </div>
                </div>
            </div>
        </div>
        
    );
}



if (document.getElementById('cotizacion')) {
    ReactDOM.render(
    <GlobalProvider>
        <Cotizacion />
    </GlobalProvider>
    , document.getElementById('cotizacion'));
}