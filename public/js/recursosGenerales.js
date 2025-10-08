// Función para obtener el badge de estado - Activo/Inactivo
function getStatusBadge(status) {
  const styles = {
    'Activo': {
      bg: '#d4edda',
      color: '#28a745'
    },
    'Inactivo': {
      bg: '#f8d7da',
      color: '#dc3545'
    },
    'PENDIENTE': {
      bg: '#fff7e6',
      color: '#fa8c16',
      border: '#ffd591'
    },
    'COMPLETADO': {
      bg: '#f6ffed',
      color: '#52c41a',
      border: '#b7eb8f'
    },
    'VENCIDO': {
      bg: '#fff2f0',
      color: '#ff4d4f',
      border: '#ffccc7'
    },
  };

  // Obtener el estilo correspondiente al estado
  const style = styles[status] || styles[status?.toUpperCase()];

  // Si no se encuentra un estilo, devolver un badge genérico
  if (!style) {
    return `<span style="display:inline-block;padding:6px 16px;border-radius:20px;background:#eee;color:#888;font-size:13px;font-weight:600;text-transform:uppercase;">${status}</span>`;
  }

  // Devolver el badge con el estilo adecuado
  return `
    <span style="
      display: inline-block;
      padding: 6px 16px;
      border-radius: 20px;
      background-color: ${style.bg};
      color: ${style.color};
      border: 1px solid ${style.border ? style.border : 'transparent'};
      font-size: 13px;
      font-weight: 600;
      text-transform: uppercase;
    ">
      ${status}
    </span>
  `;
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
