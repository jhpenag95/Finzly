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
        }
    };

    const style = styles[status];
    return `
    <span style="
      display: inline-block;
      padding: 6px 16px;
      border-radius: 20px;
      background-color: ${style.bg};
      color: ${style.color};
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