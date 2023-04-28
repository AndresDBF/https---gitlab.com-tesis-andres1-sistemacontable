import React from 'react';
import ReactDOM from 'react-dom';

export const Header = () => {
    return (
      <nav className="navbar navbar-expand-lg navbar-light sticky-top bg-white shadow-sm position-sticky">
        <div className="container">
          <a className="navbar-brand" href="/">
            <img height="30" src="https://cotiseguros.com.ve/storage/LOGO%20RGB_Color%20-%20copia%20-%20copia%20(1).png" alt="" />
          </a>
          <span className='d-none d-md-block' style={{"color": "rgba(0,0,0,0.5)","font-size" : 10}}>Nuestra experiencia... es tu tranquilidad...!</span>
          <button className="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span className="navbar-toggler-icon"></span>
          </button>
          <div className="collapse navbar-collapse" id="navbarSupportedContent">
            <ul className="navbar-nav me-auto mb-2 mb-lg-0"></ul>
            <form className="d-flex">
              <ul className="navbar-nav me-auto mb-2 mb-lg-0">
                <li className="nav-item">
                  <a className="nav-link mon-bold fs-7 mx-3" href="https://cotiseguros.com.ve/#concenos">Conócenos</a>
                </li>
                <li className="nav-item">
                  <a className="nav-link mon-bold fs-7 mx-3" href="https://cotiseguros.com.ve/#trabajamos">¿Con quién trabajamos?</a>
                </li>
                <li className="nav-item">
                  <a className="nav-link mon-bold fs-7 mx-3" href="https://cotiseguros.com.ve/#footer">Contáctanos</a>
                </li>
                {/* <li className="nav-item">
                  <a className="nav-link mon-bold fs-7 mx-3" href="">Iniciar Sesion</a>
                </li> */}
                <li className="nav-item">
                  <a className="nav-link btn btn-secondary text-white mon-bold fs-7 mx-3 px-4" href="https://cotiseguros.com.ve/cotizador/salud">cotizar gratis</a>
                </li>
              </ul>
            </form>
          </div>
        </div>
      </nav>
    );
}