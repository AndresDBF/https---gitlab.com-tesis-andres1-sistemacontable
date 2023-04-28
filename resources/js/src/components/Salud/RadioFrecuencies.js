import {React,useContext,useEffect} from 'react';
import ReactDOM from 'react-dom';
import { GlobalContext } from "../../context/GlobalProvider";

export const RadioFrecuencies = () => {

    const {frequencies, setFrequencies} = useContext(GlobalContext);
    const {frequency,setFrequency} = useContext(GlobalContext);
    const {frequencyName, setFrequencyName} = useContext(GlobalContext);

    useEffect( async () => {
        let response = await fetch("/api/frequency");
        setFrequencies(await response.json() );
        setFrequency(1);
    },[]);

    return (
        <div className='row p-0 m-0' style={ { height: "58px" } }>
            <div className='col-12 p-0 m-0 d-flex justify-content-between align-items-center'>
                {frequencies.map( (f,indexFrecuency) =>
                    <div key={indexFrecuency}>
                        <input onChange={ (e) => { setFrequency(e.target.value); setFrequencyName(f.name); } } name="frecuencie" type="radio" value={ f.frequency } />
                        <span className='fs-sm ps-1'>{ f.name }</span> 
                    </div>
                )}
            </div>
        </div>
    );
}