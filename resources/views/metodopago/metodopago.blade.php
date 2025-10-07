@extends('components.plantillabase')
@include('components.alerts-include')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/metodopago/metodopago.css') }}">
    <link rel="stylesheet" href="{{ asset('css/metodopago/responsive_metodopago.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tables_design.css') }}">
    <link rel="stylesheet" href="{{ asset('css/metodopago/paginador_metodopago.css') }}">
@endpush

@section('content')
    {{-- Formulario para Registrar Método de Pago --}}
    <div class="conten_metodopago">
        <h2 class="title_metodopago">Métodos de Pago</h2>
        <form action="" class="form_metodopago">
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
@endsection

@push('scripts')
<script src="{{ asset('js/metodopago/metodopago.js') }}"></script>
<script src="{{ asset('js/metodopago/tableMetodoPago.js') }}"></script>
<script src="{{ asset('js/recursosGenerales.js') }}" defer></script>
@endpush