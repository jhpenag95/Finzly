let datosCompletosmetodopago = [];
let paginaActualmetodopago = 1;
let registrosPorPaginametodopago = 5; // Valor por defecto
let mostrarTodosmetodopago = false; // Controla si se muestran todos los registros en una sola página

$(document).ready(function () {
    // Inicializar la tabla al cargar la página
    // Configurar el event listener del selector desde el inicio
    $('#registros-select_metodopago').on('change', function () {
        const valor = $(this).val();

        if (valor === 'all') {
            mostrarTodosmetodopago = true;
            registrosPorPaginametodopago = datosCompletosmetodopago.length || 1; // Garantiza una única página incluso si aún no hay datos
        } else {
            mostrarTodosmetodopago = false;
            registrosPorPaginametodopago = parseInt(valor);
        }

        paginaActualmetodopago = 1; // Volver a la primera página
        renderizarPagina_metodopago(paginaActualmetodopago);
        crearControlesPaginacion_metodopago();
    });

    // Consultar metodopagos al cargar la página
    consultarListadometodopagos();
});

function consultarListadometodopagos() {
    $('#loading-spinner_metodopago').show();
    $('#metodopagos-table').hide();

    // Realizar la solicitud AJAX para obtener el listado de metodopagos
    $.ajax({
        url: '/metodos_pago/obtener',
        type: 'GET',
        success: function (response) {
            // console.log(response);
            $('#loading-spinner_metodopago').hide();
            $('#metodopagos-table').show();

            if (response.metodopago.length > 0) {
                datosCompletosmetodopago = response.metodopago;

                // Actualizar la opción "Todos" con el total real de registros
                $('#registros-select_metodopago option[value="all"]').text(`Todos (${datosCompletosmetodopago.length})`);

                // Si actualmente está seleccionada la opción "Todos", sincronizar registrosPorPagina
                if ($('#registros-select_metodopago').val() === 'all' || mostrarTodosmetodopago) {
                    mostrarTodosmetodopago = true;
                    registrosPorPaginametodopago = datosCompletosmetodopago.length || 1;
                }

                paginaActualmetodopago = 1; // Volver a la primera página
                renderizarPagina_metodopago(paginaActualmetodopago);
                crearControlesPaginacion_metodopago();

            } else {
                $('#metodopagos-tbody').html(`
                    <tr>
                        <td colspan="4" class="text-center">No hay datos disponibles</td>
                    </tr>
                `);
                $('#pagination-controls_metodopago').hide();
            }
        },
        error: function (xhr, status, error) {
            $('#loading-spinner_metodopago').hide();
            $('#metodopagos-table').hide();
            $('#saldos-tbody').html(`
                <tr>
                    <td colspan="4" class="text-center">Error al cargar los metodopagos. Por favor, intenta de nuevo.</td>
                </tr>
            `);
            $('#pagination-controls_metodopago').hide();
        }
    });
}

