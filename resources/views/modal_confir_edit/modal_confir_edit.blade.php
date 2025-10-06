<!-- Modal de confirmación para editar -->
<div class="edit-modal" id="confirmEditModal" style="display: none;">
    <div class="modal-content-edit">
        <div class="modal-header">
            <h5 class="modal-title" id="confirmEditModalLabel">Confirmar edición</h5>
            <button type="button" class="btn-close" onclick="closeEditModalConfirn()" aria-label="Close">×</button>
        </div>
        <div class="modal-body">
            <p>¿Estás seguro de que deseas editar este registro?</p>
            <p class="text-muted mb-0">Esta acción modificará los datos existentes.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeEditModalConfirn()">Cancelar</button>
            <form id="editForm" style="display:inline;">
                @csrf
                <button type="button" class="btn btn-primary" id="confirmEditBtn">Editar</button>
            </form>
        </div>
    </div>
</div>
