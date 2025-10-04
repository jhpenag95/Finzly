$(document).ready(function () {
    $('#concepto').val('');
    $('#valor').val('');
    $('#nuevoConcepto').val('');
    // Configurar restricciones para todos los inputs numéricos
    configurarInputsNumericos();
    // Solicitar conceptos al cargar la página
    solicitarConceptos();
    // Consultar el total de saldo inicial al cargar la página
    consultarTotalSaldoInicial();
});

// Configurar restricciones para todos los inputs numéricos
function configurarInputsNumericos() {
    const inputs = $('#saldoForm input[type="number"]');

    // Prevenir caracteres no numéricos al escribir
    inputs.on('keypress', function (e) {
        // Códigos de teclas permitidas
        const teclasPermitidas = [8, 9, 27, 13, 46]; // backspace, tab, escape, enter, delete
        const esNumero = (e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105);
        const esPuntoDecimal = e.keyCode === 190 || e.keyCode === 110;
        const esCtrlKey = e.ctrlKey && [65, 67, 86, 88].includes(e.keyCode); // Ctrl+A,C,V,X

        if (teclasPermitidas.includes(e.keyCode) || esCtrlKey) {
            return; // Permitir teclas de control
        }

        if (!esNumero && !esPuntoDecimal) {
            e.preventDefault();
            return;
        }

        // Solo permitir un punto decimal
        if (esPuntoDecimal && $(this).val().includes('.')) {
            e.preventDefault();
        }
    });

    // Filtrar contenido pegado o ingresado por otros medios
    inputs.on('input', function () {
        let valor = this.value;

        // Remover caracteres no numéricos excepto punto decimal
        valor = valor.replace(/[^0-9.]/g, '');

        // Asegurar solo un punto decimal
        const partes = valor.split('.');
        if (partes.length > 2) {
            valor = partes[0] + '.' + partes.slice(1).join('');
        }

        // Limitar decimales a 2 posiciones
        if (partes.length === 2 && partes[1].length > 2) {
            valor = partes[0] + '.' + partes[1].substring(0, 2);
        }

        this.value = valor;
    });

    // Formatear al perder el foco
    inputs.on('blur', function () {
        if (this.value !== '') {
            const numero = parseFloat(this.value);
            if (!isNaN(numero)) {
                this.value = numero.toFixed(2);
            }
        }
    });
}

// Función para validar campos requeridos en saldo inicial
function validarCampos(event) {
    event.preventDefault();

    var valor = $('#valor').val();
    // console.log("valor:", valor);
    
    var concepto = $('#concepto').val();
    var tieneAlgunValor = valor.trim() !== '' || concepto.trim() !== '';

    if (!tieneAlgunValor) {

        $('#valor').css('border-color', 'var(--border-color-required)');
        $('#concepto').css('border-color', 'var(--border-color-required)');

        showAlert.error(
            'Campo requerido',
            'Por favor, ingrese datos en los campos requeridos.',
            {
                duration: 4000,
                animation: 'slide'
            }
        );
        return;
    } else {

        var concepto_data = $('#concepto').val();
        var valor_data = $('#valor').val();

        var datos = {
            concepto: concepto_data,
            valor: valor_data,
        };

        $.ajax({
            url: '/saldo_inicial/registrar',
            type: 'POST',
            data: datos,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                showAlert.success(
                    'Saldo Inicial',
                    'El saldo inicial se ha registrado correctamente',
                    {
                        duration: 4000,
                        animation: 'slide'
                    }
                );

                var accion = 'registrar';

                limpiarFormularioSaldoInicial(accion);
                // Recargar la tabla de saldos después de registrar
                consultarTotalSaldoInicial();
                consultar_listado();

                // Recargar el listado de la tabla si la función existe
                if (typeof recargarTablaSaldoInicial === 'function') {
                    recargarTablaSaldoInicial();
                }
            },
            error: function (xhr) {
                showAlert.error(
                    'Error',
                    'Hubo un error al registrar el saldo inicial',
                    {
                        duration: 4000,
                        animation: 'slide'
                    }
                );
            }
        });



    }
}

function actualizarCamposConcepto() {
    $('#concepto').css('border-color', 'var(--border-color-valid)');
}

function actualizarCamposValor() {
    $('#valor').css('border-color', 'var(--border-color-valid)');
}

// Validar número para permitir solo números y un solo punto decimal
function validarNumero(input) {
    // Eliminar cualquier carácter no numérico excepto el punto decimal
    input.value = input.value.replace(/[^0-9.]/g, '');
    // Limitar a un solo punto decimal
    input.value = input.value.replace(/(\..*?)\..*/g, '$1');
    // Evitar que comience con punto
    if (input.value.charAt(0) === '.') {
        input.value = '0' + input.value;
    }
}

