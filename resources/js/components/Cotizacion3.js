import React from 'react';
import ReactDOM from 'react-dom';
import { useState, useEffect } from "react";

function Cotizacion() {

    const [coveragesList, setCoveragesList] = useState([]);
    const [frequencySelected, setFrequencySelected] = useState({ "frequency" : 1 , "name" : "Anual" });
    const [frequencies, setFrequencies] = useState([]);
    const [coverageSelected, setCoverageSelected] = useState(0);
    const [coverages, setCoverages] = useState([]);
    const [members, setMembers] = useState([]);

    useEffect(() => {

        fetch("/api/frequency")
          .then((response) => response.json())
          .then((data) => {
                setFrequencies([...data]);
          });

        fetch("/api/coverages")
          .then((response) => response.json())
          .then((data) => {
                setCoveragesList([...data]);
          });

          fetch(`/api/salud/cotizacion/${ window.location.href.split("/")[window.location.href.split("/").length - 1] }`)
          .then((response) => response.json())
          .then((data) => {
                console.log("Coverage by Phone = ",data);
                setMembers(data.memberquote);
                setCoverageSelected(data.coverage); 
                setCoverages(data.coverages);
          });
    },[]);

    const changeCoverage = async (e) => {
        setCoverageSelected(e.target.value);
        const resp = await fetch(`/api/salud/cotizacion/${ window.location.href.split("/")[window.location.href.split("/").length - 1] }/${e.target.value}`)
        const data = await resp.json();
        
        setMembers(data.memberquote);
        setCoverageSelected(data.coverage); 
        setCoverages(data.coverages);
        console.log("Coverage by Phone = ",coverages);
    }

    const rateForMember = (indexCoverages,indexMember) => {
        for (let index = 0; index < coverages[indexCoverages].rates.length; index++) {
            if(members[indexMember].date >= coverages[indexCoverages].rates[index].from  && members[indexMember].date <= coverages[indexCoverages].rates[index].to){
                return (coverages[indexCoverages].rates[index].rate / frequencySelected.frequency) ;
            }
        }
        return 0;
      }

      const changeFrequency = (e) => {
        setFrequencySelected( JSON.parse(e));
    }

    const totalForCoverage = (indexCoverage) => {
        let total = 0;
        for (let index = 0; index < members.length; index++) {
            total += rateForMember(indexCoverage,index);
        }
        return total;
    }

    const showDesc = (id,desc) => {
        $("#" + id).html(desc);
    }

    return (
    <div>
        <div className='container'>
            <div className='row'>
                <div className='col-12'> { coverageSelected } </div>
                <div className='col-md-6'>
                <select value={ coverageSelected } onChange={ changeCoverage } className="form-select shadow-none border-0 bg-grey w-100 align-self-start" style={{"height" : "58px" }} aria-label="Default select example">
                    {coveragesList.map((coverage,indexCoverage) =>
                        <option key={indexCoverage} value={coverage.coverage}>{ new Intl.NumberFormat().format(coverage.coverage) }$</option>
                    )}
                    </select>
                </div>
                <div className='col-md-6'>
                <select onChange={ (e) => changeFrequency(e.target.value) } className="form-select shadow-none border-0 bg-grey w-100 align-self-start text-capitalize" style={{"height" : "58px" }} aria-label="Default select example">
                    {frequencies.map((frequency,indexfrequency) =>
                        <option className="text-capitalize" key={indexfrequency} value={ JSON.stringify( frequency )}>{frequency.name}</option>
                    )}
                    </select>
                </div>
                <div className='col-12' id="accordionExample">
                    {coverages.map((coverage,indexCoverages) =>
                        <div key={indexCoverages} className="accordion-item row my-3 shadow">
                            <div className="col-12 col-md-3 d-flex flex-column">
                                <div className="w-100 h-100 d-flex justify-content-center align-items-center py-3">
                                    <img className="img-insurer" src={`/storage/${coverage.insurer.image}` } />
                                </div>
                            </div>

                            <div className="col-12 col-md-3 d-flex flex-column">
                                <h6 className="mon-black text-uppercase text-center mt-2">prima</h6>
                                {members.map((member,indexMember) =>
                                    <div key={indexMember} className="w-100 d-flex">
                                        <div className="w-100 text-start mon-black text-dark">{member.status}</div>
                                        <div className="w-100 text-uppercase text-end mon-black text-pink">
                                            {rateForMember(indexCoverages,indexMember)} USD
                                        </div>
                                    </div>    
                                )}
                                <div className="w-100 d-flex">
                                    <div className="w-100 text-uppercase text-start mon-black h3 text-pink">total</div>
                                    <div className="w-100 text-uppercase text-end mon-black h3 text-pink">{ totalForCoverage(indexCoverages) } USD</div>
                                </div>
                            </div>
                            <div className="col-12 col-md-3 d-flex flex-column justify-content-center align-items-center px-3">
                                <div data-bs-toggle="collapse" data-bs-target={`#collapse${indexCoverages}`} aria-expanded="false" aria-controls={`#collapse${indexCoverages}`} className="btn btn-benefit bg-pink py-2 px-3 rounded-pill mon-black d-flex my-2">
                                    <img src="/storage/Enmascarar grupo 24.png" />
                                    <div className="w-100 h-100 d-flex justify-content-start align-items-center mon-black text-start ps-2 text-white">Ver detalles</div>
                                </div>
                            </div>
                            <div id={`collapse${indexCoverages}`} className="accordion-collapse collapse col-12" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div className="row" key={`${indexCoverages}-${indexCoverages}`}>
                                    <div className='col-12'>
                                    {coverages[indexCoverages].insurer.benefits_insurer.map((benefit,indexBenefit) => 
                                        <div>
                                            <h3>{ benefit.benefit.benefit }</h3>
                                            <p dangerouslySetInnerHTML={{ __html: `${benefit.benefit.description}` }}></p>
                                            {/* <p id={`${indexCoverages}-${benefit.benefit.id}-${benefit.benefit.benefit.split(" ").join("-")}-pago`}>{ showDesc(`${indexCoverages}-${benefit.benefit.id}-${benefit.benefit.benefit.split(" ").join("-")}-pago`,benefit.benefit.description) }</p> */}
                                        </div>
                                    )}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    )}
                </div>

                

            </div>
        </div>
    </div>
    );
}

export default Cotizacion;

if (document.getElementById('cotizacion')) {
    ReactDOM.render(<Cotizacion />, document.getElementById('cotizacion'));
}