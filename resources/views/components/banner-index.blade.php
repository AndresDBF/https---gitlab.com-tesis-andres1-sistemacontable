<div class="bg-white row w-100 h-100 m-0 p-0">
    <div class="position-relative w-100 h-100 col-12 p-0">
        <img class="d-none d-md-block w-100 h-100 object-fit " src="{{ asset( 'storage/' . $item->imagen ) }}" alt="" style="z-index: -1">
        <a href="{{ $item->link }}">
            <img class="d-block d-md-none w-100 h-100 object-fit " src="{{ asset( 'storage/' . $item->imagen_movil ) }}" alt="">
        </a>
        <div class="position-absolute d-flex flex-column justify-content-center align-items-start h-100 ps-5 content-ps pt-5 top-0" style="z-index: 1000">
            <div class="display-4 p-0 m-0 text-wine text-break mon-black color-text-slider-1 pt-5">{!! $item->titulo !!}</div>
            <div class="display-6 p-0 m-0 color-text-slider-1">{!! $item->subtitulo !!}</div>
            <div class="h5 p-0 m-0 pt-3 color-text-slider-1 d-none d-md-block">{!! $item->descripcion !!}</div>
            <a class="rounded-pill bg-pink text-white py-3 px-3 px-m-5 mt-5 text-decoration-none mb-5 d-none d-md-block" href="{{ $item->link }}">{!! $item->boton !!}</a>
        </div>
    </div>
</div>