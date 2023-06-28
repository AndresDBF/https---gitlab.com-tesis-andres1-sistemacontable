function confirmPag(url) {
    Swal.fire({
        title: 'Pago de Nomina',
        text: '¿Desea Realizar el Pago al Empleado?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url; // Redirige a la URL especificada
        }
    });
}

function editEmployee(url) {
    Swal.fire({
        title: 'Editar Empleado',
        text: '¿Desea Editar el Empleado?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url; // Redirige a la URL especificada
        }
    });
}

function deleteEmployee(url) {
    Swal.fire({
        title: 'Eliminar Empleado',
        text: '¿Eliminar Empleado?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'No',
        willClose: (result) => {
            if (result.dismiss === Swal.DismissReason.confirm) {
                window.location.reload(); // Recarga la página actual
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Envía una petición DELETE al servidor
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            })
            .then((response) => {
                // Realiza las acciones necesarias después de la eliminación
                if (response.ok) {
                    // Eliminación exitosa, muestra un mensaje o redirige si es necesario
                    console.log('Empleado eliminado correctamente');
                } else {
                    // Error en la eliminación, muestra un mensaje de error o realiza otra acción
                    console.log('Error al eliminar el empleado');
                }
            })
            .catch((error) => {
                console.log(error);
            });
        }
    });
}


