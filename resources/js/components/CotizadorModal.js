import React from 'react';
import ReactDOM from 'react-dom';
import moment from 'moment';
import { useState,useEffect,useContext } from "react";
import { GlobalContext } from "./GlobalProvider";

function CotizadorModal() {

    
    const [status, setStatus] = useState([]);
    const [gender, setGender] = useState([]);
    const [day, setDay] = useState([]);
    const [mounth, setMounth] = useState([]);
    const [year, setYear] = useState([]);
    const [phone, setPhone] = useState("");
    const [currentStatusValue,setCurrentStatusValue] = useState();
    const [modal,setModal] = useState({ "display" : "none" });

    const {familiar, setFamiliar} = useContext(GlobalContext);
    const {coverages, setCoverages} = useState( localStorage.getItem("coverages") );

    console.log( "Cov = ",localStorage.getItem("coverages"))
    //JSON.parse( localStorage.getItem("coverages") );
    // const [familiar, setFamiliar] = useState([{
    //     "status" : "",
    //     "gender" : "",
    //     "date" : "",
    //     "show": false
    // }]);

    useEffect(() => {

        console.log("Familiar = ",familiar);

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
            "birthday": `1-1-${ new Date().getFullYear() }`,
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

    const closeModalMember = () => {
        setModal({ "display" : "none" })
    }

    const changeMembers = () => {
        const coverages = localStorage.getItem("coverages");
        console.log(coverages);

        

        fetch(`/api/cotizador/changeMembers/${coverages}`, 
            {
                method: "POST",
                body: JSON.stringify({
                    members : familiar
                })
            })
        .then(response => response.json()) 
        .then(json => {
            console.log(json);
        });
    }

    return (
            <form action={ `/api/cotizador/changeMembers/${  localStorage.getItem("coverages") }` } method="post">
            <h1></h1>
            
            <div  className="col-12" style={{ "overflowY" : "scroll", "overflowX" : "hidden" , "height" : "300px" }}>
                {familiar.map((f,indexFamiliar) =>
                    <div className="row py-1 px-3 rounded" key={indexFamiliar}>
                    <div className="col-12 col-md-2">
                        <label>Parentesco</label>
                        <select name={ "status" + indexFamiliar } onFocus={ (e) => focusStatus(e) } onChange={ (e) => changeStatus(e,indexFamiliar) } className="form-select shadow-none border-0 bg-grey w-100 align-self-start parentesco" style={{height: "58px"}} aria-label="Default select example">
                                <option>Parentesco</option>
                                {status.map((s,indexStatus) =>
                                    <option selected={  s.status == f.status  ? true : false } value={s.status} key={indexStatus}>{s.status}</option> 
                                )}
                        </select>
                    </div>
                    <div className="col-12 col-md-2">
                   
                        <label>Sexo</label>
                        <select name={ "gender" + indexFamiliar } onChange={ (e) => changeGender(e,indexFamiliar) }className="form-select shadow-none border-0 bg-grey w-100 align-self-start" style={{height: "58px"}} aria-label="Default select example">
                            <option>Sexo</option>
                            {gender.map((g,indexGender) =>
                                <option selected={  g.sex == f.gender  ? true : false } value={g.sex} key={g.id}>{g.sex}</option>
                            )}
                        </select>
                    </div>
                    <div className="col-12 col-md-1">
                        <label>Dia</label>
                        <select required name={ "day" + indexFamiliar } onChange={ (e) => changeGender(e,indexFamiliar) }className="form-select shadow-none border-0 bg-grey w-100 align-self-start" style={{height: "58px"}} aria-label="Default select example">
                            {day.map((d,indexDay) =>
                                <option selected={  d == f.birthday.split("-")[0]  ? true : false } value={d} key={d}>{d}</option>
                            )}
                        </select>
                    </div>
                    <div className="col-12 col-md-1">
                        <label>Mes</label>
                        <select required name={ "mounth" + indexFamiliar } onChange={ (e) => changeGender(e,indexFamiliar) }className="form-select shadow-none border-0 bg-grey w-100 align-self-start" style={{height: "58px"}} aria-label="Default select example">
                            {mounth.map((d,indexDay) =>
                                <option selected={  d == f.birthday.split("-")[1]  ? true : false } value={d} key={d}>{d}</option>
                            )}
                        </select>
                    </div>
                    <div className="col-12 col-md-2">
                        <label>Año</label>
                        <select required name={ "year" + indexFamiliar } onChange={ (e) => changeGender(e,indexFamiliar) }className="form-select shadow-none border-0 bg-grey w-75 align-self-start" style={{height: "58px"}} aria-label="Default select example">
                            <option value={ new Date().getFullYear() } key="0">{ new Date().getFullYear() }</option>
                            {year.map((d,indexDay) =>
                                <option selected={  d == f.birthday.split("-")[2]  ? true : false } value={d} key={d}>{d}</option>
                            )}
                        </select>
                    </div>
                    <div className="col-12 col-md-3 flex-column justify-content-center align-items-center" style={ (f.show) ? { "display": "flex" } : { "display": "none" } }>
                        <label style={ (f.show) ? { "display": "block" } : { "display": "none" } }>Opcion</label>
                        <button type="button" onClick={() => familiar.length == 1 ? "" : removeFamiliar(indexFamiliar)  } style={{height: "58px"}} className="btn btn-add btn-light d-flex justify-content-start align-items-center p-3 rounded">
                            <img src="/storage/Eliminar-grupo-02.png" className="" />
                            <span className="ms-3 mon-light"  >Eliminar familiar</span>
                        </button>
                    </div>
                    <input name="index" type="hidden" value={indexFamiliar} />
                    
                    
                </div>
                )}
            </div>
            <div className="col-12 d-flex flex-column flex-md-row justify-content-center align-items-center my-5"><span className="fas fa-user-plus"></span>
                <div onClick={addFamiliar} className="btn btn-add btn-light d-flex justify-content-start align-items-center p-3 rounded-pill">
                    <img src="/storage/anadir-grupo-04.png" className=""/>
                    <span className="ms-3 mon-light">añadir integrante</span>
                </div>
                <button disabled={ familiar.length > 0 ? false : true } type="submit" className="btn bg-pink text-white rounded-pill  px-5 py-3 ms-2">Guardar integrantes</button>
            </div>
            <input type="hidden" name="index" value={familiar.length} />
        </form>
        
    );
}

export default CotizadorModal;

if (document.getElementById('cotizadorModal')) {
    ReactDOM.render(<CotizadorModal />, document.getElementById('cotizadorModal'));
}
