@extends('layouts.app')

@section('content')
  <div id="navbar"></div>
    <!-- Primer Slider -->
    <div class="swiper primer-slider d-block w-100">
      <div class="swiper-wrapper h-100">
        @foreach ($primer_slider as $item)
          <div class="swiper-slide d-block h-100 bg-white">
            @include('components/banner-index',$item)
          </div>
        @endforeach
      </div>
      <div class="swiper-button-next" style="color: #212529 !important ;"></div>
      <div class="swiper-button-prev" style="color: #212529 !important ;"></div>
      <div class="swiper-pagination"></div>
    </div>
    <!-- Primer Slider -->


    <!-- Segundo Slide -->
    <div class="container">
      <div class="w-100 d-flex flex-column align-items-center justify-content-center my-5 w-100 mt-3">
        <h1 class="text-uppercase mon-black text-wine text-center">Cotiza Gratis</h1>
        <!--<p class="mon-light text-center p-1">Siempre encontramos la mejor poliza para tu necesidad</p>-->
      </div>
      <div class="w-100 d-flex flex-column flex-md-row align-items-center justify-content-center">
        
        

        @foreach ($typeInsurer as $type)
        <div class="w-100 d-none d-md-flex align-items-center justify-content-center rounded shadow-lg bg-light">
          <div class="position-relative w-75" style="height: 150px ;">
            <img class="position-absolute w-100 h-100 rounded-end" style="object-fit: cover ;" src='{{ asset("storage/$type->image") }}' alt="">
          </div>
          <div class="w-25 h-100 d-flex flex-column align-items-center justify-content-center px-3">
            <p class="mon-light text-center" style="font-size: 12px ;">{{ $type->description }}</p>
            <a class="rounded-pill p-2 bg-pink text-white text-decoration-none mt-2" style="font-size: 12px ;" href="{{ $type->link }}">{{ $type->button }}</a>
          </div>
        </div>
        <div class="card-v bg-light p-3 rounded d-flex d-md-none flex-column align-items-center justify-content-center mb-5 mx-3">
          <img class="w-50" src='{{ asset("storage/$type->icon") }}' alt="">
          <h3 class="w-100 text-center mon-bold my-3">{{$type->name}}</h3>
          <p class="w-100 mon-light text-center">{{ $type->description }}</p>
          <a class="rounded-pill p-3 bg-pink text-white text-decoration-none mt-3" href="{{ $type->link }}">{{ $type->button }}</a>
        </div>
        @endforeach
      </div>
    </div>
    <!-- Segundo Slide -->
<!-- Sexto Slide -->
<div class="w-100 bg-light py-5">
  <div class="container-fluid bg-light">
    <div class="w-100 bg-light d-flex flex-column align-items-center justify-content-center mb-3 pt-5">
      <h2 class="text-uppercase mon-black text-wine text-center">¿contra que te protegemos?</h2>
      <p class="mon-light text-center p-1">Siempre encontramos la mejor poliza para tu necesidad</p>
    </div>
    <div class="w-100 px-5 bg-light py-5 d-none d-md-block ">
      <div class="swiper sexto-slider-1 w-100">
        <div class="swiper-wrapper">
          @foreach ($sexto_slider as $item)
          <div class="swiper-slide d-flex flex-column align-items-center">
            <img src="{{ asset('storage/' . $item->imagen) }}" alt="">
            <h3 class="mon-bold my-3 text-center">{{ $item->titulo }}</h3>
            <p class="mon-light text-center">{{ $item->descripcion }}</p>
            <div onClick="openModalSmall('{{$item->imagen_modal}}','{{ $item->link }}')" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}" class="p-3 bg-pink rounded-pill text-decoration-none text-white mt-3">{{ $item->boton }}</div>
          </div>
          @endforeach
        </div>
        <div class="swiper-button-next" style="color: #212529 !important ;"></div>
        <div class="swiper-button-prev" style="color: #212529 !important ;"></div>
      </div>
    </div>
    <div class="w-100 bg-light py-5 d-block d-md-none">
      <div class="swiper sexto-slider-2 w-100">
        <div class="swiper-wrapper">
          @foreach ($sexto_slider as $item)
          <div class="swiper-slide px-5 d-flex flex-column align-items-center">
            <img src="{{ asset('storage/' . $item->imagen) }}" alt="">
            <h3 class="mon-bold my-3 text-center">{{ $item->titulo }}</h3>
            <p class="mon-light text-center">{{ $item->descripcion }}</p>
            <div onClick="openModalSmall('{{$item->imagen_modal}}','{{ $item->link }}')" class="p-3 bg-pink rounded-pill text-decoration-none text-white mt-3">{{ $item->boton }}</div>
          </div>
          @endforeach
        </div>
        <div class="swiper-button-next" style="color: #212529 !important ;"></div>
        <div class="swiper-button-prev" style="color: #212529 !important ;"></div>
      </div>
    </div>
    
  </div>
