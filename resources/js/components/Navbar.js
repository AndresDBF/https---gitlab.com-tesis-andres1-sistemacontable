import React from 'react';
import ReactDOM from 'react-dom';
import { Header } from '../src/components/Header';


const Navbar = () => {
    return <Header/>
}

export default Navbar;

if (document.getElementById('navbar')) {
    ReactDOM.render(<Navbar/>, document.getElementById('navbar'));
}