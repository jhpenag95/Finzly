
<!-- Modal de confirmación de eliminación -->
<div class="delete-modal" id="confirmDeleteModal" style="display: none;">
    <div class="modal-content-delete">
        <div class="modal-header">
            <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
            <button type="button" class="btn-close" onclick="closeDeleteModal()" aria-label="Close">×</button>
        </div>
        <div class="modal-body">
            <p>¿Estás seguro de que deseas eliminar este registro?</p>
            <p class="text-muted mb-0">Esta acción no se puede deshacer.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Cancelar</button>
            <form id="deleteForm" style="display:inline;">
                @csrf
                <button type="button" class="btn btn-danger" id="confirmDelete">Eliminar</button>
            </form>
        </div>
    </div>
</div>
