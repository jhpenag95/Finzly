let datosCompletosConcepto = [];
let paginaActualConcepto = 1;
let registrosPorPaginaConcepto = 5; // Valor por defecto
let mostrarTodosConcepto = false; // Controla si se muestran todos los registros en una sola página

$(document).ready(function () {
    // Inicializar la tabla al cargar la página
    // Configurar el event listener del selector desde el inicio
    $('#registros-select_concepto').on('change', function () {
        const valor = $(this).val();

        if (valor === 'all') {
            mostrarTodosConcepto = true;
            registrosPorPaginaConcepto = datosCompletosConcepto.length || 1; // Garantiza una única página incluso si aún no hay datos
        } else {
            mostrarTodosConcepto = false;
            registrosPorPaginaConcepto = parseInt(valor);
        }

        paginaActualConcepto = 1; // Volver a la primera página
        renderizarPagina_concepto(paginaActualConcepto);
        crearControlesPaginacion_concepto();
    });

    // Consultar conceptos al cargar la página
    consultarListadoConceptos();
});

function consultarListadoConceptos() {
    $('#loading-spinner_concepto').show();
    $('#conceptos-table').hide();

    // Realizar la solicitud AJAX para obtener el listado de conceptos
    $.ajax({
        url: '/saldo_inicial/conceptos',
        type: 'GET',
        success: function (response) {
            $('#loading-spinner_concepto').hide();
            $('#conceptos-table').show();

            if (response.concepto_saldo_inicial.length > 0) {
                datosCompletosConcepto = response.concepto_saldo_inicial;

                // Actualizar la opción "Todos" con el total real de registros
                $('#registros-select_concepto option[value="all"]').text(`Todos (${datosCompletosConcepto.length})`);

                // Si actualmente está seleccionada la opción "Todos", sincronizar registrosPorPagina
                if ($('#registros-select_concepto').val() === 'all' || mostrarTodosConcepto) {
                    mostrarTodosConcepto = true;
                    registrosPorPaginaConcepto = datosCompletosConcepto.length || 1;
                }

                paginaActualConcepto = 1; // Volver a la primera página
                renderizarPagina_concepto(paginaActualConcepto);
                crearControlesPaginacion_concepto();

            } else {
                $('#saldos-tbody').html(`
                    <tr>
                        <td colspan="4" class="text-center">No hay datos disponibles</td>
                    </tr>
                `);
                $('#pagination-controls').hide();
            }
        },
        error: function (xhr, status, error) {
            $('#loading-spinner_concepto').hide();
            $('#conceptos-table').hide();
            $('#saldos-tbody').html(`
                <tr>
                    <td colspan="4" class="text-center">Error al cargar los conceptos. Por favor, intenta de nuevo.</td>
                </tr>
            `);
            $('#pagination-controls').hide();
        }
    });
}

