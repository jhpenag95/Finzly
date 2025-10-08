@extends('components.plantillabase')
@include('components.alerts-include')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/metodopago/metodopago.css') }}">
    <link rel="stylesheet" href="{{ asset('css/metodopago/responsive_metodopago.css') }}">
    <link rel="stylesheet" href="{{ asset('css/metodopago/modalEditarMetodo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tables_design.css') }}">
    <link rel="stylesheet" href="{{ asset('css/metodopago/paginador_metodopago.css') }}">

    <link rel="stylesheet" href="{{ asset('css/modal_confir_edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal_conrf_delete.css') }}">
@endpush

@section('content')
    {{-- Formulario para Registrar Método de Pago --}}
    <h2 class="title" style="color: #2f487c; border-bottom: 2px solid #2f487c; padding-bottom: 10px; margin-bottom: 20px;">
        Registrar Métodos de Pago</h2>

    <div class="conten_metodopago">

        <form action="" class="form_metodopago">
            <h2 class="title_metodopago">Registrar Métodos de Pago</h2>
            @csrf
            <div class="conform">
                <div class="input-group">
                    <label for="metodo_pago" class="label_metodopago">Nombre:</label>
                    <input type="text" id="metodo_pago" name="metodo_pago" required placeholder="Ej: Tarjeta de Crédito">
                </div>
                <div class="select-group">
                    <label for="estatusmetodo_pago" class="label_metodopago">Estatus:</label>
                    <select id="estatusmetodo_pago" name="estatusmetodo_pago" required>
                        <option value="">Selecciona un estatus</option>
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>

                {{-- Botón de Enviar --}}
                <div class="form-actions">
                    <button type="button" class="btn-secondary">Cancelar</button>
                    <button type="button" class="btn-primary" onclick="guardarMetodoPago()">Guardar</button>
                </div>
            </div>
        </form>
    </div>

    {{-- Tabla de Métodos de Pago --}}
    <div class="conceptos-registrados">
        <div class="section-header">
            <i class="fas fa-table"></i>
            <h3>Métodos de Pago Registrados</h3>
        </div>

        <div class="table-container">

            <!-- Selector de registros por página - PARTE SUPERIOR -->
            <div class="pagination-top">
                <div class="pagination-selector_metodopago">
                    <label for="registros-select_metodopago">Mostrar:</label>
                    <select id="registros-select_metodopago" class="registros-select_metodopago">
                        <option value="5" selected>5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="all">Todos</option>
                    </select>
                    <span>registros</span>
                </div>
            </div>

            <!-- Spinner de carga -->
            <div id="loading-spinner_metodopago" class="spinner-container">
                <div class="spinner"></div>
            </div>

            <!-- Tabla de datos -->
            <table class="conceptos-table" id="metodopago-table">
                <thead>
                    <tr>
                        <th>METODO PAGO</th>
                        <th>FECHA REGISTRO</th>
                        <th>ESTATUS</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody id="metodopago-tbody">

                    <!-- Los datos se cargarán aquí dinámicamente -->
                </tbody>
            </table>

            <!-- Controles de paginación inferior -->
            <div id="pagination-controls_metodopago" class="pagination-controls_metodopago"></div>
        </div>
    </div>

    {{-- Modal para editar Método de Pago --}}
    <div class="addEditmetodopago" id="modalEditarMetodo" style="display: none">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Editar Método de Pago</h3>
                <button class="close" onclick="closeModalEdit()" type="button">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editMetodoPagoForm" onsubmit="return false;">
                    @csrf
                    <input type="hidden" id="editarMetodoPago_id" name="editarMetodoPago_id" value="">
                    <div class="form-group">
                        <label for="editarMetodoPago_nombre">Nombre del Método de Pago</label>
                        <input type="text" id="editarMetodoPago_nombre" name="editarMetodoPago_nombre" required ">
                        </div>
                        <div class="form-group">
                            <label for="editarEstatus_metodopago">Estatus</label>
                            <select id="editarEstatus_metodopago" name="editarEstatus_metodopago" required>
                                <option value="">Selecciona un estatus</option>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModalEdit()">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </button>
                    <button type="button" id="btn-actualizarMetodoPago" class="btn btn-primary"
                        onclick="actualizarmetodopago()">
                        <i class="fas fa-plus"></i>
                        Actualizar
                    </button>
                </div>
            </div>
        </div>
@endsection

{{-- modal eliminar data --}}
@include('modal_conrf_delete.modal_conrf_delete')
{{-- modal confirmar editar data --}}
@include('modal_confir_edit.modal_confir_edit')

@push('scripts')
    <script src="{{ asset('js/metodopago/metodopago.js') }}"></script>
        <script src="{{ asset('js/metodopago/tableMetodoPago.js') }}"></script>
        <script src="{{ asset('js/recursosGenerales.js') }}" defer></script>
@endpush
