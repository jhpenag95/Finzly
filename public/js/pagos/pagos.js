function showModal_pagos() {
    document.getElementById('new-payment-modal').style.display = 'flex';
    // document.getElementById('new-payment-modal').classList.add('show');
}

function closeModal_pagos() {
    document.getElementById('new-payment-modal').style.display = 'none';
    // document.getElementById('new-payment-modal').classList.remove('show');
}


//consultar categorias
function consultarCategorias() {
    $.ajax({
        url: '/pagos/categorias',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                // Llenar el select con las categorias
                $('#paymentcategory').empty();
                response.data.forEach(categoria => {
                    $('#paymentcategory').append(`
                        <option value="${categoria.id_categorias}">${categoria.nombre_categoria}</option>
                    `);
                });
            } else {
                showAlert.error('Error', 'No se pudo consultar las categorias.');
            }
        },
        error: function () {
            showAlert.error('Error', 'No se pudo consultar las categorias.');
        }
    });
}


// Función para guardar un pago
function guardarPago() {
    var paymentname         = $('#paymentname').val();
    var paymentcategory     = $('#paymentcategory').val();
    var paymentamount       = $('#paymentamount').val();
    var paymentdate         = $('#paymentdate').val();
    var paymentrepeat       = $('#paymentrepeat').val();
    var paymentmethod       = $('#paymentmethod').val();

    var datos = {
        concepto: paymentname,
        categoria: paymentcategory,
        monto: paymentamount,
        fecha: paymentdate,
        repeticion: paymentrepeat,
        metodo_pago: paymentmethod,
    };

    $.ajax({
        url: '/pagos/registrar',
        type: 'POST',
        data:  datos,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                showAlert.success('Éxito', 'Pago registrado correctamente.');
                closeModal_pagos();
                consultarPagos();
            } else {
                showAlert.error('Error', 'No se pudo registrar el pago.');
            }
        },
        error: function () {
            showAlert.error('Error', 'No se pudo registrar el pago.');
        }
    });
}

// Función para consultar los pagos
function consultarPagos() {
    $.ajax({
        url: '/pagos/consulta',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                // Llenar la tabla con los datos de los pagos
                $('#paymentTable').empty();
                response.data.forEach(payment => {
                    $('#paymentTable').append(`
                        <tr>
                            <td>${payment.id}</td>
                            <td>${payment.concepto}</td>
                            <td>${payment.monto}</td>
                            <td>${payment.fecha}</td>
                        </tr>
                    `);
                });
            } else {
                showAlert.error('Error', 'No se pudieron consultar los pagos.');
            }
        },
        error: function () {
            showAlert.error('Error', 'No se pudieron consultar los pagos.');
        }
    });
}