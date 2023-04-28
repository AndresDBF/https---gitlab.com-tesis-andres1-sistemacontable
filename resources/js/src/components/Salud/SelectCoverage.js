import {React,useContext,useEffect,useState} from 'react';
import ReactDOM from 'react-dom';
import { GlobalContext } from "../../context/GlobalProvider";
import { useParams } from "react-router-dom";

export const SelectCoverage = () => {

    const { phone } = useParams();
    const {coverages,setCoverages} = useContext(GlobalContext);
    const {insurerCoverage, setInsurerCoverage} = useContext(GlobalContext);
    const [coverage,setCoverage] = useState(10000);
    const {message,setMessage} = useContext(GlobalContext);

    useEffect( async () => {
        let response = await fetch("/api/coverages");
        let c = await response.json();
        setCoverages(c);

        response = await fetch(`/api/getCotizacionSalud/${phone}`);
        let ic = await response.json();
        setInsurerCoverage( ic.data );
        setMessage(ic.message);

        response = await fetch(`/api/getQuoteByPhone/${phone}`);
        let cs = await response.json();
        setCoverage(cs.coverage);
    },[]);

    const changeCoverage = async (c) => {
        let response = await fetch(`/api/changeCoverage/${phone}/${c}`);
        let data = await response.json();
        setCoverage( data.coverage );
        
        response = await fetch(`/api/getCotizacionSalud/${phone}`);
        let ic = await response.json();
        setInsurerCoverage( ic.data );
        setMessage(ic.message);
    }

    return (
        <select value={ coverage } onChange={ (e) => changeCoverage(e.target.value) } className='form-select shadow-none border-0 bg-light' style={ { height: "58px" } } required>    
            {coverages.map((c,indexCoverage) =>
                <option key={indexCoverage + "555"} value={ c.coverage }>{ c.coverage.toLocaleString('es-MX') }</option>
            )}
        </select>
    );
}