import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Routes, Route } from "react-router-dom";
import { Header } from "./components/Header";
import { Cotizador } from "./views/cotizador/salud/Cotizador";
import { Home } from "./views/Home";
import { Cotizacion } from "./views/cotizador/salud/Cotizacion";
import { GlobalProvider } from "./context/GlobalProvider";


export const Web = () => {
    return (
        <BrowserRouter>
            <GlobalProvider>
                <Header/>
                <Routes>
                    <Route path="cotizador/salud" element={<Cotizador />} />
                    <Route path="cotizador/salud/:phone" element={ <Cotizacion /> } />
                </Routes>
            </GlobalProvider>
        </BrowserRouter>
    );
}

if (document.getElementById('web')) {
    ReactDOM.render(<Web/>,document.getElementById('web'));
}