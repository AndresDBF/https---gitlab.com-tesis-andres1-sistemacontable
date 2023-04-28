import { React,useContext,useEffect,useState } from 'react';
import ReactDOM from 'react-dom';
import { GlobalContext } from "../../context/GlobalProvider";

export const DatosPersonales = () => {


    const {name,setName} = useContext(GlobalContext);
    const {lastName,setLastName} = useContext(GlobalContext);
    const {code,setCode} = useContext(GlobalContext);
    const {phone,setPhone} = useContext(GlobalContext);
    const {email,setEmail} = useContext(GlobalContext);
    const {province,setProvince} = useContext(GlobalContext);

    const [codes,setCodes] = useState([]);
    const [provinces,setProvinces] = useState([]);
    const [coverages,setCoverages] = useState([]);

    useEffect( async () => {
        let response = await fetch("/api/codes");
        setCodes(await response.json() );

        response = await fetch("/api/provinces");
        setProvinces(await response.json() );

        response = await fetch("/api/coverages");
        setCoverages(await response.json() );
    },[]);

    return (
        <div className='row'>
        <div className='col-12'>
            <h1 className='mon-black text-danger display-6 text-start my-3'>INFORMACIÓN PERSONAL</h1>
        </div>
        <div className='col-12 col-md-6 mb-3'>
            <div className="form-floating mb-0 bg-light rounded">
                <input value={name} onChange={ (e) => setName(e.target.value) } name="name" type="text" className="form-control shadow-none border-0 bg-light text-dark" required />
                <label className="mon-regular text-secondary">Nombre</label>
            </div>
        </div>
        <div className='col-12 col-md-6 mb-3'>
            <div className="form-floating mb-0 bg-light rounded">
                <input value={lastName} onChange={ (e) => setLastName(e.target.value) } name="name" type="text" className="form-control shadow-none border-0 bg-light text-dark" required />
                <label className="mon-regular text-secondary">Apellido</label>
            </div>
        </div>
        <div className='col-12 col-md-2 mb-3'>
            <select defaultValue={code} onChange={ (e) => setCode(e.target.value) } defaultValue="+58" className='form-select shadow-none border-0 bg-light' style={ { height: "58px" } }>
                {codes.map((c,indexCode) =>
                    <option key={indexCode} value={ `+${c["callingCodes"][0]}` } selected={ c["callingCodes"][0] == 58 ? true : false }>{ `+${c["callingCodes"][0]}` }</option>
                )}
            </select>
        </div>
        <div className='col-12 col-md-4 mb-3'>
            <div className="form-floating mb-0 bg-light rounded">
                <input value={phone} onChange={ (e) => setPhone(e.target.value) } name="name" type="number" className="form-control shadow-none border-0 bg-light text-dark" required />
                <label className="mon-regular text-secondary">Nro de telèfono</label>
            </div>
        </div>
        <div className='col-12 col-md-6 mb-3'>
            <div className="form-floating mb-0 bg-light rounded">
                <input value={email} onChange={ (e) => setEmail(e.target.value) } name="name" type="email" className="form-control shadow-none border-0 bg-light text-dark" required />
                <label className="mon-regular text-secondary">E-mail</label>
            </div>
        </div>
        <div className='col-12 col-md-6 mb-3'>
            <select defaultValue={province} onChange={ (e) => setProvince(e.target.value) } className='form-select shadow-none border-0 bg-light' style={ { height: "58px" } }>
                {provinces.map((p,indexProvince) =>
                    <option key={indexProvince} value={ p.estado }>{ p.estado }</option>
                )}
            </select>
        </div>
    </div>
    );
}