import { createContext, useReducer, useState } from "react";

export const GlobalContext = createContext();

export const GlobalProvider = ({children}) => {
    const [name,setName] = useState("");
    const [lastName,setLastName] = useState("");
    const [code,setCode] = useState("+58");
    const [phone,setPhone] = useState();
    const [email,setEmail] = useState();
    const [province,setProvince] = useState("Amazonas");
    const [coverage,setCoverage] = useState(5000);

    const [status,setStatus] = useState([]);
    const [gender,setGender] = useState([]);
    const [days,setDays] = useState([]);
    const [months,setMonths] = useState([]);
    const [years,setYears] = useState([]);

    const [coverages,setCoverages] = useState([]);
    const [frequencies, setFrequencies] = useState([]);
    const [frequency, setFrequency] = useState(1);
    const [frequencyName, setFrequencyName] = useState("anual");
    const [insurerCoverage, setInsurerCoverage] = useState([]);

    const [quote,setQuote] = useState({});

    const [personasAsegurar,setPersonasAsegurar] = useState([]);

    const [message,setMessage] = useState("");

    const [artists, setArtists] = useState(
        [
            { id: 0, name: 'Marta Colvin Andrade' },
            { id: 1, name: 'Lamidi Olonade Fakeye'},
            { id: 2, name: 'Louise Nevelson'},
          ]
      );

    return (
        <GlobalContext.Provider value={{
            personasAsegurar,setPersonasAsegurar,
            name,setName,
            lastName,setLastName,
            code,setCode,
            phone,setPhone,
            email,setEmail,
            province,setProvince,
            coverage,setCoverage,
            status,setStatus,
            gender,setGender,
            days,setDays,
            months,setMonths,
            years,setYears,
            coverages,setCoverages,
            frequencies, setFrequencies,
            frequency, setFrequency,
            insurerCoverage, setInsurerCoverage,
            quote,setQuote,
            artists, setArtists,
            frequencyName, setFrequencyName,
            message,setMessage
            }}>
            {children}
        </GlobalContext.Provider>
    );
}