
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
                @csrf
                <div class="form-group">
                    <label for="payment-name">Nombre del pago</label>
                    <input type="text" id="paymentname" placeholder="Ej: Netflix, Renta, etc.">
                </div>

                <div class="form-group">
                    <label for="payment-category">Categoría</label>
                    <select id="paymentcategory">
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="payment-amount">Monto</label>
                        <input type="text" id="paymentamount" placeholder="0.00" step="0.01" min="0" oninput="formatearMiles(this)">
                    </div>

                    <div class="form-group">
                        <label for="paymentdate">Fecha vencimiento</label>
                        <input type="date" id="paymentdate">
                    </div>
                </div>

                <div class="form-group">
                    <label for="paymentrepeat">Repetición</label>
                    <select id="paymentrepeat">
                        <option value="Unico" selected>Único</option>
                        <option value="Mensual">Mensual</option>
                        <option value="Anual">Anual</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="paymentmethod">Método de pago sugerido</label>
                    <select id="paymentmethod">
                    </select>
                </div>
            </form>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="cancel-payment" onclick="closeModal_pagos()">Cancelar</button>
                <button class="btn btn-primary" id="save-payment" onclick="validarCampos()">Guardar Pago</button>
            </div>
        </div>
    </d>
</div>