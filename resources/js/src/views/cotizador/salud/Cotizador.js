import { React,useContext,useState,useEffect } from 'react';
import ReactDOM from 'react-dom';
import { GlobalContext } from "../../../context/GlobalProvider";
import { DatosPersonales } from "../../../components/Forms/DatosPersonales";
import { PersonasAsegurar } from "../../../components/Forms/PersonasAsegurar";
import { ButtonAddMember } from "../../../components/Forms/ButtonAddMember";
import { useNavigate } from "react-router-dom";

export const Cotizador = () => {

    const [coverages,setCoverages] = useState([]);
    const {name,setName} = useContext(GlobalContext);
    const {lastName,setLastName} = useContext(GlobalContext);
    const {code,setCode} = useContext(GlobalContext);
    const {phone,setPhone} = useContext(GlobalContext);
    const {email,setEmail} = useContext(GlobalContext);
    const {province,setProvince} = useContext(GlobalContext);
    const {coverage,setCoverage} = useContext(GlobalContext);
    const {personasAsegurar,setPersonasAsegurar} = useContext(GlobalContext);

    const {artists, setArtists} = useContext(GlobalContext);

    const navigate = useNavigate();

    

    useEffect( async () => {
        let response = await fetch("/api/coverages");
        setCoverages(await response.json() );

        setPersonasAsegurar([{
            id: Math.random() * 1000,
            status: "Yo",
            gender: "Masculino",
            day: 0,
            month: 0,
            year: 0
        }])

    },[]);

    const cotizarSalud = async (e) => {
        e.preventDefault();
        let response = await fetch("/api/cotizarSalud",{
            method: "POST",
            body: JSON.stringify({
                name: name,
                lastName: lastName,
                code: code,
                phone: phone,
                email: email,
                province: province,
                coverage: coverage,
                personasAsegurar: personasAsegurar
            }),
            headers: {"Content-type": "application/json; charset=UTF-8"}
        });
        
        let r = await response.json();
        if( r.status ){
            let resp = await fetch(`/api/checkPhone/${code}${phone}`);
            let check = await resp.json();
            console.log(check);
            if( check.status == true ){
                navigate(`/cotizador/salud/${code}${phone}`);
            } else {
                $('#myModal').show();
            }
        }
    }

    const verifyCode = () => {
        fetch(`/api/verifyCode/${code}${phone}/${ document.getElementById("codesend").value }`)
            .then(response => response.json())  // convertir a json
            .then(json => {
                if(json.status){
                    navigate(`/cotizador/salud/${code}${phone}`);
                    // $("#alert-scss").fadeIn();
                    // document.getElementById("form-cot").submit()
                } else {
                    alert("Codigo erroneo")
                    // $("#alert-dng").fadeIn();
                }
            })    //imprimir los datos en la consola
            .catch(err => console.log('Solicitud fallida', err));
    }

    let resendCode = async () => {
        let resp = await fetch(`/api/checkPhone/${code}${phone}`);
            let check = await resp.json();
            console.log(check);
            if( check.status == true ){
                navigate(`/cotizador/salud/${code}${phone}`);
            } else {
                $('#myModal').show();
            }
    }

    return (
        <div className='container'>
            <div className='row'>
                <div className='col-12'>
                    <h1 className='mon-black text-secondary text-center display-4 my-5 text-uppercase'>COTIZA TU Póliza INGRESA TUS DATOS</h1>
                </div>
                <div className='col-12'>
                    <form onSubmit={ (e) => cotizarSalud(e) } className='shadow-lg rounded p-3 pb-5 mb-5'>
                        <div className='container'>
                            <DatosPersonales/>
                            <hr/>
                            <div className='row'>
                                <div className='col-12 col-md-4 my-4'>
                                    <h3 className='mon-bold text-uppercase text-secondary'>SUMA ASEGURADA</h3>
                                    <select defaultValue={0} onChange={ (e) => setCoverage(e.target.value) } className='form-select shadow-none border-0 bg-light' style={ { height: "58px" } } required>
                                        {coverages.map((c,indexCoverage) =>
                                            <option key={indexCoverage} value={ c.coverage }>{ c.coverage.toLocaleString('es-MX') }</option>
                                        )}
                                    </select>
                                </div>
                                <hr/>
                            </div>
                            <PersonasAsegurar/>
                            <div className='row'>
                                <div className='col-12 d-flex flex-column flex-md-row justify-content-center'>
                                    <ButtonAddMember />
                                    <button type="submit" className='btn btn-primary my-2 rounded-pill text-white mon-regular p-3'>Encuentra tu póliza ideal</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div className="modal" id="myModal">
                <div className="modal-dialog">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h5 className="modal-title">Verificacion de Telefono</h5>
                            <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div className="modal-body">
                            <div className="col-12 my-3">
                                <div className="form-floating mb-3 w-10">
                                    <input id="codesend" required name="codesend" type="text" className="form-control shadow-none border-0 bg-grey"/>
                                    <label className="mon-regular">Codigo</label>
                                </div>
                                <div onClick={resendCode} className='text-pink fw-bold'>reenviar codigo</div>
                            </div>
                        </div>
                        <div className="modal-footer">
                            <button onClick={verifyCode} type="button" className="btn bg-pink text-white">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}