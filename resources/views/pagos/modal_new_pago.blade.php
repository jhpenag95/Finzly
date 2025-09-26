
<!-- Modal para crear nuevo pago -->
<div class="modal payment-modal" id="new-payment-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Nuevo Recordatorio de Pago</h3>
            <button class="close-modal" onclick="closeModal_pagos()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="payment-form">
                <div class="form-group">
                    <label for="payment-name">Nombre del pago</label>
                    <input type="text" id="payment-name" placeholder="Ej: Netflix, Renta, etc.">
                </div>

                <div class="form-group">
                    <label for="payment-category">Categoría</label>
                    <select id="payment-category">
                        <option value="services">Servicios</option>
                        <option value="subscriptions">Suscripciones</option>
                        <option value="rent">Alquiler</option>
                        <option value="loans">Préstamos</option>
                        <option value="banking">Bancario</option>
                        <option value="other">Otro</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="payment-amount">Monto</label>
                        <input type="number" id="payment-amount" placeholder="0.00" step="0.01" min="0">
                    </div>

                    <div class="form-group">
                        <label for="payment-date">Fecha vencimiento</label>
                        <input type="date" id="payment-date">
                    </div>
                </div>

                <div class="form-group">
                    <label for="payment-repeat">Repetición</label>
                    <select id="payment-repeat">
                        <option value="none">Único</option>
                        <option value="monthly">Mensual</option>
                        <option value="yearly">Anual</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="payment-method">Método de pago sugerido</label>
                    <select id="payment-method">
                        <option value="card">Tarjeta</option>
                        <option value="cash">Efectivo</option>
                        <option value="transfer">Transferencia</option>
                        <option value="other">Otro</option>
                    </select>
                </div>
            </form>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="cancel-payment" onclick="closeModal_pagos()">Cancelar</button>
                <button class="btn btn-primary" id="save-payment">Guardar Pago</button>
            </div>
        </div>
    </div>
</div>