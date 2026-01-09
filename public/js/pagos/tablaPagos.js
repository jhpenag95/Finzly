let datosCompletosPago = [];
let paginaActualPago = 1;
let registrosPorPaginaPago = 5; // Valor por defecto
let mostrarTodosPago = false; // Controla si se muestran todos los registros en una sola página

$(document).ready(function () {
    // Inicializar la tabla al cargar la página
    // Configurar el event listener del selector desde el inicio
    $('#registros-select_pago').on('change', function () {
        const valor = $(this).val();

        if (valor === 'all') {
            mostrarTodosPago = true;
            registrosPorPaginaPago = datosCompletosPago.length || 1; // Garantiza una única página incluso si aún no hay datos
        } else {
            mostrarTodosPago = false;
            registrosPorPaginaPago = parseInt(valor);
        }

        paginaActualPago = 1; // Volver a la primera página
        renderizarPagina_pago(paginaActualPago);
        crearControlesPaginacion_pago();
    });

    // Consultar pagos al cargar la página
    consultarListadoPagos();
});


// Función para consultar el listado de pagos
function consultarListadoPagos() {
    $('#loading-spinner_pago').show();
    $('#pagos-table').hide();

    // Realizar la solicitud AJAX para obtener el listado de pagos
    $.ajax({
        url: '/pagos/obtener',
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            // console.log(response);
            $('#loading-spinner_pago').hide();
            $('#pagos-table').show();

            if (response.pagos.length > 0) {
                datosCompletosPago = response.pagos;

                // Actualizar la opción "Todos" con el total real de registros
                $('#registros-select_pago option[value="all"]').text(`Todos (${datosCompletosPago.length})`);

                // Si actualmente está seleccionada la opción "Todos", sincronizar registrosPorPagina
                if ($('#registros-select_pago').val() === 'all' || mostrarTodosPago) {
                    mostrarTodosPago = true;
                    registrosPorPaginaPago = datosCompletosPago.length || 1;
                }

                paginaActualPago = 1; // Volver a la primera página
                renderizarPagina_pago(paginaActualPago);
                crearControlesPaginacion_pago();

            } else {
                $('#pagos-tbody').html(`
                    <tr>
                        <td colspan="4" class="text-center">No hay datos disponibles</td>
                    </tr>
                `);
                $('#pagination-controls_pago').hide();
            }
        },
        error: function (xhr, status, error) {
            $('#loading-spinner_pago').hide();
            $('#pagos-table').hide();
            $('#saldos-tbody').html(`
                <tr>
                    <td colspan="4" class="text-center">Error al cargar los pagos. Por favor, intenta de nuevo.</td>
                </tr>
            `);
            $('#pagination-controls_pago').hide();
        }
    });
}

