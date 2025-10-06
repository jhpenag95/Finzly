@extends('components.plantillabase')
@include('components.alerts-include')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/saldo_inicial/saldo_inicial.css') }}">
    <link rel="stylesheet" href="{{ asset('css/saldo_inicial/responsi_saldo_inicial.css') }}">
    <link rel="stylesheet" href="{{ asset('css/saldo_inicial/modal_conceptos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tables_design.css') }}">

    <link rel="stylesheet" href="{{ asset('css/saldo_inicial/pagiandorSaldoInicial.css') }}">
    <link rel="stylesheet" href="{{ asset('css/saldo_inicial/pagiandorConceptos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/saldo_inicial/modal_table_historial.css') }}">
    <link rel="stylesheet" href="{{ asset('css/saldo_inicial/mocal_EditConcepto.css') }}">

    <link rel="stylesheet" href="{{ asset('css/modal_confir_edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal_conrf_delete.css') }}">
@endpush

@section('content')
    <div class="dashboard-container saldo-inicial-view">

        {{-- Encabezado --}}
        <div class="saldo-header">
            <h1><i class="fas fa-hand-holding-usd"></i> Configurar Saldo Inicial</h1>
            <p>Define tus saldos iniciales para comenzar a gestionar tus finanzas</p>
        </div>

        {{-- Formulario de Saldo Inicial --}}
        <div class="saldo-form-container">
            {{-- <input type="hidden" id="id_usuario" name="id_usuario" value="{{ auth()->user()->id }}"> --}}
            <input type="hidden" id="id_usuario" name="id_usuario" value="1">
            <form class="saldo-form" id="saldoForm">
                @csrf

                {{-- Sección de Registro de Saldo --}}
                <div class="saldo-section">
                    <div class="section-header">
                        <i class="fas fa-plus-circle"></i>
                        <h3>Registrar Saldo Inicial</h3>
                        <button type="button" class="btn-concepto" id="addSaldoBtn" onclick="abrirModalConcepto()">
                            <i class="fas fa-plus"></i>
                            Agregar Concepto
                        </button>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="concepto">Concepto</label>
                            <div class="select-group">
                                <select id="concepto" name="concepto" required onchange="actualizarCamposConcepto()">
                                </select>
                                <i class="fas fa-chevron-down select-arrow"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="valor">Valor</label>
                            <div class="input-group">
                                <span class="currency-symbol">$</span>
                                <input type="text" id="valor" name="valor" placeholder="0.00" required
                                    oninput="formatearMiles(this); actualizarCamposValor();">

                            </div>
                        </div>
                    </div>

                    {{-- Botones de Acción --}}
                    <div class="form-actions">
                        <button type="button" class="btn-secondary" id="resetBtn"
                            onclick="limpiarFormularioSaldoInicial('limpiar')">
                            <i class="fas fa-undo"></i>
                            Limpiar
                        </button>
                        <button type="submit" class="btn-primary" id="saveBtn" onclick="validarCampos(event)">
                            <i class="fas fa-save"></i>
                            Guardar Saldo Inicial
                        </button>
                    </div>
                </div>

                {{-- Resumen Total --}}
                <div class="saldo-summary">
                    <div class="summary-card">
                        <h3>Total de Saldo Inicial</h3>
                        <div class="total-amount" id="totalAmount">0.00</div>
                    </div>
                </div>

            </form>


            {{-- ====================================================================================
            ======== Sección de de tablas de Saldos Registrados y Listado conceptos =================
            ======================================================================================== --}}

            {{-- Lista de Saldos Registrados --}}
            <div class="saldos-registrados">
                <div class="section-header">
                    <i class="fas fa-table"></i>
                    <h3>Saldos Registrados</h3>
                </div>

                <div class="table-container">

                    <!-- Selector de registros por página - PARTE SUPERIOR -->
                    <div class="pagination-top">
                        <div class="pagination-selector">
                            <label for="registros-select">Mostrar:</label>
                            <select id="registros-select" class="registros-select">
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
                    <div id="loading-spinner" class="spinner-container">
                        <div class="spinner"></div>
                    </div>

                    <!-- Tabla de datos -->
                    <table class="saldos-table" id="saldos-table">
                        <thead>
                            <tr>
                                <th>CONCEPTO</th>
                                <th>MONTO</th>
                                <th>FECHA</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody id="saldos-tbody">

                            <!-- Los datos se cargarán aquí dinámicamente -->
                        </tbody>
                    </table>

                    <!-- Controles de paginación inferior -->
                    <div id="pagination-controls" class="pagination-controls"></div>
                </div>
            </div>

            {{-- Listado de Conceptos --}}
            <div class="conceptos-registrados">
                <div class="section-header">
                    <i class="fas fa-list"></i>
                    <h3>Conceptos Registrados</h3>
                </div>
                <div class="table-container">
                    <!-- Selector de registros por página - PARTE SUPERIOR -->
                    <div class="pagination-top">
                        <div class="pagination-selector_concepto">
                            <label for="registros-select_concepto">Mostrar:</label>
                            <select id="registros-select_concepto" class="registros-select_concepto">
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
                    <div id="loading-spinner_concepto" class="spinner-container">
                        <div class="spinner"></div>
                    </div>


                    <table class="conceptos-table" id="conceptos-table">
                        <thead>
                            <tr>
                                <th>CONCEPTO</th>
                                <th>FECHA REGISTRO</th>
                                <th>ESTATUS</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody id="conceptos-tbody">
                        </tbody>
                    </table>
                    <!-- Controles de paginación inferior -->
                    <div id="pagination-controls_concepto" class="pagination-controls"></div>
                </div>
            </div>

        </div>

        {{-- ====================================================================================
            ======== Sección modal para agregar Concepto y lista de historicos =================
            ======================================================================================== --}}


        {{-- Modal para agregar Concepto --}}
        <div id="addConceptoModal" class="modal_concepto" style="display: none;">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Agregar Nuevo Concepto</h3>
                    <button class="close" onclick="closeModal('addConceptoModal')" type="button">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="addConceptoForm" onsubmit="return false;">
                        @csrf
                        <div class="form-group">
                            <label for="nuevoConcepto">Nombre del Concepto</label>
                            <input type="text" id="nuevoConcepto" name="nuevoConcepto"
                                placeholder="Ej: Cuenta de Inversión" required oninput="validarCampoConcepto()">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" onclick="agregarConcepto()">
                        <i class="fas fa-plus"></i>
                        Agregar Concepto
                    </button>
                </div>
            </div>
        </div>

        {{-- Modal para editar Concepto --}}
        <div class="addEditConcepto" class="addEditConcepto" style="display: none">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Editar Concepto</h3>
                    <button class="close" onclick="closeModalEdit()" type="button">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="editConceptoForm" onsubmit="return false;">
                        @csrf
                        <div class="form-group">
                            <label for="editarConcepto">Nombre del Concepto</label>
                            <input type="text" id="editarConcepto" name="editarConcepto" required oninput="validarCampoConcepto()">
                        </div>
                        <div class="form-group">
                            <label for="editarEstatus">Estatus</label>
                            <select id="editarEstatus" name="editarEstatus" required>
                                <option value="Activo" selected>Activo</option>
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
                    <button type="submit" id="btn-actualizarConcepto" class="btn btn-primary" onclick="actualizarConcepto()">
                        <i class="fas fa-plus"></i>
                        Actualizar Concepto
                    </button>
                </div>
            </div>
        </div>


        {{-- Modal para ver historial de movimientos por concepto --}}
        <div id="verHistorialModal" class="modal_historial" style="display: none;">
            <div class="modal_content_historial">
                <div class="modal-header">
                    <h3 class="modal-title">Historial de Movimientos por Concepto</h3>
                    <button class="close" onclick="closeModal_historial()" type="button">&times;</button>
                </div>
                <div class="table-container">
                    <input type="hidden" id="id_concepto_historial" value="">
                    <!-- Selector de registros por página - PARTE SUPERIOR -->
                    <div class="pagination-top">
                        <div class="pagination-selector_concepto">
                            <label for="registros-select_concepto">Mostrar:</label>
                            <select id="registros-select_historial" class="registros-select_concepto">
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
                    <div id="loading-spinner_historial" class="spinner-container">
                        <div class="spinner"></div>
                    </div>


                    <table class="conceptos-table" id="historial-table" style="margin: 20px 0;">
                        <thead>
                            <tr>
                                <th>CONCEPTO</th>
                                <th>MONTO</th>
                                <th>MONTO ANTERIOR</th>
                                <th>DESCRIPCION</th>
                                <th>FECHA</th>
                                <th>TIPO MOVIMIENTO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody id="historial-tbody">
                        </tbody>
                    </table>
                    <!-- Controles de paginación inferior -->
                    <div id="pagination-controls_historial" class="pagination-controls"></div>
                </div>

            </div>
        </div>
    @endsection

    {{-- modal eliminar data --}}
    @include('modal_conrf_delete.modal_conrf_delete')
    {{-- modal confirmar editar data --}}
    @include('modal_confir_edit.modal_confir_edit')


    @push('scripts')
        <script src="{{ asset('js/saldo_inicial/saldo_inicial.js') }}" defer></script>
        <script src="{{ asset('js/saldo_inicial/tableSaldoInicial.js') }}" defer></script>
        <script src="{{ asset('js/saldo_inicial/tableConceptos.js') }}" defer></script>
        <script src="{{ asset('js/saldo_inicial/tableHitorialSaldos.js') }}" defer></script>
        <script src="{{ asset('js/recursosGenerales.js') }}" defer></script>
    @endpush
