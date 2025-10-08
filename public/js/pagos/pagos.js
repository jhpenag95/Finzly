$(document).ready(function () {

    //limpiar select
    $('#filter-category').val('');

    //limpiar campos del modal
    limpiarCampos();

    // Consultar las categorias para el select
    consultarCategorias();

});

// Mostrar el modal de nuevo pago
function showModal_pagos() {
    document.getElementById('new-payment-modal').style.display = 'flex';

    //Obtener el listado de categorias y pasarlo al select del modal
    $.ajax({
        url: '/pagos/consulta/categorias',
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                // Llenar el select con las categorias
                $('#paymentcategory').empty();
                $('#paymentcategory').append(new Option('Seleccione una categoría', ''));

                response.categorias.forEach(categorias => {
                    $('#paymentcategory').append(new Option(categorias.nombre_cat, categorias.id_categoria));
                });
            }
        },
        error: function () {
            showAlert.error('Error', 'No se pudo consultar las categorias.');
        }
    });

    // Consultar los metodos de pago para el select del modal
    $.ajax({
        url: '/pagos/consulta/metodos',
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                // Llenar el select con los metodos de pago
                $('#paymentmethod').empty();
                $('#paymentmethod').append(new Option('Seleccione un método de pago', ''));

                response.metodos.forEach(metodos => {
                    $('#paymentmethod').append(new Option(metodos.nombre_mp, metodos.id_met_pag));
                });
            }
        },
        error: function () {
            showAlert.error('Error', 'No se pudo consultar los metodos de pago.');
        }
    });
}

// Cerrar el modal de nuevo pago
function closeModal_pagos() {
    document.getElementById('new-payment-modal').style.display = 'none';
    limpiarCampos();
}


//consultar categorias para el select del filtro
function consultarCategorias() {
    $.ajax({
        url: '/pagos/consulta/categorias',
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                // Llenar el select con las categorias
                $('#filter-category').empty();
                $('#filter-category').append(new Option('Seleccione una categoría', ''));


                if (response.categorias.length > 0) {

                    // Opción para seleccionar todas las categorías
                    $('#filter-category').append(new Option('Todas las categorías', 'all'));

                    response.categorias.forEach(categorias => {
                        $('#filter-category').append(new Option(categorias.nombre_cat, categorias.id_categoria));
                    });
                } else {
                    showAlert.info('Información', 'No hay categorías disponibles.');
                }
            }
        },
        error: function () {
            showAlert.error('Error', 'No se pudo consultar las categorias.');
        }
    });
}


// Función para guardar un pago
function validarCampos() {

    //validar campos
    if ($('#paymentname').val() === '' || $('#paymentcategory').val() === '' || $('#paymentamount').val() === '' || $('#paymentdate').val() === '' || $('#paymentmethod').val() === '') {
        // Marcar los campos vacíos con borde rojo

        //campo Nombre del pago
        if ($('#paymentname').val() === '') {
            $('#paymentname').css('border-color', 'red');
        } else {
            $('#paymentname').css('border-color', '');
        }

        //campo Categoria
        if ($('#paymentcategory').val() === '') {
            $('#paymentcategory').css('border-color', 'red');
        } else {
            $('#paymentcategory').css('border-color', '');
        }

        //campo Monto
        if ($('#paymentamount').val() === '') {
            $('#paymentamount').css('border-color', 'red');
        } else {
            $('#paymentamount').css('border-color', '');
        }

        //campo Fecha de vencimiento
        if ($('#paymentdate').val() === '') {
            $('#paymentdate').css('border-color', 'red');
        } else {
            $('#paymentdate').css('border-color', '');
        }

        //campo Metodo de pago
        if ($('#paymentmethod').val() === '') {
            $('#paymentmethod').css('border-color', 'red');
        } else {
            $('#paymentmethod').css('border-color', '');
        }

        //campo Repetición
        if ($('#paymentrepeat').val() === '') {
            $('#paymentrepeat').css('border-color', 'red');
        } else {
            $('#paymentrepeat').css('border-color', '');
        }

        showAlert.error('Error', 'Por favor, complete todos los campos obligatorios.');
        return;
    }

    //campo Nombre del pago
    if (!$('#paymentname').val()) {
        showAlert.error('Error', 'El nombre del pago es obligatorio.');
        return;
    }

    //campo Categoria
    if (!$('#paymentcategory').val()) {
        showAlert.error('Error', 'La categoría es obligatoria.');
        return;
    }

    //campo Monto
    if (isNaN(parseFloat($('#paymentamount').val().replace(/,/g, '')))) {
        showAlert.error('Error', 'El monto debe ser un número válido.');
        return;
    }

    //campo Repetición
    if (!$('#paymentrepeat').val()) {
        showAlert.error('Error', 'La repetición es obligatoria.');
        return;
    }

    //campo Fecha de vencimiento
    if (!$('#paymentdate').val()) {
        showAlert.error('Error', 'La fecha de vencimiento es obligatoria.');
        return;
    }

    //campo Metodo de pago
    if (!$('#paymentmethod').val()) {
        showAlert.error('Error', 'El método de pago es obligatorio.');
        return;
    }


    // Si todos los campos son válidos, llamar a la función para registrar el pago
    registrarPago();

}

//cambiar el color si el campo es llenado
$('#paymentname, #paymentcategory, #paymentamount, #paymentdate, #paymentmethod, #paymentrepeat').on('input change', function () {
    if ($(this).val() !== '') {
        $(this).css('border-color', 'var(--border-color-valid)');
    }
});


// registrar pagos en la base de datos
function registrarPago() {
    var paymentname = $('#paymentname').val();
    var paymentcategory = $('#paymentcategory').val();
    var paymentamount = $('#paymentamount').val();
    var paymentdate = $('#paymentdate').val();
    var paymentrepeat = $('#paymentrepeat').val();
    var paymentmethod = $('#paymentmethod').val();

    var datos = {
        concepto: paymentname,
        id_categoria: paymentcategory,
        monto: paymentamount,
        fecha: paymentdate,
        repeticion: paymentrepeat,
        metodo_pago: paymentmethod,
    };

    $.ajax({
        url: '/pagos/registrar',
        type: 'POST',
        data: datos,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                showAlert.success('Éxito', 'Pago registrado correctamente.');
                closeModal_pagos();
                consultarListadoPagos();
            } else {
                showAlert.error('Error', 'No se pudo registrar el pago.');
            }
        },
        error: function () {
            showAlert.error('Error', 'No se pudo registrar el pago.');
        }
    });
}

function limpiarCampos() {
    // Limpiar los campos del formulario
    $('#paymentname').val('');
    $('#paymentcategory').val('');
    $('#paymentamount').val('');
    $('#paymentdate').val('');
    $('#paymentrepeat').val('');
    $('#paymentmethod').val('');
    $('#paymentcategory').val('');
    $('#paymentmethod').val('');
}