</div>

<!-- Sexto Slide -->


<!-- Cuarto Slide -->
<div class="container-fluid mx-0 px-0 position-relative d-none d-md-block">
  <img class="w-100 panel-4-desk" src="{{ asset('storage/home-si-ya-eres-cliente_1.png') }}" style="z-index: -1000;" alt="">
  <div class="w-100 h-100 position-absolute top-0" style="z-index: 1000 ;">
    <div class="container h-100">
      <div class="row h-100">
        <div class="col-md-6 h-100">
          <div class="w-100 content-4-slide mt-5 border-10">
            <div class="swiper cuarto-slider border-10 m-0">
              <div class="swiper-wrapper w-100 border-10">
                @foreach ($cuarto_slider as $item)
                <div class="swiper-slide w-100 border-10">
                  <img class="w-100 ppp"  src="{{ asset('storage/' . $item->imagen) }}" alt="aaaa">
                </div>
                @endforeach
              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="d-none d-lg-flex w-100 h-100 flex-column align-items-center justify-content-center my-5 py-5">
            <h3 class="h3 mon-black text-white">Si ya eres...</h3>
            <h4 class="display-3 mon-black text-white">CLIENTE</h4>
            <a class="rounded-pill bg-pink p-3 px-5 mon-black h2 text-white text-decoration-none" href="https://cotiseguros.com.ve/cotizador/salud">cotiza gratis</a>
          </div>
          <div class="d-flex d-lg-none w-100 h-100 flex-column align-items-center justify-content-center">
            <h3 class="h5 mon-black text-white mt-5 mb-0">Si ya eres...</h3>
            <h4 class="display-6 mon-black text-white mb-3">CLIENTE</h4>
            <a class="rounded-pill bg-pink p-3 px-5 mon-black h4 text-white text-decoration-none" href="https://cotiseguros.com.ve/cotizador/salud">cotiza gratis</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="w-100 panel-4-desk d-block d-md-none position-relative">
  <img class="w-100 panel-4-desk" src="{{ asset('storage/head-1Mesa-de-trabajo-2-copia-4.png') }}" style="z-index: -1000;" alt="">
  <div class="container position-absolute w-100 h-100 top-0" style="z-index: 1000000">
    <div class="row">
      <div class="col-12">
        <div class="d-flex d-lg-none w-100 h-100 flex-column align-items-center justify-content-center">
          <h3 class="h5 mon-black text-white mt-5 mb-0">Si ya eres...</h3>
          <h4 class="display-6 mon-black text-white mb-3">CLIENTE</h4>
          <a class="rounded-pill bg-pink p-3 px-5 mon-black h4 text-white text-decoration-none" href="https://cotiseguros.com.ve/cotizador/salud">cotiza gratis</a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container panel-4-desk d-flex d-md-none justify-content-center position-relative">
  <div class="row">
    <div class="col-12 ">
      <div class="swiper cuarto-slider content-4-slide border-10 start-0" style="top: -40px ;">
        <div class="swiper-wrapper border-10">
          @foreach ($cuarto_slider as $item)
          <div class="swiper-slide w-100 h-100 border-10">
            <img class="w-100" src="{{ asset('storage/' . $item->imagen) }}" alt="">
          </div>
          @endforeach
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- Cuarto Slide -->

