import { React,useContext } from 'react';
import ReactDOM from 'react-dom';
import { GlobalContext } from "../../context/GlobalProvider";

export const ButtonAddMember = () => {
 
    const {personasAsegurar,setPersonasAsegurar} = useContext(GlobalContext);

    const addMember = () => {

        let newArray = [...personasAsegurar];
        newArray.push({
            id: Math.random() * 1000,
            status: "Yo",
            gender: "Masculino",
            day: 0,
            month: 0,
            year: 0
        });
        setPersonasAsegurar(newArray);
    }

    return (    
        <div onClick={ () => addMember() } className='btn btn-light rounded-pill mon-regular p-3'>
            <img className="px-2" height="30" src="/storage/anadir-grupo-04.png"/>
            Añadir integrante a mi póliza
        </div>
    );
}