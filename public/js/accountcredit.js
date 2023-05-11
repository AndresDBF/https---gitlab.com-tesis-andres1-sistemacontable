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
                /* var tipsubcta = data[0].tipsubcta;
                var descripcion = data[0].descripcion;
                $("#subaccount_tipsubcta2").val(tipsubcta);
                $("#subaccount_descripcion2").val(descripcion); */
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