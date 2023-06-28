$(document).ready(function() {
  cargartipcontribuyente();
  $("#tipcontribuyente").change(function() {
      var tipcontribuyente = $(this).val();
      $.ajax({
          url: "/tipagente/" + tipcontribuyente,
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          dataType: 'json',
          type: 'post',
          success: function(data) {
              if (data) {
                  var $tipagente = $('#tipagente');
                  $tipagente.empty();
                  $tipagente.append('<option selected="">Seleccionar concepto de Agente</option>')
                  data.forEach(function(element) {
                      $tipagente.append('<option value=' + element.idage + '>' + element.concepto + '</option>');
                  });
              }
          }
      });
  });
});

function cargartipcontribuyente() {
  $.ajax({
      url: "/tipcontribuyente",
      dataType: 'json',
      type: 'get',
      success: function(data) {
          if (data) {
              var $tipcontribuyente = $('#tipcontribuyente');
              $tipcontribuyente.empty();
              data.forEach(function(element) {
                  if (element.tippersona == 'V') {
                      $tipcontribuyente.append('<option value=' + element.tippersona + '> Persona Natural </option>');
                  } else {
                      $tipcontribuyente.append('<option value=' + element.tippersona + '> Persona Juridica </option>');
                  }
              });
          }
      }
  });
}
