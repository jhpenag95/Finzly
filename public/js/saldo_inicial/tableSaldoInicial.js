// JavaScript - AJAX con paginación mejorada
let datosCompletos = [];
let paginaActual = 1;
let registrosPorPagina = 5; // Valor por defecto
let mostrarTodos = false; // Controla si se muestran todos los registros en una sola página

$(document).ready(function () {
    // Configurar el event listener del selector desde el inicio
    $('#registros-select').on('change', function () {
        const valor = $(this).val();

        if (valor === 'all') {
            mostrarTodos = true;
            registrosPorPagina = datosCompletos.length || 1; // Garantiza una única página incluso si aún no hay datos
        } else {
            mostrarTodos = false;
            registrosPorPagina = parseInt(valor);
        }

        paginaActual = 1; // Volver a la primera página
        renderizarPagina(paginaActual);
        crearControlesPaginacion();
    });

    consultar_listado();
});

function consultar_listado() {
    // Mostrar el spinner antes de hacer la petición
    $('#loading-spinner').show();
    $('#saldos-table').hide();

    $.ajax({
        url: '/saldo_inicial/consulta',
        type: 'GET',
        success: function (response) {
            // Ocultar spinner
            $('#loading-spinner').hide();
            $('#saldos-table').show();

            if (response.saldo_inicial.length > 0) {
                datosCompletos = response.saldo_inicial;

                // Actualizar la opción "Todos" con el total real de registros
                $('#registros-select option[value="all"]').text(`Todos (${datosCompletos.length})`);

                // Si actualmente está seleccionada la opción "Todos", sincronizar registrosPorPagina
                if ($('#registros-select').val() === 'all' || mostrarTodos) {
                    mostrarTodos = true;
                    registrosPorPagina = datosCompletos.length || 1;
                }

                paginaActual = 1; // Resetear a la primera página
                renderizarPagina(paginaActual);
                crearControlesPaginacion();
            } else {
                console.log('No hay datos disponibles');
                $('#saldos-tbody').html(`
                    <tr>
                        <td colspan="4" class="text-center">No hay datos disponibles</td>
                    </tr>
                `);
                $('#pagination-controls').hide();
            }
        },
        error: function (xhr, status, error) {
            $('#loading-spinner').hide();
            $('#saldos-table').show();
            $('#saldos-tbody').html(`
                <tr>
                    <td colspan="3" class="text-center text-danger">
                        Error en la conexión: ${error}
                    </td>
                </tr>
            `);
            $('#pagination-controls').hide();
        }
    });
}

// Función para renderizar una página específica
function renderizarPagina(numeroPagina) {
    const inicio = (numeroPagina - 1) * registrosPorPagina;
    const fin = inicio + registrosPorPagina;
    const datosPagina = datosCompletos.slice(inicio, fin);

    // Limpiar el tbody
    $('#saldos-tbody').empty();

    // Agregar filas de la página actual
    datosPagina.forEach(function (item) {
        let fila = `
            <tr style="text-align: center;">
                <td>${item.concepto}</td>
                <td>$${parseFloat(item.monto).toLocaleString('es-MX', { minimumFractionDigits: 2 })}</td>
                <td>${formatearFecha(item.fecha_registro)}</td>
                <td style="display: flex; gap: 5px; justify-content: center;">
                    <button class="btn-action btn-delete" onclick="eliminarSaldoInicial('${item.id_ingresos}')">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        `;
        $('#saldos-tbody').append(fila);
    });

    paginaActual = numeroPagina;
    actualizarControlesPaginacion();
}

// Función para crear los controles de paginación
function crearControlesPaginacion() {
    const totalPaginas = Math.ceil(datosCompletos.length / registrosPorPagina);

    // Siempre mostrar los controles cuando hay datos
    if (datosCompletos.length > 0) {
        $('#pagination-controls').show();
        actualizarControlesPaginacion();
    } else {
        $('#pagination-controls').hide();
    }
}

// Función para actualizar los controles de paginación
function actualizarControlesPaginacion() {
    const totalPaginas = mostrarTodos ? 1 : Math.ceil(datosCompletos.length / registrosPorPagina);

    let paginacionHTML = '';

    // Contenedor de botones de navegación
    paginacionHTML += '<div class="pagination-buttons">';

    // Solo mostrar botones de navegación si hay más de una página
    if (totalPaginas > 1) {
        // Botón Anterior
        paginacionHTML += `
            <button class="page-btn" id="btn-anterior" ${paginaActual === 1 ? 'disabled' : ''}>
                ‹ Anterior
            </button>
        `;

        // Números de página
        for (let i = 1; i <= totalPaginas; i++) {
            // Mostrar solo páginas cercanas a la actual (máximo 5 botones)
            if (i === 1 || i === totalPaginas || (i >= paginaActual - 1 && i <= paginaActual + 1)) {
                paginacionHTML += `
                    <button class="page-btn ${i === paginaActual ? 'active' : ''}" data-page="${i}">
                        ${i}
                    </button>
                `;
            } else if (i === paginaActual - 2 || i === paginaActual + 2) {
                paginacionHTML += `<span class="page-dots">...</span>`;
            }
        }

        // Botón Siguiente
        paginacionHTML += `
            <button class="page-btn" id="btn-siguiente" ${paginaActual === totalPaginas ? 'disabled' : ''}>
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
    } else if (mostrarTodos) {
        inicio = 1;
        fin = datosCompletos.length;
    } else {
        inicio = (paginaActual - 1) * registrosPorPagina + 1;
        fin = Math.min(paginaActual * registrosPorPagina, datosCompletos.length);
    }
    paginacionHTML += `
        <span class="page-info">
            Mostrando ${inicio}-${fin} de ${datosCompletos.length} registros
        </span>
    `;

    $('#pagination-controls').html(paginacionHTML);


    // Event listeners para los botones de página
    $('.page-btn[data-page]').on('click', function () {
        const pagina = parseInt($(this).data('page'));
        renderizarPagina(pagina);
    });

    $('#btn-anterior').on('click', function () {
        if (paginaActual > 1) {
            renderizarPagina(paginaActual - 1);
        }
    });

    $('#btn-siguiente').on('click', function () {
        const totalPaginas = Math.ceil(datosCompletos.length / registrosPorPagina);
        if (paginaActual < totalPaginas) {
            renderizarPagina(paginaActual + 1);
        }
    });
}

// Función auxiliar para formatear fechas
function formatearFecha(fecha) {
    if (!fecha) return '';

    const date = new Date(fecha);
    const dia = String(date.getDate()).padStart(2, '0');
    const mes = String(date.getMonth() + 1).padStart(2, '0');
    const anio = date.getFullYear();

    return `${dia}/${mes}/${anio}`;
}

