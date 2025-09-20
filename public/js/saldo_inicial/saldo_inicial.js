$(document).ready(function () {
    // Configurar restricciones para todos los inputs numéricos
    configurarInputsNumericos();
});

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


function validarCampos(event) {
    event.preventDefault();

    // Convertir a array y verificar si alguno tiene valor
    const tieneAlgunValor = $('#saldoForm input[type="number"]').toArray().some(input => {
        const valor = $(input).val();
        return valor !== '' && parseFloat(valor) > 0;
    });

    if (!tieneAlgunValor) {
        showAlert.error(
            'Campo requerido',
            'Por favor, ingrese datos en al menos uno de los campos.',
            {
                duration: 3000,
                animation: 'slide'
            }
        );
        return;
    }

    // Continuar con el envío del formulario
    console.log('Formulario válido');
}

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

// Limpiar formulario
function limpiarFormularioSaldoInicial() {
    $('#saldoForm')[0].reset();

    // Mostrar confirmación con alerta moderna
    showAlert.info(
        'Formulario Limpiado',
        'Todos los campos han sido restablecidos',
        {
            duration: 3000,
            animation: 'slide'
        }
    );
}

// Función para mostrar alertas de validación en tiempo real
function mostrarAlertaValidacion(mensaje, tipo = 'warning') {
    showAlert[tipo](
        'Validación de Campo',
        mensaje,
        {
            duration: 4000,
            closable: true
        }
    );
}