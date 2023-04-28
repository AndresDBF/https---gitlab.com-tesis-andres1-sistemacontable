import { React,useContext,useState,useEffect } from 'react';
import ReactDOM from 'react-dom';

export const Home = (props) => {

    const [primerSlider,setPrimerSlider] = useState([]);

    useEffect(async() => {
        let response = await fetch("/api/getHome");
        let data = await response.json();
        setPrimerSlider(data.primer_slider);

        let swiper = new Swiper(".primer-slider", {
            pagination: {
            el: ".swiper-pagination",
          },
              loop: true,
              autoplay: {
                  delay: 10000,
              },
              navigation: {
                  nextEl: ".swiper-button-next",
                  prevEl: ".swiper-button-prev",
              },
        });

    },[]);

    return (
        <div>
            <div className="swiper primer-slider d-block w-100">
                <div className="swiper-wrapper h-100">
                    { primerSlider.map((p) =>
                        <div className="swiper-slide d-block h-100 bg-white">
                            <div className="bg-white row w-100 h-100 m-0 p-0">
                                <div className="position-relative w-100 h-100 col-12 p-0">
                                    <img className="d-none d-md-block w-100 h-100 object-fit " src={ `/storage/${p.imagen}` } alt="" style={ { zIndex: -1 } } />
                                    <a href="{{ $item->link }}">
                                        <img className="d-block d-md-none w-100 h-100 object-fit " src={ `/storage/${p.imagen_movil}` } alt="" />
                                    </a>
                                    <div className="position-absolute d-flex flex-column justify-content-center align-items-start h-100 ps-5 content-ps pt-5 top-0" style={ { zIndex: 100000 } }>
                                        <div className="display-4 p-0 m-0 text-wine text-break mon-black color-text-slider-1 pt-5">{ p.titulo }</div>
                                        <div className="display-6 p-0 m-0 color-text-slider-1" dangerouslySetInnerHTML={{ __html: `${p.subtitulo}` }}></div>
                                        <div className="h5 p-0 m-0 pt-3 color-text-slider-1 d-none d-md-block" dangerouslySetInnerHTML={{ __html: `${p.descripcion}` }}></div>
                                        <a className="rounded-pill bg-pink text-white py-3 px-3 px-m-5 mt-5 text-decoration-none mb-5 d-none d-md-block" href={ `${p.link}` }>{ `${p.boton}`}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    )}
                </div>
                <div className="swiper-button-next" style="color: #212529 !important ;"></div>
                <div className="swiper-button-prev" style="color: #212529 !important ;"></div>
                <div className="swiper-pagination"></div>
            </div>
        </div>
    );
}