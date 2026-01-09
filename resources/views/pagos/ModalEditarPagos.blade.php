<!-- Modal para crear nuevo pago -->
<div class="modal modal_edit_pagos" id="modalPagos_edit">
    <input type="hidden" id="paymentid_edit" name="paymentid_edit">
    <div class="modal-content_edit">
        <div class="modal-header_edit">
            <h3>Editar Pago</h3>
            <button class="close-modal_edit" onclick="closeModalEdit()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body_edit">
            <form id="payment-form_edit">
                @csrf
                <div class="form-group">
                    <label for="payment-name_edit">Nombre del pago</label>
                    <input type="text" id="payment-name_edit" placeholder="Ej: Netflix, Renta, etc.">
                </div>

                <div class="form-group">
                    <label for="payment-category_edit">Categoría</label>
                    <select id="paymentcategory_edit">
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="payment-amount_edit">Monto</label>
                        <input type="text" id="paymentamount_edit" placeholder="0.00" step="0.01" min="0"
                            oninput="formatearMiles(this)">
                    </div>

                    <div class="form-group">
                        <label for="paymentdate_edit">Fecha vencimiento</label>
                        <input type="date" id="paymentdate_edit">
                    </div>
                </div>

                <div class="form-group">
                    <label for="paymentrepeat_edit">Repetición</label>
                    <select id="paymentrepeat_edit">    
                        <option value="Unico" selected>Único</option>
                        <option value="Mensual">Mensual</option>
                        <option value="Anual">Anual</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="paymentmethod_edit">Método de pago sugerido</label>
                    <select id="paymentmethod_edit">    
                    </select>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModalEdit()">
                    <i class="fas fa-times"></i>
                    Cancelar
                </button>
                <button type="button" id="btn-actualizarMetodoPago" class="btn btn-primary"
                    onclick="validarCampos_editar()">
                    <i class="fas fa-plus"></i>
                    Actualizar
                </button>
            </div>
        </div>
    </div>
</div>
