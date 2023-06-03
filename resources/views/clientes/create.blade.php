@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <h1 class="text-secondary fs-5 shadow-lg p-2 mb-5 bg-body rounded text-center">Nuevo Cliente</h1>
@stop

@section('content')
<div class="container"> 
  <div class="card">
    <div class="card-body pl-6">
      <form action="/clientes" method="POST" id="myform">
        @csrf
          <div class="mb-3">
            <label for="" class="form-label">Codigo Cliente</label>
            <input type="text" name="code" id="code" class="form-control" readonly="readonly" value="{{$idsigue}}" tabindex="1">
          </div>
          
          <div class="mb-3">
            <label for="" class="form-label">Nombre del Cliente o Razón Social</label>
            @if($errors->first('name'))
              <p class="text-danger">{{$errors->first('name')}}</p>
            @endif
            <input type="text" name="name" id="name" class="form-control" tabindex="2">
          </div>
           
          <div class="well">
            <div class="row">
                <div class="col-xs-3 col-sm-6 col-md-4">
                    <div class="form-label">
                        <label for="dni">Tipo de Identificación</label>
                        @if($errors->first('tipid'))
                          <p class="text-danger">{{$errors->first('tipid')}}</p>
                        @endif
                        <select name = 'tipid' class="custom-select">
                            <option selected="">Seleccionar Identificación</option>
                            <option value="V">V</option>
                            <option value="J">J</option>
                            <option value="E">E</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-3 col-sm-6 col-md-4">
                    <label for="" class="form-label">Rif o Cedula del Cliente</label>
                    <input type="number" name="identification" id="identification" class="form-control text-decoration-none" tabindex="6">
                    @if($errors->first('identification'))
                      <p class="text-danger">{{$errors->first('identification')}}</p>
                    @endif
                </div>
                <div class="col-xs-3 col-sm-6 col-md-4" id="div-off">
                    <label for="" class="form-label">Digito Verificador</label>
                    <select name = 'tiprif' class="custom-select" >
                        <option selected="">Seleccionar Numero</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                    </select>
                </div>
            </div>
          </div>
          
          <div class="mb-3">
            <label for="" class="form-label">Telefono</label>
            @if($errors->first('phone'))
              <p class="text-danger">{{$errors->first('phone')}}</p>
            @endif
            <input type="text" name="phone" id="phone" class="form-control" tabindex="4">
          </div>
          <div class="mb-3">
            <label for="" class="well-lg form-label">Dirección</label>
            @if($errors->first('direction'))
              <p class="text-danger">{{$errors->first('direction')}}</p>
            @endif
            <input type="text" name="direction" id="direction" class="form-control" tabindex="6">
          </div>
          <div class="mb-3">
            <label for="" class="form-label">Correo Electronico</label>
            @if($errors->first('email'))
              <p class="text-danger">{{$errors->first('email')}}</p>
            @endif
            <input type="text" name="email" id="email" class="form-control" tabindex="5">
          </div>
          
          <br>
    
          <h1 class="pb-6">Contrato del Cliente</h1>
          
          <div class="well">
            <div class="row">
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <label for="dni">Estatus de Contrato</label>
                  <select name="stscontr" class="custom-select" id="stscontr-select" onchange="checkStatus(this)">
                    <option selected>Selecciona el Estatus de contrato</option>
                    @foreach ($status as $sts)
                      <option value="{{$sts->sts}}">{{$sts->sts}}</option>
                    @endforeach
                  </select>
                  @error('stscontr')
                    <div class="alert alert-danger">{{ "Estatus Invalido" }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-4">
                <div class="form-group">
                  <label for="dni">Tipo de Pago</label>
                  <select name = 'tip_pag' class="custom-select">
                    <option selected="">Selecciona un tipo de pago</option>
                      @foreach ($tippag as $tip)
                          <option value="{{$tip->tippago}}">{{$tip->descripcion}}</option>
                      @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="well">
              <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <label for="" class="form-label">Monto del Contrato</label>
                  <input type="number" name="valuecont" id="valuecont" class="form-control" tabindex="7">
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                  <div class="form-group">
                    <label for="dni">Moneda</label>
                    <select name = 'money' class="custom-select" id="money-select">
                      <option selected="">Selecciona una Moneda</option>
                        @foreach ($money as $mon)
                          <option value="{{$mon->tipmoneda}}">{{$mon->descripcion}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <input type="hidden" name="tasa_cambio" value="">

              </div>
            </div>
          </div>
    </div> 
  </div>
  <div class="well pb-3">
    <a href="/clientes" class="btn btn-secondary" tabindex="5">Cancelar</a>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#seatmodal">Confirmar</button>
    {{-- <button type="submit" class="btn btn-primary" tabindex="6">Guardar</button>--}}
    <!-- Modal -->
  </div>
  <div class="modal fade" id="seatmodal" tabindex="-1" aria-labelledby="seatmodalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="seatmodalLabel">Completar Asiento Contable</h5>
        </div>
        <div class="modal-body">
          <div class="well">
            <div class="row">
              <div class="col-xs-6 col-sm-6 col-md-6">
                <h3 class="text-center">Cuenta Debe</h3>
                <div class="form-group">
                  <label for="groupaccount">Grupo de Cuenta</label>
                  <select name = 'groupaccount1' id ="groupaccount1" class="custom-select">
                      <option selected="">Seleccionar Grupo</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="subgroupaccount">Subgrupo de Cuenta</label>
                  <select name = 'subgroupaccount1' id ="subgroupaccount1" class="custom-select">
                      <option selected="">Seleccionar Subgrupo</option>
                  </select>
                </div> 
                <div class="form-group">
                  <label for="accountname">Nombre de Cuenta</label>
                  <select name = 'accountname1'id="accountname1" class="custom-select">
                      <option selected="">Seleccionar Cuenta</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="subaccountname">Nombre de Subcuenta</label>
                  <select name = 'subaccountname1'id="subaccountname1" class="custom-select">
                      <option selected="">Seleccionar Subcuenta</option>
                  </select>
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <h3 class="text-center">Cuenta Haber</h3>
                <div class="form-group">
                  <label for="groupaccount">Grupo de Cuenta</label>
                  <select name = 'groupaccount2' id ="groupaccount2" class="custom-select">
                      <option selected="">Seleccionar Grupo</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="subgroupaccount">Subgrupo de Cuenta</label>
                  <select name = 'subgroupaccount2' id ="subgroupaccount2" class="custom-select">
                      <option selected="">Seleccionar Subgrupo</option>
                  </select>
                </div> 
                <div class="form-group">
                  <label for="accountname">Nombre de Cuenta</label>
                  <select name = 'accountname2'id="accountname2" class="custom-select">
                      <option selected="">Seleccionar Cuenta</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="subaccountname">Nombre de Subcuenta</label>
                  <select name = 'subaccountname2'id="subaccountname2" class="custom-select">
                      <option selected="">Seleccionar Subcuenta</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
            <div class="mb-3">
              <label for="recipient-name" class="col-form-label">Observacion</label>
              <input type="text" class="form-control" name="observation" id="observation">
            </div>
            <div class="mb-3">
              <label for="message-text" class="col-form-label">Descripcion</label>
              <textarea class="form-control" name="description" id="description"></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" onclick="confirmAsi('{{ route('clientes.store') }}')">Guardar</button>

      </div>
      </div>
    </div>
  </div>
</form> 
</div>
  
  
@stop
@section('js')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script>
    var myModal = document.getElementById('myModal')
    var myInput = document.getElementById('myInput')

    myModal.addEventListener('shown.bs.modal', function () {
      myInput.focus()
    })
  </script>
  <script 
      src="http://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous">
  </script>
  <script>
    $(document).ready(function() {
      
       $("#div-off").hide();
 
       
       $("select[name='tipid']").change(function() {
          if ($(this).val() == "J") {
             
             $("#div-off").show();
          } else {
            
             $("#div-off").hide();
          }
       });
    });
  </script>
  <script>
    document.getElementById('money-select').addEventListener('change', function() {
        var selectedOption = this.value;
        if (selectedOption !== 'BS') {
            var tasaCambio = prompt('Ingrese la tasa de cambio:');
            document.querySelector('input[name="tasa_cambio"]').value = tasaCambio;
        }
    });
</script>
  <script>
    function checkStatus(selectElement) {
      var selectedValue = selectElement.value;
      if (selectedValue === 'ANU' || selectedValue === 'RET') {
        alert('El estatus seleccionado es incorrecto para este proceso.');
        selectElement.value = "";
      }
    }
  </script>
  <script>
    $( document ).ready(function() 
    {
        cargartipocuenta1()
        $( "#groupaccount1" ).change(function() /* el # busca el id del div html */
        {
            var groupaccount = $('#groupaccount1').val();
            $.ajax(
            {
              url: "/subgroupaccount1/"+groupaccount,
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              dataType: 'json', // what to expect back from the server                                                                  
              data: {},
              processData: false,
              cache: false,
              contentType: false,
              type: 'post',
              success: function(data) 
              {
                  if (data)
                  {
                    var $subgroupaccount = $('#subgroupaccount1');
                    $subgroupaccount.empty();
                    var $accountname = $('#accountname1');
                    $accountname.empty();
                    $subgroupaccount.append('<option selected="">Seleccionar SubGrupo</option>')
                    data.forEach(element=>
                    {
                        $subgroupaccount.append('<option value=' + element.idsgr + '>' + element.descripcion + '</option>')
                    });
                  }
              }
            });
        });
        $( "#subgroupaccount1" ).change(function() 
        {
            var subgroupaccount = $('#subgroupaccount1').val();
            $.ajax(
            {
              url: "/accountname1/"+subgroupaccount,
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              dataType: 'json', // what to expect back from the server                                                                  
              data: {},
              processData: false,
              cache: false,
              contentType: false,
              type: 'post',
              success: function(data) 
              {
                  if (data)
                  {
                    var $accountname = $('#accountname1');
                    $accountname.empty();
                    var $subaccountname = $('#subaccountname1');
                    $subaccountname.empty();
                    $accountname.append('<option selected="">Seleccionar Cuenta</option>')
                    data.forEach(element=>
                    {
                        $accountname.append('<option value=' + element.idgcu + '>' + element.descripcion + '</option>')
                    });
                  }
              }
            });
        });
        $( "#accountname1" ).change(function() /* el # busca el id del div html */
        {
            var accountname = $('#accountname1').val();
            $.ajax(
            {
              url: "/subaccountname1/"+accountname,
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              dataType: 'json', // what to expect back from the server                                                                  
              data: {},
              processData: false,
              cache: false,
              contentType: false,
              type: 'post',
              success: function(data) 
              {
                  if (data)
                  {
                    var $subaccountname = $('#subaccountname1');
                    $subaccountname.empty();
                    $subaccountname.append('<option selected="">Seleccionar SubCuenta</option>')
                    data.forEach(element=>
                    {
                        $subaccountname.append('<option value=' + element.idscu + '>' + element.descripcion + '</option>')
                    });
                  }
              }
            });
        });
    });
    function cargartipocuenta1()
    {
      var datas = new FormData();  
      $.ajax({
          url: "/groupaccount1",
          dataType: 'json', // what to expect back from the server                                                                  
          data: {},
          processData: false,
          cache: false,
          contentType: false,
          type: 'get',
          success: function(data) 
          {
              if (data) 
              {
                var $groupaccount = $('#groupaccount1');
                $groupaccount.empty();
                $groupaccount.append('<option selected="">Seleccionar Grupo</option>');
                data.forEach(element=>
                {
                    $groupaccount.append('<option value=' + element.idgru + '>' + element.descripcion + '</option>')
                });
              }
              else
              {
                
              }
              
          }
      });
    }
  </script>
  <script>
    $( document ).ready(function() 
    {
        cargartipocuenta2()
        $( "#groupaccount2" ).change(function() /* el # busca el id del div html */
        {
            var groupaccount = $('#groupaccount2').val();
            $.ajax(
            {
              url: "/subgroupaccount2/"+groupaccount,
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              dataType: 'json', // what to expect back from the server                                                                  
              data: {},
              processData: false,
              cache: false,
              contentType: false,
              type: 'post',
              success: function(data) 
              {
                  if (data)
                  {
                    var $subgroupaccount = $('#subgroupaccount2');
                    $subgroupaccount.empty();
                    var $accountname = $('#accountname2');
                    $accountname.empty();
                    $subgroupaccount.append('<option selected="">Seleccionar SubGrupo</option>')
                    data.forEach(element=>
                    {
                        $subgroupaccount.append('<option value=' + element.idsgr + '>' + element.descripcion + '</option>')
                    });
                  }
              }
            });
        });
        $( "#subgroupaccount2" ).change(function() 
        {
            var subgroupaccount = $('#subgroupaccount2').val();
            $.ajax(
            {
              url: "/accountname2/"+subgroupaccount,
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              dataType: 'json', // what to expect back from the server                                                                  
              data: {},
              processData: false,
              cache: false,
              contentType: false,
              type: 'post',
              success: function(data) 
              {
                  if (data)
                  {
                    var $accountname = $('#accountname2');
                    $accountname.empty();
                    var $subaccountname = $('#subaccountname2');
                    $subaccountname.empty();
                    $accountname.append('<option selected="">Seleccionar Cuenta</option>')
                    data.forEach(element=>
                    {
                        $accountname.append('<option value=' + element.idgcu + '>' + element.descripcion + '</option>')
                    });
                  }
              }
            });
        });
        $( "#accountname2" ).change(function() /* el # busca el id del div html */
        {
            var accountname = $('#accountname2').val();
            $.ajax(
            {
              url: "/subaccountname2/"+accountname,
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              dataType: 'json', // what to expect back from the server                                                                  
              data: {},
              processData: false,
              cache: false,
              contentType: false,
              type: 'post',
              success: function(data) 
              {
                  if (data)
                  {
                    var $subaccountname = $('#subaccountname2');
                    $subaccountname.empty();
                    $subaccountname.append('<option selected="">Seleccionar SubCuenta</option>')
                    data.forEach(element=>
                    {
                        $subaccountname.append('<option value=' + element.idscu + '>' + element.descripcion + '</option>')
                    });
                  }
              }
            });
        });
    });
    function cargartipocuenta2()
    {
      var datas = new FormData();  
      $.ajax({
          url: "/groupaccount2",
          dataType: 'json', // what to expect back from the server                                                                  
          data: {},
          processData: false,
          cache: false,
          contentType: false,
          type: 'get',
          success: function(data) 
          {
              if (data) 
              {
                var $groupaccount = $('#groupaccount2');
                $groupaccount.empty();
                $groupaccount.append('<option selected="">Seleccionar Grupo</option>');
                data.forEach(element=>
                {
                    $groupaccount.append('<option value=' + element.idgru + '>' + element.descripcion + '</option>')
                });
              }
              else
              {
                
              }
              
          }
      });
    }
  </script>
  <script>
    function confirmAsi(url) {
        Swal.fire({
            title: 'Confirmación',
            text: '¿Estás seguro de crear Asiento Contable?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('myform').submit(); // Envía el formulario
            }
        });
    }
</script>
@stop