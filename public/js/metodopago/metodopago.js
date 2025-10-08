$(document).ready(function () {
    limpiarCampos();
});


function guardarMetodoPago() {
    const metodoPago = $('#metodo_pago').val().trim();
    const estatusMetodoPago = $('#estatusmetodo_pago').val();

    if (metodoPago === '' || estatusMetodoPago === '') {
        $('#metodo_pago').css('border-color', 'var(--border-color-required)');
        $('#estatusmetodo_pago').css('border-color', 'var(--border-color-required)');

        showAlert.error(
            'Campo requerido',
            'Por favor, ingrese datos en los campos requeridos.',
            {
                duration: 4000,
                animation: 'slide'
            }
        );
        return;
    }

    const datos = {
        metodo_pago: metodoPago,
        estatus: estatusMetodoPago
    };

    $.ajax({
        url: '/metodos_pago/registrar',
        type: 'POST',
        data: datos,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                showAlert.success('Éxito', 'Pago registrado correctamente.');
                limpiarCampos();
            } else {
                showAlert.error('Error', 'No se pudo registrar el pago.');
            }
        },
        error: function () {
            showAlert.error('Error', 'No se pudo registrar el pago.');
        }
    });

}

//cambiar el color si el campo es llenado
$('#metodo_pago').on('input', function () {
    if ($(this).val().trim() !== '') {
        $(this).css('border-color', 'var(--border-color-valid)');
    }
});

//cambiar el color si el campo es llenado
$('#estatusmetodo_pago').on('input', function () {
    if ($(this).val().trim() !== '') {
        $(this).css('border-color', 'var(--border-color-valid)');
    }
});


// funcion para limpiar campos
function limpiarCampos() {
    $('#metodo_pago').val('');
    $('#estatusmetodo_pago').val('');
    $('#metodo_pago').css('border-color', 'var(--border-color)');
    $('#estatusmetodo_pago').css('border-color', 'var(--border-color)');
}