//formatear el valor ingresado a miles con 2 decimales
function formatearMiles(input) {
    // Eliminar todos los caracteres que no sean dígitos
    let valor = input.value.replace(/\D/g, '');

    // Si está vacío, no hace nada
    if (!valor) {
        input.value = '';
        return;
    }

    // Agregar puntos como separador de miles
    input.value = valor.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

// Limpiar formulario
function limpiarFormularioSaldoInicial(accion) {
    $('#saldoForm')[0].reset();

    $('#concepto').val('');
    $('#valor').val('');

    $('#concepto').css('border-color', 'var(--border-color)');
    $('#valor').css('border-color', 'var(--border-color)');

    if (accion === 'limpiar') {
        showAlert.info(
            'Formulario Limpiado',
            'Todos los campos han sido restablecidos',
            {
                duration: 4000,
                animation: 'slide'
            }
        );
    }
}

// === Modal Concepto ===
function abrirModalConcepto() {
    var modal = $("#addConceptoModal");
    modal.css("display", "block");
}

function closeModal() {
    $('#nuevoConcepto').val('');
    var modal = $("#addConceptoModal");
    modal.css("display", "none");
    $('#nuevoConcepto').css('border-color', 'var(--border-color)');
}

//solicitar conceptos de saldo inicial
function solicitarConceptos() {
    $.ajax({
        url: '/ConceptoSaldoInicial/concepto',
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                // Limpiar el select antes de agregar los nuevos conceptos
                $('#concepto').empty();
                // Agregar los conceptos al select
                $('#concepto').append(new Option('Seleccione un concepto', ''));

                if (response.data.length > 0) {
                    response.data.forEach(function (concepto) {
                        $('#concepto').append(new Option(concepto.concepto, concepto.id_conpsaldo));
                    });
                } else {
                    $('#concepto').append($('<option disabled>').text('No hay conceptos disponibles').css({
                        'pointer-events': 'none',
                        'background-color': '#f5f5f5',
                        'color': '#999'
                    }));
                }
            } else {
                showAlert.error(
                    'Error',
                    response.message || 'Hubo un error al obtener los conceptos',
                    {
                        duration: 4000,
                        animation: 'slide'
                    }
                );
            }
        },
        error: function (xhr) {
            showAlert.error(
                'Error',
                'Hubo un error al obtener los conceptos',
                {
                    duration: 4000,
                    animation: 'slide'
                }
            );
        }
    });
}

function agregarConcepto() {
    var concepto = $('#nuevoConcepto').val();

    if (!concepto) {
        $('#nuevoConcepto').css('border-color', 'var(--border-color-required)');

        showAlert.error(
            'Campo requerido',
            'Por favor, ingrese un nombre para el concepto.',
            {
                duration: 4000,
                animation: 'slide'
            }
        );
        return;
    } else {
        $.ajax({
            url: '/ConceptoSaldoInicial/concepto',
            type: 'POST',
            data: {
                concepto: concepto
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {

                    showAlert.success(
                        'Concepto',
                        response.message || 'El concepto se ha registrado correctamente',
                        {
                            duration: 4000,
                            animation: 'slide'
                        }
                    );
                    closeModal();
                    solicitarConceptos();
                    $('#nuevoConcepto').val('');

                } else {
                    showAlert.error(
                        'Error',
                        response.message || 'Hubo un error al registrar el concepto',
                        {
                            duration: 4000,
                            animation: 'slide'
                        }
                    );
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                let errorMessage = 'Hubo un error al registrar el concepto';

                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        errorMessage = response.message;
                    }
                } catch (e) {
                    console.log('Error parsing JSON:', e);
                }

                showAlert.error(
                    'Error',
                    errorMessage,
                    {
                        duration: 4000,
                        animation: 'slide'
                    }
                );
            }
        });

    }

}

function validarCampoConcepto() {
    var concepto = $('#nuevoConcepto').val();
    if (!concepto) {
        $('#nuevoConcepto').css('border-color', 'var(--border-color-required)');
        return false;
    } else {
        $('#nuevoConcepto').css('border-color', 'var(--border-color-valid)');
        return true;
    }
}

//consultar el total de saldo inicial
function consultarTotalSaldoInicial() {
    $.ajax({
        url: '/saldo_inicial/total',
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                $('#totalAmount').text('$ ' + response.total);
            } else {
                showAlert.error(
                    'Error',
                    'Hubo un error al consultar el total de saldo inicial',
                    {
                        duration: 4000,
                        animation: 'slide'
                    }
                );
            }
        },
        error: function (xhr) {
            showAlert.error(
                'Error',
                'Hubo un error al consultar el total de saldo inicial',
                {
                    duration: 4000,
                    animation: 'slide'
                }
            );
        }
    });
}

//Eliminar registro de saldo inicial
function eliminarSaldoInicial(id) {

    console.log("id: " + id);

    var modal = $("#confirmDeleteModal");
    modal.css("display", "flex");

    // Remover cualquier evento anterior y asignar el nuevo
    $('#confirmDelete').off('click').on('click', function () {
        confirmDelete_saldoinit(id);
    });

}


function closeDeleteModal() {
    var modal = $("#confirmDeleteModal");
    modal.css("display", "none");
}


//confirmar eliminacion de saldo inicial
function confirmDelete_saldoinit(id) {

    var modal = $("#confirmDeleteModal");

    modal.css("display", "none");

    $.ajax({
        url: '/saldo_inicial/eliminar/' + id,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                showAlert.success(
                    'Eliminado',
                    'El registro se ha eliminado correctamente',
                    {
                        duration: 4000,
                        animation: 'slide'
                    }
                );

                // Refrescar el listado completo para mantener coherencia con los datos del servidor
                consultar_listado();
                renderizarPagina(paginaActual);

            } else {
                showAlert.error(
                    'Error',
                    'Hubo un error al eliminar el registro',
                    {
                        duration: 4000,
                        animation: 'slide'
                    }
                );
            }
        },
        error: function (xhr) {
            showAlert.error(
                'Error',
                'Hubo un error al eliminar el registro',
                {
                    duration: 4000,
                    animation: 'slide'
                }
            );
        }
    });
}

