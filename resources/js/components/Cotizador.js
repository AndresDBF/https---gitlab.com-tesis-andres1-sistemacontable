import React from 'react';
import ReactDOM from 'react-dom';
import moment from 'moment';
import { useState,useEffect } from "react";

function Cotizador() {

    const [familiar, setFamiliar] = useState([{
        "status" : "",
        "gender" : "",
        "date" : "",
        "show": false
    }]);
    const [status, setStatus] = useState([]);
    const [gender, setGender] = useState([]);

    const [day, setDay] = useState([]);
    const [mounth, setMounth] = useState([]);
    const [year, setYear] = useState([]);

    const [phone, setPhone] = useState("");
    const [currentStatusValue,setCurrentStatusValue] = useState();

    useEffect(() => {

        let days = [];
        for (let index = 1; index <= 31; index++) {
            days.push(index);
            
        }
        setDay(days);

        let mounths = [];
        for (let index = 1; index <= 12; index++) {
            mounths.push(index);
            
        }
        setMounth(mounths);

        let years = [];
        //for (let index = new Date().getFullYear()  - 100; index <= new Date().getFullYear() - 1 ; index++) {
            for (let index = new Date().getFullYear()  - 1; index >= new Date().getFullYear() - 100 ; index--) {
            years.push(index);
            
        }
        setYear(years);

        fetch("/api/status")
            .then((res) => res.json())
            .then((data) => setStatus(data));

        fetch("/api/gender")
            .then((res) => res.json())
            .then((data) => setGender(data));
    },[]);

    const addFamiliar = () => {
        

        setFamiliar([...familiar, {
            "status" : "",
            "gender" : "",
            "date" : "",
            "show": true
        }]);
    }

    const removeFamiliar = (i) => {
        familiar.splice(i,1);
        console.log(familiar)
        setFamiliar([...familiar]);
    }

    const changeDate = (e,i) => {
        console.log(e)
        if( e.target.value.length == 2 && e.keyCode != 8 || e.target.value.length == 5 && e.keyCode != 8 ){
            e.target.value = `${e.target.value}-`;
        }

        if( e.target.value.length == 10 ){
            e.target.value = e.target.value.slice(0,-1);
        }
        // var a = moment(moment().format('YYYY-MM-DD'));
	    // var b = moment(e.target.value);

    	// var years = a.diff(b, 'year');
        // console.log(years);
        // familiar[i].date = years;
        // console.log("Familiar",familiar);
        // setFamiliar([...familiar]);
    }

    const focusStatus = (e) => {
        setCurrentStatusValue(e.target.value);
    }

    const changeStatus = (e,i) => {
        //let parentesco = document.getElementsByClassName("parentesco");//[1].value = "Esposa";
        //console.log("parentesco",parentesco)
        
        for (let index = 0; index < status.length; index++) {
            //const element = array[index];
            
            if( status[index].status == currentStatusValue ){
                status[index].selected = 0;
            }

            if( status[index].status == e.target.value  ){
                status[index].selected = 1;
            }
        }

        setCurrentStatusValue(null);

        setStatus([...status]);
        console.log(status)
        
        familiar[i].status = e.target.value;
        setFamiliar([...familiar]);
    }

    const changeGender = (e,i) => {
        familiar[i].gender = e.target.value;
        setFamiliar([...familiar]);
    }

    const clickStatus = (e) => {
        console.log("Click",e)
    }

    const verifyFormatDate = (e) => {
        // if( e.target.value.split("-").length != 3 ){
        //     alert("Formato de fecha incorrecto");
        //     return null;
        // }

        // e.target.value.split("-").map((d) => {
        //     if( isNaN( parseInt(d) ) ){
        //         alert(`Formato de fecha no numerico ${d}`)
        //         return null;
        //     }
        // });

    }

    const sendCot = () => {
        $("#panel-load").css("display" , "block" )
        setPhone(document.getElementById("input-code").value + document.getElementById("input-phone").value);
        localStorage.setItem("phone",document.getElementById("input-code").value + document.getElementById("input-phone").value)
        
        let p = localStorage.getItem("phone");
        console.log(`/api/checkPhone/${p}`)
        fetch(`/api/checkPhone/${p}`)
            .then(response => response.json())  // convertir a json
            .then(json => {
                if(json.status){
                    //$("#panel-load").fadeOut();
                    $("#panel-load").css("display" , "none" )
                    document.getElementById("form-cot").submit()
                } else {
                    //$("#panel-load").fadeOut();
                    $("#panel-load").css("display" , "none" )
                    alert("Codigo enviado a tu telefono")
                    $('#myModal').show();
                }
            })    //imprimir los datos en la consola
            .catch(err => console.log('Solicitud fallida', err));
        //document.getElementById("form-cot").submit()
    }

    const verifyCode = () => {
        fetch(`/api/verifyCode/${phone}/${ document.getElementById("codesend").value }`)
            .then(response => response.json())  // convertir a json
            .then(json => {
                if(json.status){
                    $("#alert-scss").fadeIn();
                    document.getElementById("form-cot").submit()
                } else {
                    alert("Codigo erroneo")
                    $("#alert-dng").fadeIn();
                }
            })    //imprimir los datos en la consola
            .catch(err => console.log('Solicitud fallida', err));
    }

    const closeModal = () => {
        $('#myModal').hide();
    }


    return (
        <div>
            <div className="col-12 mt-3">
                {familiar.map((f,indexFamiliar) =>
                    <div className="row mt-3 p-3 shadow rounded" key={indexFamiliar}>
                    <div className="col-12 col-md-2 my-3">
                        <label>Parentesco</label>
                        <select name={ "status" + indexFamiliar } onFocus={ (e) => focusStatus(e) } onChange={ (e) => changeStatus(e,indexFamiliar) } className="form-select shadow-none border-0 bg-grey w-100 align-self-start parentesco" style={{height: "58px"}} aria-label="Default select example">
                                <option>Parentesco</option>
                                {status.map((s,indexStatus) =>
                                    <option value={s.status} key={indexStatus}>{s.status}</option> 
                                )}
                        </select>
                    </div>
                    <div className="col-12 col-md-2 my-3">
                        <label>Sexo</label>
                        <select name={ "gender" + indexFamiliar } onChange={ (e) => changeGender(e,indexFamiliar) }className="form-select shadow-none border-0 bg-grey w-100 align-self-start" style={{height: "58px"}} aria-label="Default select example">
                            <option>Sexo</option>
                            {gender.map((g,indexGender) =>
                                <option value={g.sex} key={g.id}>{g.sex}</option>
                            )}
                        </select>
                    </div>
                    <div className="col-12 col-md-1 my-3">
                        <label>Dia</label>
                        <select required name={ "day" + indexFamiliar } onChange={ (e) => changeGender(e,indexFamiliar) }className="form-select shadow-none border-0 bg-grey w-100 align-self-start" style={{height: "58px"}} aria-label="Default select example">
                            {day.map((d,indexDay) =>
                                <option value={d} key={d}>{d}</option>
                            )}
                        </select>
                    </div>
                    <div className="col-12 col-md-1 my-3">
                        <label>Mes</label>
                        <select required name={ "mounth" + indexFamiliar } onChange={ (e) => changeGender(e,indexFamiliar) }className="form-select shadow-none border-0 bg-grey w-100 align-self-start" style={{height: "58px"}} aria-label="Default select example">
                            {mounth.map((d,indexDay) =>
                                <option value={d} key={d}>{d}</option>
                            )}
                        </select>
                    </div>
                    <div className="col-12 col-md-2 my-3">
                        <label>Año</label>
                        <select required name={ "year" + indexFamiliar } onChange={ (e) => changeGender(e,indexFamiliar) }className="form-select shadow-none border-0 bg-grey w-75 align-self-start" style={{height: "58px"}} aria-label="Default select example">
                            <option value={ new Date().getFullYear() } key="0">{ new Date().getFullYear() }</option>
                            {year.map((d,indexDay) =>
                                <option value={d} key={d}>{d}</option>
                            )}
                        </select>
                    </div>
                    <div className="col-12 col-md-3 my-3" style={ (f.show) ? { "display": "block" } : { "display": "none" } }>
                        <div onClick={() => removeFamiliar(indexFamiliar)} style={{height: "58px"}} className="btn btn-add btn-light d-flex justify-content-start align-items-center p-3 rounded">
                            <img src="/storage/Eliminar-grupo-02.png" className="" />
                            <span className="ms-3 mon-light"  >Eliminar familiar</span>
                        </div>
                    </div>
                    <input name="index" type="hidden" value={indexFamiliar} />
                    {/* <div className="col-12">
                        <hr className="w-100" />
                    </div> */}
                    
                </div>
                )}
            </div>
            <div className="col-12 d-flex flex-column flex-md-row justify-content-center align-items-center my-5"><span className="fas fa-user-plus"></span>
                <div onClick={addFamiliar} className="btn btn-add btn-light d-flex justify-content-start align-items-center p-3 rounded-pill">
                    <img src="/storage/anadir-grupo-04.png" className=""/>
                    <span className="ms-3 mon-light">añadir integrante a mi poliza</span>
                </div>
                <button onClick={sendCot} className="btn bg-pink text-white rounded-pill  px-5 py-3 ms-2" type="button">Encuentra tu poliza ideal</button>
            </div>

            <div className="modal" id="myModal">
                 <div className="modal-dialog">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h5 className="modal-title">Verificacion de Telefono</h5>
                            <button onClick={closeModal} type="button" className="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div className="modal-body">
                        <div className="col-12 my-3">
                            <div className="form-floating mb-3 w-10">
                                <input id="codesend" required name="codesend" type="text" className="form-control shadow-none border-0 bg-grey"/>
                                <label className="mon-regular">Codigo</label>
                            </div>
                            <div onClick={sendCot} className='text-pink fw-bold'>reenviar codigo</div>
                        </div>
                        </div>
                        <div className="modal-footer">
                        <button onClick={verifyCode} type="button" className="btn bg-pink text-white">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="alert-scss" className="d-none alert alert-success position-fixed bottom-0 start-0  ms-3" role="alert">Codigo verificado</div>
        <div id="alert-dng" className="d-none alert alert-danger position-fixed bottom-0 start-0  ms-3" role="alert">Codigo erroneo</div>
        <div id="panel-load" className=' position-fixed w-100 h-100 top-0 start-0' style={ { "background" : "rgba(0,0,0,0.5)" , "z-index" : "100000", "display" : "none" } }></div>
        </div>
    );
}

export default Cotizador;

if (document.getElementById('cotizador')) {
    ReactDOM.render(<Cotizador />, document.getElementById('cotizador'));
}
