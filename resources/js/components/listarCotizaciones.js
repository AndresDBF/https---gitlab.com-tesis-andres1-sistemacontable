import React from 'react';
import ReactDOM from 'react-dom';
import { useState,useEffect } from "react";
import moment  from "moment";

function ListarCotizaciones() {
    
    const [page,setPage] = useState( parseInt(location.href.split("/")[5]) );
    const [quotes,setQuotes] = useState([]);
    const [pagination,setPagination] = useState([]);
    const [countPage,setCountPage] = useState(0);

    useEffect(() => {

        
        getCotizacion();
        setInterval( async () => {
            getCotizacion();
            //changeList();
        //     console.log("Page: ",page);
        //     // let response = await fetch(`/api/getCotizacionesByOrder?page=${page}`)
        //     // let data = await response.json();
        //     // console.log(data);
        //     // setQuotes([...data.data]);
        //     // setPagination([...data.links]);
        //     // setCountPage( data.links.length );
         },5000);

      },[]);

    const getCotizacion = () => {
        fetch(`/api/getCotizacionesByOrder?page=${page}`)
          .then((response) => response.json())
          .then((data) => {
              console.log("DATA : ",data);
              setQuotes([...data.data]);
              setPagination([...data.links]);
              setCountPage( data.links.length );
          });
    }

    const changePage = async (p) => {
        window.location.href = `${location.host}/admin/listar-cotizaciones/${p.label}`;
        console.log(`${location.host}/admin/listar-cotizaciones/${p.label}`)
        // let response = await fetch(p.url);
        // let data = await response.json();
        // console.log(data);
        // setQuotes([...data.data]);
        // setPagination([...data.links]);
        // setCountPage( data.links.length );
        // setPage(p.label);
        // console.log("Change page = ",page);
    }

    const changeList = async () => {
        console.log(`/api/getCotizacionesByOrder?page=${page}`);
        let response = await fetch(`/api/getCotizacionesByOrder?page=${page}`);
        let data = await response.json();
        setQuotes([...data.data]);
        setPagination([...data.links]);
        setCountPage( data.links.length );
        console.log("Change page = ",page);
    }

    return (
        <div>
            <div className="btn-group" style={{display: "flex",marginBottom: "20px"}} role="group" aria-label="...">
                {
                    pagination.map((p,indexPagination) =>
                        <div key={indexPagination} style={{marginRight: "5px"}}>
                            { ( indexPagination > 0 && indexPagination < countPage -1 ) ? <a href={`/admin/listar-cotizaciones/${p.label}`}  className="btn btn-primary">{p.label}</a> : "" }
                        </div>
                    )
                }
                
                {/* <button onClick={ () => changePage(1) } type="button" className="btn btn-primary">
                    <i className="glyphicon glyphicon-chevron-right"></i>
                </button> */}
            </div>

            { quotes.map( (quote,indexQuote) =>
                <div key={indexQuote} className="jumbotron" style={ { "padding" : "10px" } }>
                    <h4 className='my-0 py-0'>{ quote.name } {quote.last_name}</h4>
                    <h6 className='my-0 py-0'>Teléfono: {quote.phone}</h6>
                    <h6 className='my-0 py-0'>E-mail: {quote.email}</h6>
                    <h4 className='my-0 py-0'>Fecha: { moment(quote.created_at).format("D-M-y") }</h4>
                    <h5 className='my-0 py-0'>Cobertura de <strong>{ quote.coverage } USD</strong>  </h5>
                    <h4>Beneficiarios</h4>
                    { quote.memberquote.map( (member,indexMember) => 
                        <h6 key={indexMember}>{member.status}, {member.date} años, {member.gender}</h6>
                    )}
                    
                </div>
            )}
            
        </div>
    );
}

export default ListarCotizaciones;

if (document.getElementById('listarCotizaciones')) {
    ReactDOM.render(<ListarCotizaciones />, document.getElementById('listarCotizaciones'));
}