// Función para renderizar una página de pagos
function renderizarPagina_pago(pagina) {
    const inicio = (pagina - 1) * registrosPorPaginaPago;
    const fin = inicio + registrosPorPaginaPago;
    const datosPagina = datosCompletosPago.slice(inicio, fin);

    // Limpiar el tbody
    $('#pagos-tbody').empty();

    // Agregar filas de la página actual
    datosPagina.forEach(function (item) {
        let fila = `
            <tr style="text-align: center;">
                <td class="cont-pago">
                    <span class="textnamepago" style="display:block;margin-bottom:6px;">${item.nombre_pg}</span>
                    <span class="textserv">${item.nombre_cat}</span>
                </td>
                <td>
                    <span style="color: #2f487c;">
                        $${parseFloat(item.monto_pg).toLocaleString('es-CL', { minimumFractionDigits: 2 })}
                    </span>
                </td>
                <td>${formatearFecha(item.fecha_pg)}</td>
                <td><span style="padding: 4px 8px; border-radius: 12px; background-color: #e6f7ff; color: #1890ff; font-size: 10px;">${item.repetcion_pg}</span></td>
                <td>${item.nombre_mp}</td>
                <td>${getStatusBadge(item.nombre_sp)}</td>
                <td class="pago-acciones">
                    <div class="action-buttons">
                        <button class="btn-action btn-complete" title="Marcar como completado" onclick="completarpago('${item.id_pagos}')">
                            <i class="fas fa-check" style="color: #fff;"></i>
                        </button>
                        <button class="btn-action btn-edit" title="Editar pago" onclick="editarpago_table('${item.id_pagos}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-action btn-delete" title="Eliminar pago" onclick="eliminarpago('${item.id_pagos}')">
                                <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
        $('#pagos-tbody').append(fila);
    });
    paginaActualPago = pagina;
    actualizarControlesPaginacion_pago();
}

// Función para crear los controles de paginación
function crearControlesPaginacion_pago() {
    const totalPaginas = Math.ceil(datosCompletosPago.length / registrosPorPaginaPago);

    // Siempre mostrar los controles cuando hay datos
    if (datosCompletosPago.length > 0) {
        $('#pagination-controls_pago').show();
        actualizarControlesPaginacion_pago();
    } else {
        $('#pagination-controls_pago').hide();
    }
}

// Función para actualizar los controles de paginación
function actualizarControlesPaginacion_pago() {
    const totalPaginas = mostrarTodosPago ? 1 : Math.ceil(datosCompletosPago.length / registrosPorPaginaPago); // Calcular total de páginas basado en la visibilidad        

    let paginacionHTML = ''; // Inicializar HTML de paginación

    paginacionHTML += '<div class="pagination-buttons">';

    // Solo mostrar botones de navegación si hay más de una página
    if (totalPaginas > 1) {
        // Botón Anterior
        paginacionHTML += `
            <button class="page-btn_pago" id="btn-anterior_pago" ${paginaActualPago === 1 ? 'disabled' : ''}>
                ‹ Anterior
            </button>
        `;

        // Números de página
        for (let i = 1; i <= totalPaginas; i++) {
            // Mostrar solo páginas cercanas a la actual (máximo 5 botones)
            if (i === 1 || i === totalPaginas || (i >= paginaActualmetodopago - 1 && i <= paginaActualmetodopago + 1)) {
                paginacionHTML += `
                    <button class="page-btn_pago page-number ${i === paginaActualPago ? 'active' : ''}" data-page="${i}">
                        ${i}
                    </button>
                `;
            } else if (i === paginaActualPago - 2 || i === paginaActualPago + 2) {
                paginacionHTML += `<span class="page-dots_pago">...</span>`;
            }
        }

        // Botón Siguiente
        paginacionHTML += `
            <button class="page-btn_pago" id="btn-siguiente_pago" ${paginaActualPago === totalPaginas ? 'disabled' : ''}>
                Siguiente ›
            </button>
        `;
    }

    paginacionHTML += '</div>'; // Cerrar pagination-buttons


    // Información de registros
    let inicio, fin;
    if (datosCompletosPago.length === 0) {
        inicio = 0;
        fin = 0;
    } else if (mostrarTodosPago) {
        inicio = 1;
        fin = datosCompletosPago.length;
    } else {
        inicio = (paginaActualPago - 1) * registrosPorPaginaPago + 1;
        fin = Math.min(paginaActualPago * registrosPorPaginaPago, datosCompletosPago.length);
    }
    paginacionHTML += `
        <span class="page-info_pago">
            Mostrando ${inicio}-${fin} de ${datosCompletosPago.length} registros
        </span>
    `;

    $('#pagination-controls_pago').html(paginacionHTML);


    // Event listeners para los botones de página
    $('#pagination-controls_pago .page-btn_pago[data-page]').on('click', function () {
        const pagina = parseInt($(this).data('page'));
        renderizarPagina_pago(pagina);
    });

    // Event listener para el botón Anterior
    $('#btn-anterior_pago').on('click', function () {
        if (paginaActualPago > 1) {
            renderizarPagina_pago(paginaActualPago - 1);
        }
    });

    // Event listener para el botón Siguiente
    $('#btn-siguiente_pago').on('click', function () {
        const totalPaginas = Math.ceil(datosCompletosPago.length / registrosPorPaginaPago);
        if (paginaActualPago < totalPaginas) {
            renderizarPagina_pago(paginaActualPago + 1);
        }
    });
}


//cambiar el color si el campo es llenado
$('#editarPago_nombre, #editarEstatus_pago').on('input change', function () {
    if ($(this).val() !== '') {
        $(this).css('border-color', 'var(--border-color-valid)');
    }
});

//=====================================================================================
//====================== SECCIÓN PARA LA CONFIRMACIÓN DE PAGOS ===========================//
//=====================================================================================


function completarpago(id) {
    // Mostrar confirmación antes de completar el pago
    $('#modalOverlay_confirm').css('display', 'flex');
}

function cerrarModal_confirm() {
    $('#modalOverlay_confirm').css('display', 'none');
}

function confirmarAccion_confirm() {
    // Enviar solicitud AJAX para completar el pago
    $.ajax({
        url: '/pagos/completar/' + id,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                // Mostrar mensaje de éxito
                Swal.fire({
                    icon: 'success',
                    title: 'Pago completado',
                    text: 'El pago ha sido completado con éxito.',
                    showConfirmButton: false,
                    timer: 2000
                });
                // Recargar la tabla de pagos para reflejar el cambio
                renderizarPagina_pago(paginaActualPago);
            } else {
                // Mostrar mensaje de error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Ocurrió un error al completar el pago.',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        }
    });
}



//=====================================================================================
//====================== SECCIÓN PARA LA EDICIÓN DE PAGOS ===========================//
//=====================================================================================


// Cerrar el modal de edición
function closeModalEdit() {
    $('#modalPagos_edit').hide();
}


//botones tabla pagos
// Mostrar el modal de nuevo pago
function editarpago_table(id) {
    $('#modalPagos_edit').css('display', 'flex');
    // Almacena el ID del pago para editar
    $('#paymentid_edit').val(id);

    // Almacena datos del pago para seleccionar opciones cuando carguen
    let pagoData = null;

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
                $('#paymentcategory_edit').empty();
                $('#paymentcategory_edit').append(new Option('Seleccione una categoría', ''));

                response.categorias.forEach(categorias => {
                    $('#paymentcategory_edit').append(new Option(categorias.nombre_cat, categorias.id_categoria));
                });

                // Selecciona la categoría del pago cuando esté disponible
                if (pagoData && pagoData.id_categoria) {
                    $('#paymentcategory_edit').val(pagoData.id_categoria);
                }
            }
        }
    });

    //consultar los metodos de pago para el select del modal
    $.ajax({
        url: '/pagos/consulta/metodos',
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                // Llenar el select con los metodos de pago
                $('#paymentmethod_edit').empty();
                $('#paymentmethod_edit').append(new Option('Seleccione un método de pago', ''));

                response.metodos.forEach(metodos => {
                    $('#paymentmethod_edit').append(new Option(metodos.nombre_mp, metodos.id_met_pag));
                });

                // Selecciona el método del pago cuando esté disponible
                if (pagoData && pagoData.id_met_pag) {
                    $('#paymentmethod_edit').val(pagoData.id_met_pag);
                }
            }
        }
    });

    // Consultar datos del pago
    $.ajax({
        url: '/pagos/consulta/pagos/' + id,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success && response.pago) {
                pagoData = response.pago;
                // Llenar el formulario con los datos del pago usando IDs correctos
                $('#editarPago_id').val(response.pago.id_pagos);
                $('#payment-name_edit').val(response.pago.nombre_pg);
                $('#paymentamount_edit').val(response.pago.monto_pg);
                $('#paymentrepeat_edit').val(response.pago.repetcion_pg);
                $('#paymentdate_edit').val(response.pago.fecha_pg);

                // Intentar seleccionar si los selects ya están poblados
                if ($('#paymentcategory_edit option').length > 0 && pagoData.id_categoria) {
                    $('#paymentcategory_edit').val(pagoData.id_categoria);
                }
                if ($('#paymentmethod_edit option').length > 0 && pagoData.id_met_pag) {
                    $('#paymentmethod_edit').val(pagoData.id_met_pag);
                }
            }
        }
    });

}

// Función para guardar un pago
function validarCampos_editar() {

    // Validar campos vacíos
    if (
        $('#payment-name_edit').val() === '' ||
        $('#paymentcategory_edit').val() === '' ||
        $('#paymentamount_edit').val() === '' ||
        $('#paymentdate_edit').val() === '' ||
        $('#paymentmethod_edit').val() === ''
    ) {
        // Nombre del pago
        if ($('#payment-name_edit').val() === '') {
            $('#payment-name_edit').css('border-color', 'red');
        } else {
            $('#payment-name_edit').css('border-color', '');
        }

        // Categoría
        if ($('#paymentcategory_edit').val() === '') {
            $('#paymentcategory_edit').css('border-color', 'red');
        } else {
            $('#paymentcategory_edit').css('border-color', '');
        }

        // Monto
        if ($('#paymentamount_edit').val() === '') {
            $('#paymentamount_edit').css('border-color', 'red');
        } else {
            $('#paymentamount_edit').css('border-color', '');
        }

        // Fecha de vencimiento
        if ($('#paymentdate_edit').val() === '') {
            $('#paymentdate_edit').css('border-color', 'red');
        } else {
            $('#paymentdate_edit').css('border-color', '');
        }

        // Método de pago
        if ($('#paymentmethod_edit').val() === '') {
            $('#paymentmethod_edit').css('border-color', 'red');
        } else {
            $('#paymentmethod_edit').css('border-color', '');
        }

        // Repetición
        if ($('#paymentrepeat_edit').val() === '') {
            $('#paymentrepeat_edit').css('border-color', 'red');
        } else {
            $('#paymentrepeat_edit').css('border-color', '');
        }

        showAlert.error('Error', 'Por favor, complete todos los campos obligatorios.');
        return;
    }

    // Validaciones individuales

    if (!$('#payment-name_edit').val()) {
        showAlert.error('Error', 'El nombre del pago es obligatorio.');
        return;
    }

    if (!$('#paymentcategory_edit').val()) {
        showAlert.error('Error', 'La categoría es obligatoria.');
        return;
    }

    if (isNaN(parseFloat($('#paymentamount_edit').val().replace(/,/g, '')))) {
        showAlert.error('Error', 'El monto debe ser un número válido.');
        return;
    }

    if (!$('#paymentrepeat_edit').val()) {
        showAlert.error('Error', 'La repetición es obligatoria.');
        return;
    }

    if (!$('#paymentdate_edit').val()) {
        showAlert.error('Error', 'La fecha de vencimiento es obligatoria.');
        return;
    }

    if (!$('#paymentmethod_edit').val()) {
        showAlert.error('Error', 'El método de pago es obligatorio.');
        return;
    }

    var id = $('#paymentid_edit').val();

    $("#confirmEditModal").css("display", "flex");
    $('#confirmEditBtn').off('click').on('click', function () {
        confirmarEditpago(id);
    });
}


//cambiar el color si el campo es llenado
$('#paymentname_edit, #paymentcategory_edit, #paymentamount_edit, #paymentdate_edit, #paymentmethod_edit, #paymentrepeat_edit').on('input change', function () {
    if ($(this).val() !== '') {
        $(this).css('border-color', 'var(--border-color-valid)');
    }
});


function confirmarEditpago(id) {

    var paymentname = $('#payment-name_edit').val();
    var paymentcategory = $('#paymentcategory_edit').val();
    var paymentamount = $('#paymentamount_edit').val();
    var paymentdate = $('#paymentdate_edit').val();
    var paymentrepeat = $('#paymentrepeat_edit').val();
    var paymentmethod = $('#paymentmethod_edit').val();

    var datos = {
        concepto: paymentname,
        id_categoria: paymentcategory,
        monto: paymentamount,
        fecha: paymentdate,
        repeticion: paymentrepeat,
        metodo_pago: paymentmethod,
    };

    $.ajax({
        url: '/pagos/editar/' + id,
        type: 'PUT',
        data: datos,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                showAlert.success(
                    'Actualización Exitosa',
                    'El pago ha sido actualizado correctamente.',
                    {
                        duration: 4000,
                        animation: 'slide'
                    }
                );
                $("#confirmEditModal").css("display", "none");  
                closeModal_pagosEdit();
                consultarListadoPagos();
            } else {
                showAlert.error('Error', 'No se pudo actualizar el pago.');
            }
        },
        error: function () {
            showAlert.error('Error', 'No se pudo actualizar el pago.');
        }
    });
}

// Cerrar el modal de nuevo pago
function closeModal_pagosEdit() {
    $('#modalPagos_edit').hide();
    limpiarCamposEdit();
}

function limpiarCamposEdit() {
    // Limpiar los campos del formulario
    $('#paymentid_edit').val('');
    $('#payment-name_edit').val('');
    $('#paymentcategory_edit').val('');
    $('#paymentamount_edit').val('');
    $('#paymentdate_edit').val('');
    $('#paymentrepeat_edit').val('');
    $('#paymentmethod_edit').val('');
    $('#paymentcategory_edit').val('');
    $('#paymentmethod_edit').val('');

    $('#paymentname_edit').css('border-color', 'var(--border-color)');
    $('#paymentcategory_edit').css('border-color', 'var(--border-color)');
    $('#paymentamount_edit').css('border-color', 'var(--border-color)');
    $('#paymentdate_edit').css('border-color', 'var(--border-color)');
    $('#paymentrepeat_edit').css('border-color', 'var(--border-color)');
    $('#paymentmethod_edit').css('border-color', 'var(--border-color)');
}