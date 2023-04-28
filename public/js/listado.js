$(document).ready(function () 
{
    let location ='127.0.0.1:8000';    
    $('#example').DataTable({
        processing: true,
        serverSide: true,
        ajax: `listartabla/`,
        language:
            {
				"url": "json/Spanish.json"
			},
        columns: [
            { data: 'id' },
            { data: 'name' },
           
            { data: 'phone' },
            { data: 'email' },
            { data: 'coverage' },
            {
                "targets": -1,
                "data": null, 
                "className": "dt-center",
                "defaultContent": "<button class='btn btn-sm btn-primary btn-rest' data-toggle='' data-target=''  >Benficiarios </button>",
                "createdCell": function (td, cellData, rowData, row, col) 
                {
                    $(td).on("click", ".btn-rest", function () 
                    {
                        mostrarbeneficiarios(rowData.memberquote)
                        //console.log(rowData.memberquote)
                    });
                }

            },
        ]
    });
});

function mostrarbeneficiarios(arreglo)
{
    console.log(arreglo)
    let cadena ='';
    arreglo.forEach(function(a) 
    {
       cadena +=' '+a.status+',  '+a.date+'  años <br>';
    })
    Swal.fire({
        title: '<strong> Beneficiarios </strong>',
        icon: 'info',
        html:cadena,
        showCloseButton: true,
        showCancelButton: false,
        focusConfirm: false,
        confirmButtonText:'<i class="fa fa-thumbs-up"></i> OK!',
        confirmButtonAriaLabel: 'OK!',
        cancelButtonText:'<i class="fa fa-thumbs-down"></i>',
        cancelButtonAriaLabel: 'Thumbs down'
      })
}