function renderizarPagina_concepto(pagina) {
    const inicio = (pagina - 1) * registrosPorPaginaConcepto;
    const fin = inicio + registrosPorPaginaConcepto;
    const datosPagina = datosCompletosConcepto.slice(inicio, fin);

    // Limpiar el tbody
    $('#conceptos-tbody').empty();

    // Agregar filas de la página actual
    datosPagina.forEach(function (item) {
        let fila = `
            <tr style="text-align: center;">
                <td>${item.concepto}</td>
                <td>${formatearFecha(item.fecha_registro)}</td>
                <td>${getStatusBadge(item.status)}</td>
                <td class="concepto-acciones">
                    <div class="action-buttons">
                        <button class="btn-action btn-edit" title="Editar concepto" onclick="editarConcepto('${item.id_conpsaldo}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-action btn-delete" title="Eliminar concepto" onclick="eliminarConcepto('${item.id_conpsaldo}')">
                                <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
        $('#conceptos-tbody').append(fila);
    });
    paginaActualConcepto = pagina;
    actualizarControlesPaginacion_concepto();
}

function crearControlesPaginacion_concepto() {
    const totalPaginas = Math.ceil(datosCompletosConcepto.length / registrosPorPaginaConcepto);

    // Siempre mostrar los controles cuando hay datos
    if (datosCompletosConcepto.length > 0) {
        $('#pagination-controls_concepto').show();
        actualizarControlesPaginacion_concepto();
    } else {
        $('#pagination-controls_concepto').hide();
    }
}

function actualizarControlesPaginacion_concepto() {
    const totalPaginas = mostrarTodosConcepto ? 1 : Math.ceil(datosCompletosConcepto.length / registrosPorPaginaConcepto); // Calcular total de páginas basado en la visibilidad

    let paginacionHTML = ''; // Inicializar HTML de paginación

    paginacionHTML += '<div class="pagination-buttons">';

    // Solo mostrar botones de navegación si hay más de una página
    if (totalPaginas > 1) {
        // Botón Anterior
        paginacionHTML += `
            <button class="page-btn" id="btn-anterior_concepto" ${paginaActualConcepto === 1 ? 'disabled' : ''}>
                ‹ Anterior
            </button>
        `;

        // Números de página
        for (let i = 1; i <= totalPaginas; i++) {
            // Mostrar solo páginas cercanas a la actual (máximo 5 botones)
            if (i === 1 || i === totalPaginas || (i >= paginaActualConcepto - 1 && i <= paginaActualConcepto + 1)) {
                paginacionHTML += `
                    <button class="page-btn page-number ${i === paginaActualConcepto ? 'active' : ''}" data-page="${i}">
                        ${i}
                    </button>
                `;
            } else if (i === paginaActualConcepto - 2 || i === paginaActualConcepto + 2) {
                paginacionHTML += `<span class="page-dots">...</span>`;
            }
        }

        // Botón Siguiente
        paginacionHTML += `
            <button class="page-btn" id="btn-siguiente_concepto" ${paginaActualConcepto === totalPaginas ? 'disabled' : ''}>
                Siguiente ›
            </button>
        `;
    }

    paginacionHTML += '</div>'; // Cerrar pagination-buttons


    // Información de registros
    let inicio, fin;
    if (datosCompletos.length === 0) {
        inicio = 0;
        fin = 0;
    } else if (mostrarTodosConcepto) {
        inicio = 1;
        fin = datosCompletosConcepto.length;
    } else {
        inicio = (paginaActual - 1) * registrosPorPaginaConcepto + 1;
        fin = Math.min(paginaActual * registrosPorPaginaConcepto, datosCompletosConcepto.length);
    }
    paginacionHTML += `
        <span class="page-info_concepto">
            Mostrando ${inicio}-${fin} de ${datosCompletosConcepto.length} registros
        </span>
    `;

    $('#pagination-controls_concepto').html(paginacionHTML);


    // Event listeners para los botones de página
    $('#pagination-controls_concepto .page-btn[data-page]').on('click', function () {
        const pagina = parseInt($(this).data('page'));
        renderizarPagina_concepto(pagina);
    });

    // Event listener para el botón Anterior
    $('#btn-anterior_concepto').on('click', function () {
        if (paginaActualConcepto > 1) {
            renderizarPagina_concepto(paginaActualConcepto - 1);
        }
    });

    // Event listener para el botón Siguiente
    $('#btn-siguiente_concepto').on('click', function () {
        const totalPaginas = Math.ceil(datosCompletosConcepto.length / registrosPorPaginaConcepto);
        if (paginaActualConcepto < totalPaginas) {
            renderizarPagina_concepto(paginaActualConcepto + 1);
        }
    });
}


// Función para eliminar un concepto de saldo inicial
function eliminarConcepto(id) {
    var modal = $("#confirmDeleteModal");
    modal.css("display", "flex");

    // Remover cualquier evento anterior y asignar el nuevo
    $('#confirmDelete').off('click').on('click', function () {
        confirmarDeleteConcepto(id);
    });

}

function editarConcepto(id) {
    var modal = $(".addEditConcepto");
    modal.css("display", "flex");

    // Obtener los datos del concepto por ID
    $.ajax({
        url: '/ConceptoSaldoInicial/concepto/' + id,
        type: 'GET',
        success: function (response) {
            if (response.success) {
                // Llenar el formulario con los datos del concepto
                $('#editarConcepto').val(response.concepto.concepto);
                $('#editarEstatus').val(response.concepto.status === 'Activo' ? 'Activo' : 'Inactivo');
                // Guardar el ID del concepto en el formulario para usarlo en la actualización
                $('#btn-actualizarConcepto').off('click').on('click', function () {
                    actualizarConcepto(id);
                });
            } else {
                // Mostrar mensaje de error
                showAlert.error(
                    'Error',
                    'Hubo un error al obtener los datos del concepto',
                    {
                        duration: 4000,
                        animation: 'slide'
                    }
                );
            }
        }
    });
}

function actualizarConcepto(id) {
    var modal = $("#confirmEditModal");
    modal.css("display", "flex");

    // Remover cualquier evento anterior y asignar el nuevo
    $('#confirmEditBtn').off('click').on('click', function () {
        confirmarEditConcepto(id);
    });
}

function closeModalEdit() {
    $('.addEditConcepto').hide();
}

function closeEditModalConfirn() {
    $('.edit-modal').hide();
}


// Función para confirmar la eliminación de un concepto
confirmarDeleteConcepto = function (id) {

    var modal = $("#confirmDeleteModal");
    modal.css("display", "none");

    // Enviar solicitud al servidor para eliminar el concepto
    $.ajax({
        url: '/ConceptoSaldoInicial/concepto/eliminar/' + id,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                // Mostrar mensaje de éxito
                showAlert.success(
                    'Cambio de Estado',
                    'El concepto ha sido cambiado a Inactivo correctamente.',
                    {
                        duration: 4000,
                        animation: 'slide'
                    }
                );

                // Recargar la tabla con el listado actualizado
                consultarListadoConceptos();
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

// Función para confirmar la actualización de un concepto
function confirmarEditConcepto(id) {
    var modal = $("#confirmEditModal");
    modal.css("display", "none");

    // Obtener los datos del formulario
    var concepto = $('#editarConcepto').val();
    var estatus = $('#editarEstatus').val();

    // Enviar solicitud al servidor para actualizar el concepto
    $.ajax({
        url: '/ConceptoSaldoInicial/concepto/actualizar/' + id,
        type: 'PUT',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            concepto: concepto,
            status: estatus
        },
        success: function (response) {
            if (response.success) {
                // Mostrar mensaje de éxito
                showAlert.success(
                    'Actualización Exitosa',
                    'El concepto ha sido actualizado correctamente.',
                    {
                        duration: 4000,
                        animation: 'slide'
                    }
                );
                // Cerrar el modal de confirmación
                closeModalEdit();
                // Recargar la tabla con el listado actualizado
                consultarListadoConceptos();
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

