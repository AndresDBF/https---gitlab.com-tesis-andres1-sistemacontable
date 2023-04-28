import { createContext, useReducer, useState } from "react";

export const GlobalContext = createContext();

export const GlobalProvider = ({children}) => {

    const [familiar, setFamiliar] = useState([]);

    return (
        <GlobalContext.Provider value={{familiar, setFamiliar}}>
            {children}
        </GlobalContext.Provider>
    );
}