<!-- Quinto Slide -->
<div id="concenos" class="w-100 bg-light">
  <div class="container bg-light py-5">
    <div id="conocenos" class="w-100 d-flex flex-column flex-md-row bg-light px-5">
      <div class="w-100 mt-5 d-flex flex-column justify-content-center align-items-start">
        <h3 class="mon-light fs-3 text-uppercase text-left">somos</h3>
        <h1 class="mon-bold fs-1 text-uppercase text-wine">cotiseguros</h1>
        <p class="mon-regular fs-5">Somos corretaje de seguros.</p>
        <p class="mon-regular fs-5 mt-5">Debido a nuestra amplia experiencia en seguros, brindamos para tu tranquilidad, el producto ideal que se adapta a tus necesidades.</p>
        <h3 class="mon-light fs-3 text-left mt-5">Tu seguridad es</h3>
        <h1 class="mon-bold fs-1 text-uppercase text-wine">nuestra prioridad</h1>
        <div class="w-100 d-flex justify-content-center mt-5">
          <a class="mon-light p-3 px-5 bg-pink rounded-pill text-decoration-none text-white fs-6" href="/cotizador/salud">cotiza tu póliza al momento</a>
        </div>
      </div>
      <div class="w-100 mt-5">
        <img class="w-100 h-100" src="{{ asset('storage/young-couple-buying-car-in-car-showroom.png') }}" style="object-fit: cover ;" alt="">
      </div>
    </div>
  </div>
</div>

<!-- Quinto Slide -->

<!-- Tercero Slide -->
<div class="container">
  <div class="w-100 pb-5 d-flex flex-column align-items-center justify-content-center mb-3 my-5">
    <h2 class="text-uppercase mon-black text-wine text-center">Combos a tu medida</h2>
    <!--<p class="mon-light text-center p-1">Dinos lo que esta pasando, para ayudarte</p>-->
  </div>
  <div class="w-100 mb-5 pb-5 d-flex flex-column flex-md-row align-items-center justify-content-center">
    @foreach ($packages as $p)
    <div class="position-relative overflow-hidden card-v bg-light p-3 rounded d-flex flex-column align-items-center justify-content-center mb-5 mx-3">
      <img class="w-50" src="{{ asset("storage/$p->icon") }}" alt="">
      <h3 class="w-100 text-center mon-bold my-3">{{ $p->name }}</h3>
      <p class="w-100 mon-light text-center">{{ $p->description }}</p>
      <a class="rounded-pill p-3 bg-pink text-white text-decoration-none" href="{{ $p->link }}">{{ $p->button }}</a>
      <div class="position-absolute bg-white w-100 h-100 rounded banner-v d-flex flex-column">
        <img class="w-100 h-75 object-fit" src="{{ asset("storage/$p->banner_image") }}" alt="">
        <div class="w-100 h-25 bg-dark p-3 position-relative d-flex align-items-center ">
          <h4 class="text-center text-white mon-black m-0 p-0 w-100">{{ $p->banner_title }}</h4>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
<!-- Tercero Slide -->