function renderizarPagina_metodopago(pagina) {
    const inicio = (pagina - 1) * registrosPorPaginametodopago;
    const fin = inicio + registrosPorPaginametodopago;
    const datosPagina = datosCompletosmetodopago.slice(inicio, fin);

    // Limpiar el tbody
    $('#metodopago-tbody').empty();

    // Agregar filas de la página actual
    datosPagina.forEach(function (item) {
        let fila = `
            <tr style="text-align: center;">
                <td>${item.nombre_mp}</td>
                <td>${formatearFecha(item.created_at)}</td>
                <td>${getStatusBadge(item.estatus_mp)}</td>
                <td class="metodopago-acciones">
                    <div class="action-buttons">
                        <button class="btn-action btn-edit" title="Editar metodopago" onclick="editarmetodopago('${item.id_met_pag}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-action btn-delete" title="Eliminar metodopago" onclick="eliminarmetodopago('${item.id_met_pag}')">
                                <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
        $('#metodopago-tbody').append(fila);
    });
    paginaActualmetodopago = pagina;
    actualizarControlesPaginacion_metodopago();
}

function crearControlesPaginacion_metodopago() {
    const totalPaginas = Math.ceil(datosCompletosmetodopago.length / registrosPorPaginametodopago);

    // Siempre mostrar los controles cuando hay datos
    if (datosCompletosmetodopago.length > 0) {
        $('#pagination-controls_metodopago').show();
        actualizarControlesPaginacion_metodopago();
    } else {
        $('#pagination-controls_metodopago').hide();
    }
}

function actualizarControlesPaginacion_metodopago() {
    const totalPaginas = mostrarTodosmetodopago ? 1 : Math.ceil(datosCompletosmetodopago.length / registrosPorPaginametodopago); // Calcular total de páginas basado en la visibilidad

    let paginacionHTML = ''; // Inicializar HTML de paginación

    paginacionHTML += '<div class="pagination-buttons">';

    // Solo mostrar botones de navegación si hay más de una página
    if (totalPaginas > 1) {
        // Botón Anterior
        paginacionHTML += `
            <button class="page-btn_metodopago" id="btn-anterior_metodopago" ${paginaActualmetodopago === 1 ? 'disabled' : ''}>
                ‹ Anterior
            </button>
        `;

        // Números de página
        for (let i = 1; i <= totalPaginas; i++) {
            // Mostrar solo páginas cercanas a la actual (máximo 5 botones)
            if (i === 1 || i === totalPaginas || (i >= paginaActualmetodopago - 1 && i <= paginaActualmetodopago + 1)) {
                paginacionHTML += `
                    <button class="page-btn_metodopago page-number ${i === paginaActualmetodopago ? 'active' : ''}" data-page="${i}">
                        ${i}
                    </button>
                `;
            } else if (i === paginaActualmetodopago - 2 || i === paginaActualmetodopago + 2) {
                paginacionHTML += `<span class="page-dots_metodopago">...</span>`;
            }
        }

        // Botón Siguiente
        paginacionHTML += `
            <button class="page-btn_metodopago" id="btn-siguiente_metodopago" ${paginaActualmetodopago === totalPaginas ? 'disabled' : ''}>
                Siguiente ›
            </button>
        `;
    }

    paginacionHTML += '</div>'; // Cerrar pagination-buttons


    // Información de registros
    let inicio, fin;
    if (datosCompletosmetodopago.length === 0) {
        inicio = 0;
        fin = 0;
    } else if (mostrarTodosmetodopago) {
        inicio = 1;
        fin = datosCompletosmetodopago.length;
    } else {
    inicio = (paginaActualmetodopago - 1) * registrosPorPaginametodopago + 1;
    fin = Math.min(paginaActualmetodopago * registrosPorPaginametodopago, datosCompletosmetodopago.length);
    }
    paginacionHTML += `
        <span class="page-info_metodopago">
            Mostrando ${inicio}-${fin} de ${datosCompletosmetodopago.length} registros
        </span>
    `;

    $('#pagination-controls_metodopago').html(paginacionHTML);


    // Event listeners para los botones de página
    $('#pagination-controls_metodopago .page-btn_metodopago[data-page]').on('click', function () {
        const pagina = parseInt($(this).data('page'));
        renderizarPagina_metodopago(pagina);
    });

    // Event listener para el botón Anterior
    $('#btn-anterior_metodopago').on('click', function () {
        if (paginaActualmetodopago > 1) {
            renderizarPagina_metodopago(paginaActualmetodopago - 1);
        }
    });

    // Event listener para el botón Siguiente
    $('#btn-siguiente_metodopago').on('click', function () {
        const totalPaginas = Math.ceil(datosCompletosmetodopago.length / registrosPorPaginametodopago);
        if (paginaActualmetodopago < totalPaginas) {
            renderizarPagina_metodopago(paginaActualmetodopago + 1);
        }
    });
}


// Función para eliminar un metodopago de saldo inicial
function eliminarmetodopago(id) {
    var modal = $("#confirmDeleteModal");
    modal.css("display", "flex");

    // Remover cualquier evento anterior y asignar el nuevo
    $('#confirmDelete').off('click').on('click', function () {
        confirmarDeletemetodopago(id);
    });

}

function editarmetodopago(id) {
    var modal = $(".addEditmetodopago");
    modal.css("display", "flex");

    // Obtener los datos del metodopago por ID
    $.ajax({
        url: '/metodopagoSaldoInicial/metodopago/' + id,
        type: 'GET',
        success: function (response) {
            if (response.success) {
                // Llenar el formulario con los datos del metodopago
                $('#editarmetodopago').val(response.metodopago.metodopago);
                $('#editarEstatus').val(response.metodopago.status === 'Activo' ? 'Activo' : 'Inactivo');
                // Guardar el ID del metodopago en el formulario para usarlo en la actualización
                $('#btn-actualizarmetodopago').off('click').on('click', function () {
                    actualizarmetodopago(id);
                });
            } else {
                // Mostrar mensaje de error
                showAlert.error(
                    'Error',
                    'Hubo un error al obtener los datos del metodopago',
                    {
                        duration: 4000,
                        animation: 'slide'
                    }
                );
            }
        }
    });
}

function actualizarmetodopago(id) {
    var modal = $("#confirmEditModal");
    modal.css("display", "flex");

    // Remover cualquier evento anterior y asignar el nuevo
    $('#confirmEditBtn').off('click').on('click', function () {
        confirmarEditmetodopago(id);
    });
}

function closeModalEdit() {
    $('.addEditmetodopago').hide();
}

function closeEditModalConfirn() {
    $('.edit-modal').hide();
}


// Función para confirmar la eliminación de un metodopago
confirmarDeletemetodopago = function (id) {

    var modal = $("#confirmDeleteModal");
    modal.css("display", "none");

    // Enviar solicitud al servidor para eliminar el metodopago
    $.ajax({
        url: '/metodopagoSaldoInicial/metodopago/eliminar/' + id,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                // Mostrar mensaje de éxito
                showAlert.success(
                    'Cambio de Estado',
                    'El metodopago ha sido cambiado a Inactivo correctamente.',
                    {
                        duration: 4000,
                        animation: 'slide'
                    }
                );

                // Recargar la tabla con el listado actualizado
                consultarListadometodopagos();
            } else {
                // Mostrar mensaje de error
                showAlert.error(
                    'Error',
                    'Hubo un error al eliminar el registro',
                    {
                        duration: 4000,
                        animation: 'slide'
                    }
                );
            }
        }
    });
}

// Función para confirmar la actualización de un metodopago
function confirmarEditmetodopago(id) {
    var modal = $("#confirmEditModal");
    modal.css("display", "none");

    // Obtener los datos del formulario
    var metodopago = $('#editarmetodopago').val();
    var estatus = $('#editarEstatus').val();

    // Enviar solicitud al servidor para actualizar el metodopago
    $.ajax({
        url: '/metodopagoSaldoInicial/metodopago/actualizar/' + id,
        type: 'PUT',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            metodopago: metodopago,
            status: estatus
        },
        success: function (response) {
            if (response.success) {
                // Mostrar mensaje de éxito
                showAlert.success(
                    'Actualización Exitosa',
                    'El metodopago ha sido actualizado correctamente.',
                    {
                        duration: 4000,
                        animation: 'slide'
                    }
                );
                // Cerrar el modal de confirmación
                closeModalEdit();
                // Recargar la tabla con el listado actualizado
                consultarListadometodopagos();
            } else {
                // Mostrar mensaje de error
                showAlert.error(
                    'Error',
                    'Hubo un error al actualizar el registro',
                    {
                        duration: 4000,
                        animation: 'slide'
                    }
                );
            }
        }
    });
}

