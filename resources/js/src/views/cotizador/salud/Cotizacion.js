import { React,useContext,useState,useEffect } from 'react';
import ReactDOM from 'react-dom';
import { GlobalContext } from "../../../context/GlobalProvider";
import { SelectCoverage } from "../../../components/Salud/SelectCoverage";
import { RadioFrecuencies } from "../../../components/Salud/RadioFrecuencies";
import { useNavigate } from "react-router-dom";
import { useParams } from "react-router-dom";
import { useHttp } from "../../../hooks/useHttp";
import { PersonasAsegurar } from "../../../components/Forms/PersonasAsegurar";
import { ButtonAddMember } from "../../../components/Forms/ButtonAddMember";
import { Modal } from 'bootstrap';


export const Cotizacion = (props) => {

    const { phone } = useParams();
    const { insurerCoverage, setInsurerCoverage } = useContext(GlobalContext);
    const {frequency,setFrequency} = useContext(GlobalContext);
    const {personasAsegurar,setPersonasAsegurar} = useContext(GlobalContext);
    const {quote,setQuote} = useContext(GlobalContext);
    const {frequencyName, setFrequencyName} = useContext(GlobalContext);
    const {message,setMessage} = useContext(GlobalContext);

    useEffect(async() => {
      console.log("personasAsegurar: ",personasAsegurar)

      let response = await fetch(`/api/getQuoteByPhone/${phone}`);
        let cs = await response.json();
        setQuote(cs);

    },[]);

    const getRateByMember = (x,rate) => {
      
      //console.log( "a", addBenefitByMember(x) );
      return (rate + addBenefitByMember(x)) / frequency;
    }

    const getRateTotal = ( a ) => {
      let total = 0;
      for (let j = 0; j < insurerCoverage[a].coverages.members.length; j++) {
        total += getRateByMember(a,insurerCoverage[a].coverages.members[j].rate);
      }
      return total;
    }

    const selectBenefit = (indexCoverage,indexBenefit,indexOptionBenefit) => {
      for (let index = 0; index < insurerCoverage[indexCoverage].benefits[indexBenefit].pay_benefit.length; index++) {
        insurerCoverage[indexCoverage].benefits[indexBenefit].pay_benefit[index].selected = 0;
      }
      
      if( indexOptionBenefit != -1  ){
        insurerCoverage[indexCoverage].benefits[indexBenefit].pay_benefit[indexOptionBenefit].selected = 1;
        insurerCoverage[indexCoverage].benefits[indexBenefit].selected_benefit = insurerCoverage[indexCoverage].benefits[indexBenefit].pay_benefit[indexOptionBenefit].rate;
        insurerCoverage[indexCoverage].benefits[indexBenefit].coverage = insurerCoverage[indexCoverage].benefits[indexBenefit].pay_benefit[indexOptionBenefit].coverage;
      } else if( indexOptionBenefit == -1 ){
        insurerCoverage[indexCoverage].benefits[indexBenefit].selected_benefit = 0;
      }
      let i = insurerCoverage;
      setInsurerCoverage([...i]);
      // if( indexOptionBenefit != -1  ){
      //   insurerCoverage[indexCoverage].benefits[indexBenefit].pay_benefit[indexOptionBenefit].selected = 1;
      //   let i = insurerCoverage;
      //   insurerCoverage[indexCoverage].benefits[indexBenefit].selected_benefit = insurerCoverage[indexCoverage].benefits[indexBenefit].pay_benefit[indexOptionBenefit].rate;
      //   setInsurerCoverage([...i]);
      // } else {
      //   for (let index = 0; index < insurerCoverage[indexCoverage].benefits[indexBenefit].pay_benefit.length; index++) {
      //     insurerCoverage[indexCoverage].benefits[indexBenefit].pay_benefit[index].selected = 0;
      //   }
      //   insurerCoverage[indexCoverage].benefits[indexBenefit].selected_benefit = 0;
      //   let i = insurerCoverage;
      //   setInsurerCoverage([...i]);
      // }
      
    }

    const addBenefitByMember = (index) => {
      let totalBenefit = 0;

      for (let i = 0; i < insurerCoverage[index].benefits.length; i++) {
        if( insurerCoverage[index].benefits[i].pay == 1 ){
          for (let j = 0; j < insurerCoverage[index].benefits[i].pay_benefit.length; j++) {
            if(insurerCoverage[index].benefits[i].pay_benefit[j].selected == 1){
              totalBenefit += insurerCoverage[index].benefits[i].pay_benefit[j].rate;
            }
          }
        }
      }
        
      
      return totalBenefit;
    }

    const sendCotizacion = async (cotizacion,type) => {
      console.log(cotizacion);
      let response = await fetch("/api/sendCotizacion",{
        method: "POST",
        body: JSON.stringify({
          cotizacion: cotizacion,
          phone: phone
        }),
        headers: {"Content-type": "application/json; charset=UTF-8"}
      });

      let data = await response.json();
      console.log(`${data.file}`)
      alert("Cotizacion enviada al correo electronico")
      if(type){
        let space = "%20";
        let enter = "%0A";
        let message = `Hola ${quote.name}${space}${quote.last_name} *LINK* ${data.file}`;
        window.open(`https://wa.me/+584247089641?text=${message}`, '_blank');
        return null;
      }
      console.log(`${data.file}`)
      window.open(`${data.file}`, '_blank');

    }

    const changeMembersByQuote = async () => {
      let response = await fetch("/api/changeMembersByQuote",{
        method: "POST",
        body: JSON.stringify({
          phone: phone,
          personasAsegurar: personasAsegurar
        }),
        headers: {"Content-type": "application/json; charset=UTF-8"}
    });

    let data = response.json();

    response = await fetch(`/api/getCotizacionSalud/${phone}`);
    let ic = await response.json();
    setInsurerCoverage( ic.data );
    setMessage(ic.message);
    alert("Miembros actualizados.");
    $('#exampleModal').modal('hide');
  }

  const updateMembers = async () => {
    let response = await fetch(`/api/changeMembersByQuote/${phone}`);
    let m = await response.json();
    console.log(m);
    setPersonasAsegurar([...m]);
  }

    return (
        <div className='pt-5'>
            <h3 className='mon-black text-secondary mb-5 text-center'>COBERTURAS QUE TE OFRECEMOS</h3>
            <div className='container'>
                <div className='row sticky-top'>
                    <div className='col-12 shadow-lg rounded bg-white py-4 px-5'>
                        <div className='row'>
                            <div className='col-12 col-md-4'>
                                <h4 className='mon-black text-secondary text-center py-1 h6'>TU COBERTURA O SUMA ASEGURADA</h4>
                                <SelectCoverage />
                            </div>
                            <div className='col-12 col-md-4'>
                            <h4 className='mon-black text-secondary text-center py-1 h6'>FORMAS DE PAGO</h4>
                                <RadioFrecuencies />
                            </div>
                            <div className='col-12 col-md-4 d-flex justify-content-center align-items-center'>
                              <div onClick={updateMembers} className='btn rounded-pill shadow-lg p-3' data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <img width="30px" src="/storage/anadir-grupo-04.png" />
                                <span className='mon-light text-secondary ms-2 text-secondary'>Editar integrantes</span>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className='row mt-4'>
                  <div>
                    <h2 style={ ( message != "" ) ? { "display" : "block" } : { "display" : "none" } } className='mon-black text-secondary text-uppercase text-center my-5'>{ message }</h2>
                  </div>
                  {insurerCoverage.map((ic,indexInsurerCoverage) => 
                    <div key={indexInsurerCoverage} className='col-12 py-1 px-0'>
                    <div className="accordion w-100 shadow-lg" id="accordionExample">
                      <div className="accordion-item">
                        <div className="accordion-header bg-white" id={`heading${indexInsurerCoverage}`}>
                          <div className='row m-0 p-3'>
                            <div className='col-12 col-md-2 p-2 d-flex justify-content-center align-items-center'>
                              <img width="100%" src={ `/storage/${ic.image}` } />
                            </div>
                            <div className='col-12 col-md-2 p-0 d-flex flex-column justify-content-center align-items-center'>
                              <h3 className='mon-black text-primary h6'>COBERTURA HCM</h3>
                              <span className='mon-black text-dark h4'>{ ic.coverages.coverage.toLocaleString('es-MX') } USD</span>
                            </div>
                            <div className='col-12 col-md-3 p-0 px-3 d-flex flex-column'>
                              <div className='w-100 h-100 text-center mb-2'>
                                <h4 className='mon-black text-primary text-center h6 mb-0'>PRIMA {frequencyName.toUpperCase() }</h4>
                              </div>
                              {ic.coverages.members.map((m,indexMember) => 
                                <div key={indexMember} className='w-100 h-100 d-flex justify-content-between'>
                                  <span className={ getRateByMember(indexInsurerCoverage,m.rate) > 0 ? 'text-dark mon-bold' : 'text-muted mon-bold' }  style={ (getRateByMember(indexInsurerCoverage,m.rate) == 0) ? { textDecorationLine: "line-through" } : {} }>{m.status} <b>({ m.date })</b></span>
                                  <span className={ getRateByMember(indexInsurerCoverage,m.rate) > 0 ? 'text-primary mon-black' : 'text-muted mon-black' } style={ (getRateByMember(indexInsurerCoverage,m.rate) == 0) ? { textDecorationLine: "line-through" } : {} }>{ getRateByMember(indexInsurerCoverage,m.rate).toLocaleString('es-MX') } USD</span>
                                </div>
                              )}
                              
                              <div className='w-100 h-100 mt-2 d-flex justify-content-between'>
                                <span className='text-dark mon-black h4'>Total</span>
                                <span className='text-primary mon-black h4'>{ getRateTotal(indexInsurerCoverage).toLocaleString('es-MX') } USD</span>
                              </div>
                            </div>
                            <div className='col-12 col-md-5 p-0 px-3  d-flex justify-content-around align-items-center'>
                              <span onClick={ () => sendCotizacion(ic,true) } className='btn rounded-pill bg-primary fs-sm text-white p-2 mon-bold shadow-lg mx-2'>
                                <img className='me-2' width="15" src="/storage/paper-plane-solid.png" />
                                Enviar Cotizacion 
                              </span>
                              <span className='btn rounded-pill bg-light fs-sm text-primary p-2 mon-bold shadow-lg mx-2' data-bs-toggle="collapse" data-bs-target={`#collapse${indexInsurerCoverage}`} aria-expanded="false" aria-controls={`collapse${indexInsurerCoverage}`}>
                                <img className='me-2' width="15" src="/storage/eye-solid.png" />
                                Ver Detalles
                              </span>
                              <span onClick={ () => sendCotizacion(ic,false) } className='btn rounded-pill bg-light fs-sm text-primary p-2 mon-bold shadow-lg mx-2'>
                                <img className='me-2' width="15" src="/storage/circle-down-regular.png" />
                                Descargar cotización
                              </span>

                            </div>
                          </div>
                        </div>
                        <div id={`collapse${indexInsurerCoverage}`} className="accordion-collapse collapse" aria-labelledby={`heading${indexInsurerCoverage}`} data-bs-parent="#accordionExample">
                          <div className="accordion-body">
                            <span className='mon-black text-dark'>Nota: </span>
                            <div className='row'>
                              <div className='col-12 col-md-6'>
                                <h3 className='mon-black text-success h4 my-2'>BENEFICIOS INCLUIDOS</h3>
                                { ic.benefits.map((b,indexBenefits) => 
                                  <div key={ indexBenefits }>
                                    {(b.pay == 0 ) &&
                                    <div className='w-100 my-4'>
                                      <div className='w-100 d-flex justify-content-start align-items-center '>
                                        <img width="30" src={ `/storage/${b.benefit.image}` } />
                                        <span className='mon-black text-secondary ms-2 text-uppercase'>{ b.benefit.benefit }</span>
                                      </div>
                                      {(b.pay_benefit.length == 1) &&
                                        <div className='w-100 d-flex justify-content-between my-3'>
                                          <div className='mon-bold text-dark h3'>COBERTURA DE</div>
                                          <div className='mon-black text-secondary h3'>
                                            {b.pay_benefit[0].coverage.toLocaleString('es-MX')} USD
                                          </div>
                                        </div>
                                      }
                                      <div className='mon-light mt-2' dangerouslySetInnerHTML={{ __html: `${b.benefit.description}` }}></div>
                                      <hr/>
                                    </div>
                                  }
                                  </div>
                                 
                                  
                                )}

                              </div>
                              <div className='col-12 col-md-6 border-start'>
                                <h3 className='mon-black text-warning h4 my-2'>BENEFICIOS PAGOS</h3>
                                { ic.benefits.map((b,indexBenefit) => 
                                  
                                 <div>
                                  {
                                    (b.pay == 1) &&
                                    <div>
                                      <div className='w-100 d-flex justify-content-start align-items-center '>
                                        <img width="30" src={ `/storage/${b.benefit.image}` } />
                                        <span className='mon-black text-secondary ms-2 text-uppercase'>{b.benefit.benefit}</span>
                                      </div>
                                      <div className='w-100 d-flex justify-content-between align-items-center my-3'>
                                      <div className='mon-bold text-dark h3'>COBERTURA DE</div>
                                        <div className='h3'>
                                          <select onChange={ (e) => selectBenefit(indexInsurerCoverage,indexBenefit,e.target.value) } className='form-select shadow-none border-0 bg-light' style={ { height: "58px" } } required>
                                            <option value={-1}>Seleccione cobertura</option>
                                              { b.pay_benefit.map((pb,indexPayBenefit) => 
                                                <option key={indexPayBenefit} selected={ pb.selected == 1 ? true : false } value={ indexPayBenefit }>{ pb.coverage.toLocaleString('es-MX') }</option>
                                              )}
                                          </select>
                                        </div>
                                      </div>
                                      <div className='w-100 d-flex justify-content-between my-3'>
                                        <div className='mon-bold text-dark h3'>PRIMA DE</div>
                                        <div className='mon-black text-secondary h3'>{b.selected_benefit.toLocaleString('es-MX')} USD</div>
                                      </div>
                                      <div className='mon-light mt-2' dangerouslySetInnerHTML={{ __html: `${b.benefit.description}` }}></div>
                                      <hr/>
                                    </div>
                                    
                                  }
                                 </div> 
                                    
                                  
                                  
                                )}
                                
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  )}
                  
                </div>
            </div>
            <div className="modal fade" id="exampleModal" tabIndex="-1">
              <div className="modal-dialog modal-xl">
                <div className="modal-content">
                  <div className="modal-header">
                    <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div className="modal-body">
                    <PersonasAsegurar/>
                    <div className='w-100 d-flex justify-content-center mb-3'>
                      <ButtonAddMember />
                      <div onClick={ () => changeMembersByQuote() } className='btn bg-primary rounded-pill text-white mon-light d-flex justify-content-center align-items-center ms-2'>Guardar integrantes</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
    );
}