<!-- Septimo Slide -->
<div class="w-100 bg-light">
  <div class="container">
    <div class="w-100 d-flex flex-column flex-md-row py-5 bg-light">
      <div class="w-100 h-100 px-3 mb-5">
        <div class="w-100 h-100 d-flex flex-column justify-content-center align-items-center">
          <h1 class="mon-black text-rojo text-center text-uppercase text-wine">estamos<br/>siempre contigo</h1>
          <p class="mon-regular text-center h3">Protegete a ti y a los tuyos contra todo riesgo. Ten siempre la proteccion de un seguro en tus manos</p>
        </div>
        <div class="row px-0 mx-0">
          <div class="col-12 col-md-4 px-3 mx-0">
            <img class="w-100" src="{{ asset('storage/mapa_de_venezuela_ai_mapa_de_venezuela_mapa_de_venezuela.png') }}" alt="">
            <h2 class="mon-light text-center text-uppercase fs-6">servimos a</h2>
            <h2 class="mon-black text-center text-uppercase fs-6 text-rojo">nivel nacional</h2>
          </div>
          <div class="col-12 col-md-4 px-3 mx-0">
            <img class="w-100" src="{{ asset('storage/grupo.png') }}" alt="">
            <h2 class="mon-light text-center text-uppercase fs-6">mas de 20</h2>
            <h2 class="mon-black text-center text-uppercase fs-6 text-rojo">aseguradoras</h2>
          </div>
          <div class="col-12 col-md-4 px-3 mx-0">
            <img class="w-100" src="{{ asset('storage/24.png') }}" alt="">
            <h2 class="mon-light text-center text-uppercase fs-6">te atendemos</h2>
            <h2 class="mon-black text-center text-uppercase fs-6 text-rojo">las 24hrs</h2>
          </div>
        </div>
      </div>
      <div class="w-100 h-100">
        <div class="w-100 h-100 d-flex flex-column justify-content-center align-items-center">
          <h1 class="mon-black text-rojo text-center text-uppercase text-wine">nuestros<br/>servicios online</h1>
          <div class="w-100 d-flex justify-content-start">
            <ul class="mt-2 px-5">
              <li class="mon-light h3">Consulta tu poliza y las de tu grupo familiar.</li>
              <li class="mon-light h3">Ten siempre la proteccion de un seguro en tus manos.</li>
              <li class="mon-light h3">Crea tus citas de odontología, oftalmología y APS en nuestro portal.</li>
              <li class="mon-light h3">Asesórate con tu gente en todo momento.</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Septimo Slide -->

<!-- Optavo Slide -->
<div class="container">
    <h1 id="trabajamos" class="mon-black text-uppercase text-center text-wine my-5">Aliados Comerciales</h1>
    <div class="w-100 px-3">
      <div class="row mx-3 my-5">
        @foreach ($insurers as $item)
        <div class="col-6 col-md-3 my-5 d-flex justify-content-center align-items-center">
          <img class="w-100" src="{{ asset('storage/' . $item->image) }}" alt="">
        </div>
        @endforeach
      </div>
    </div>
</div>
<!-- Optavo Slide -->

<!-- Noveno Slide -->
@if ( count( $noveno_slider ) > 0 )
  @include('components/banner-index', [ "item" => $noveno_slider[0]] )
@endif
<!-- Noveno Slide -->
<div id="panel-small" style="display: none ;z-index: 1000000 ;" class="position-fixed w-100 h-100 start-0 top-0 justify-content-center align-items-center">
  <div class="modal-small bg-white shadow rounded position-relative">
    <img id="modal-small-image" class="position-absolute top-0 start-0 w-100 h-100" src="" alt="">
    <div onClick="closeModalSmall()" class="position-absolute text-dark top-0 start-0 w-100 p-2 d-flex justify-content-end align-items-center">
      x
    </div>
    <div class="position-absolute bottom-0 start-0 w-100 p-2 d-flex justify-content-center align-items-center">
      <a id="modal-link" target="_blank" class="btn rounded-pill bg-pink text-white"> <img src="/storage/Recurso 1.png" width="20" height="20" alt=""> Pregunta a un experto</a>
    </div>
  </div>
</div>

    <!-- Scripts -->
    <script>
        var swiper = new Swiper(".primer-slider", {
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

      var swiper4 = new Swiper(".cuarto-slider", {
        pagination: {
          el: ".swiper-pagination",
        },
            loop: true,
            autoplay: {
                delay: 3000,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
      });

      var swiper6_1 = new Swiper(".sexto-slider-1", {
        pagination: {
          el: ".swiper-pagination",
        },
            slidesPerView: 3,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 5000,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
      });

      var swiper6_2 = new Swiper(".sexto-slider-2", {
        pagination: {
          el: ".swiper-pagination",
        },
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 5000,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
      });

      function openModalSmall(image,link){
        $("#modal-link").attr("href",`${link}`);
        $("#modal-small-image").attr("src",`storage/${image}`);
        $("#panel-small").css("display","flex");
      }

      function closeModalSmall(){
        $("#panel-small").css("display","none");
      }
    </script>
    <!-- Scripts -->
@endsection
