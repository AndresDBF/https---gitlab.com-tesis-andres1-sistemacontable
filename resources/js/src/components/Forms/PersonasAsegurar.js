import { React,useContext,useState,useEffect } from 'react';
import ReactDOM from 'react-dom';
import { GlobalContext } from "../../context/GlobalProvider";
import { useParams } from "react-router-dom";

export const PersonasAsegurar = () => {

    const {personasAsegurar,setPersonasAsegurar} = useContext(GlobalContext);
    
    const {status,setStatus} = useContext(GlobalContext);
    const {gender,setGender} = useContext(GlobalContext);
    const {days,setDays} = useContext(GlobalContext);
    const {months,setMonths} = useContext(GlobalContext);
    const {years,setYears} = useContext(GlobalContext);
    const {quote,setQuote} = useContext(GlobalContext);
    const { phone } = useParams();

    useEffect( async () => {
        let response = await fetch("/api/status");
        setStatus(await response.json() );
    
        response = await fetch("/api/gender");
        setGender(await response.json() );

        let daysArray = [];
        for (let index = 1; index <= 31; index++) {
            daysArray.push(index);
        }
        setDays(daysArray);

        let monthsArray = [];
        for (let index = 1; index <= 12; index++) {
            monthsArray.push(index);
        }
        setMonths(monthsArray);

        let yearsArray = [];
        for (let index = new Date().getFullYear(); index >= new Date().getFullYear() - 100; index--) {
            yearsArray.push(index);
        }
        setYears(yearsArray);


        if(phone){
            response = await fetch(`/api/changeMembersByQuote/${phone}`);
            let m = await response.json();
            setPersonasAsegurar(m);
            console.log("members: ",m);
            console.log("PersonasAsegurar: ", personasAsegurar );
            // if( m.length > 0 ){
            //     let membersArray = [];
            //     m.map((e) => {
            //         membersArray.push({
            //             status: e.status,
            //             gender: e.gender,
            //             day: e.birthday.split("-")[0],
            //             month: e.birthday.split("-")[1],
            //             year: e.birthday.split("-")[2]
            //         });
            //     });
            //     setPersonasAsegurar(membersArray);
            //     console.log( personasAsegurar );
            // }
        }
        

    },[]);

    const changeOption = (e,index,field) => {
        personasAsegurar[index][field] = e.target.value;
        let p = personasAsegurar;
        setPersonasAsegurar([...p] );

        console.log(personasAsegurar);
    }

    const deleteMember = async (index) => {
        
        setPersonasAsegurar( personasAsegurar.filter(item => item.id != index ) );
        //setPersonasAsegurar( (current) => current.filter((item) => { console.log( item.id != index,index ) } ) );

        // setPersonasAsegurar((current) =>
        //     current.filter(
        //         (fruit,i) => {
        //             i != index
        //         }
        //     )
        // );



        console.log(personasAsegurar)

        // let newArray = [...personasAsegurar];
        // newArray.splice(index,1);
        // setPersonasAsegurar([...newArray]);
        // console.log(personasAsegurar);

        // if( phone ){
        //     let response = await fetch("/api/changeMembersByQuote",{
        //           method: "POST",
        //           body: JSON.stringify({
        //             phone: phone,
        //             personasAsegurar: personasAsegurar
        //           }),
        //           headers: {"Content-type": "application/json; charset=UTF-8"}
        //     });
          
        //     let data = response.json();
          
        //     response = await fetch(`/api/changeMembersByQuote/${phone}`);
        //     let m = await response.json();
        //     setPersonasAsegurar(m);

        //     response = await fetch(`/api/getQuoteByPhone/${phone}`);
        //     let cs = await response.json();
        //     setQuote([...cs]);
          
        //     //   alert("Miembros actualizados");
              
        // }
        // let newArray = [...personasAsegurar];
        // newArray.splice(index,1);
        // console.log(newArray);
        // let a = newArray;
        // await setPersonasAsegurar(a);
        // console.log(personasAsegurar)
    }

    return (
        <div className='my-5'>
            <h1 className='mon-black text-danger display-6 text-start my-3'>PERSONAS A ASEGURAR</h1>
            {personasAsegurar.map( (p,indexPersona) => 
                <div key={indexPersona} className='row'>
                    <div className='col-12 col-md-4'>
                        <label className="mon-regular text-secondary">Parentesco</label>
                        <select onChange={ (e) => changeOption(e,indexPersona,"status") } className='form-select shadow-none border-0 bg-light' style={ { height: "58px" } } required>
                        {status.map( (s) =>
                            <option key={s.id} value={ s.status } selected={ p.status == s.status }>{ s.status }</option>
                        )}
                        </select>
                    </div>
                    <div className='col-12 col-md-3'>
                        <label className="mon-regular text-secondary">Sexo</label>
                        <select defaultValue={ p.gender } onChange={ (e) => changeOption(e,indexPersona,"gender") } className='form-select shadow-none border-0 bg-light' style={ { height: "58px" } } required>
                            {gender.map( (g) => 
                                <option key={g.id} value={ g.sex } selected={ p.gender == g.sex }>{ g.sex }</option>
                            )}
                        </select>
                    </div>
                    <div className='col-12 col-md-3 py-0'>
                    <label className="mon-regular text-secondary">Fecha de nacimiento</label>
                        <div className='d-flex'>
                        <select defaultValue={ p.day } onChange={ (e) => changeOption(e,indexPersona,"day") } className='form-select shadow-none border-0 bg-light' style={ { height: "58px" } } required>
                            <option value={0}>Día</option>
                            {days.map((d,indexDay) =>
                                <option key={indexDay} value={d} selected={ p.day == d }>{d}</option>
                            )}
                        </select>
                        <select defaultValue={ p.month } onChange={ (e) => changeOption(e,indexPersona,"month") } className='form-select shadow-none border-0 bg-light ms-2' style={ { height: "58px" } } required>
                            <option value={0}>Mes</option>
                            {months.map((m,indexMonth) =>
                                <option key={indexMonth} value={m} selected={ p.month == m }>{m}</option>
                            )}
                        </select>
                        <select defaultValue={ p.year } onChange={ (e) => changeOption(e,indexPersona,"year") } className='form-select shadow-none border-0 bg-light ms-2' style={ { height: "58px" } } required>
                            <option value={0}>Año</option>
                            {years.map((y,indexYear) =>
                                <option key={indexYear} value={y} selected={ p.year == y }>{y}</option>
                            )}
                        </select>
                        </div>
                        
                    </div>
                    {/* <div className='col-12 col-md-1 py-0 px-sm'>
                        <label className="mon-regular text-secondary">Día</label>
                        <select defaultValue={ p.day } onChange={ (e) => changeOption(e,indexPersona,"day") } className='form-select shadow-none border-0 bg-light me-3' style={ { height: "58px" } } required>
                            {days.map((d,indexDay) =>
                                <option key={indexDay} value={d} selected={ p.day == d }>{d}</option>
                            )}
                        </select>
                    </div>
                    <div className='col-12 col-md-1 py-0 px-sm'>
                        <label className="mon-regular text-secondary">Mes</label>
                        <select defaultValue={ p.month } onChange={ (e) => changeOption(e,indexPersona,"month") } className='form-select shadow-none border-0 bg-light' style={ { height: "58px" } } required>
                            {months.map((m,indexMonth) =>
                                <option key={indexMonth} value={m} selected={ p.month == m }>{m}</option>
                            )}
                        </select>
                    </div>
                    <div className='col-12 col-md-1 py-0 px-sm'>
                        <label className="mon-regular text-secondary">Año</label>
                        <select defaultValue={ p.year } onChange={ (e) => changeOption(e,indexPersona,"year") } className='form-select shadow-none border-0 bg-light ' style={ { height: "58px" } } required>
                            {years.map((y,indexYear) =>
                                <option key={indexYear} value={y} selected={ p.year == y }>{y}</option>
                            )}
                        </select>
                    </div> */}
                    <div className='col-12 col-md-2 d-flex flex-column justify-content-center align-items-center'>
                        <span>&nbsp;</span>
                        <div onClick={() => setPersonasAsegurar( personasAsegurar.filter(item => item.id != p.id ) )  } style={ ( personasAsegurar.length > 1 ) ? { display: "flex" } : { display: "none" } } className='btn btn-light text-white w-100 h-100 justify-content-start align-items-center'>
                            <img height="30" src="/storage/Eliminar-grupo-02.png" />
                            <span className='mon-regular text-dark px-3 fw-bold'>Eliminar</span>
                        </div>
                    </div>
                    <div className='col-12 col-md-12'>
                        <hr className='mt-3' />
                    </div>
                </div>
            )}
        </div>
    );
}