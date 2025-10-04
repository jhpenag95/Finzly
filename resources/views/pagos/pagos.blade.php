@extends('components.plantillabase')
@include('components.alerts-include')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pagos/pagos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagos/responsi_pagos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagos/modal_pagos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagos/modal_responsi_pagos.css') }}">
@endpush

@section('content')
    <div class=".dashboard-container payments-view">

        {{-- Filtros de búsqueda --}}
        <div class="payments-filter">
            <div class="filter-row">
                <div class="search-box">
                    <input type="text" id="search-payment" placeholder="Buscar Pago...">
                    <i class="fas fa-search"></i>
                </div>

                <div class="filter-group">
                    <select id="filter-status">
                        <option value="all">Todos los estados</option>
                        <option value="pending">Pendiente</option>
                        <option value="overdue">Vencido</option>
                        <option value="completed">Completado</option>
                    </select>
                </div>

                <div class="filter-group">
                    <select id="filter-category">
                        <option value="all">Todas las categorías</option>
                        <option value="services">Servicios</option>
                        <option value="subscriptions">Suscripciones</option>
                        <option value="rent">Alquiler</option>
                        <option value="loans">Préstamos</option>
                        <option value="banking">Bancario</option>
                        <option value="other">Otros</option>
                    </select>
                </div>

                <button class="add-payment-btn" id="add-payment-btn" onclick="showModal_pagos()">
                    <i class="fas fa-plus"></i>
                    Nuevo Pago
                </button>
            </div>
        </div>

        {{-- Tabla de pagos --}}
        <div class="payments-table-container">
            <table class="payments-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                        <th>Repetición</th>
                        <th>Metodo Pago</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="payments-table-body">
                    <tr class="fade-in">
                        <td data-label="Nombre">
                            <div class="payment-name-cell">
                                <span class="payment-name">Netflix</span>
                                <span class="payment-category">Suscripciones</span>
                            </div>
                        </td>
                        <td data-label="Monto">
                            <span class="payment-amount">19.99</span>
                            <span class="payment-currency">USD</span>
                        </td>
                        <td data-label="Fecha">
                            <span class="payment-date">2023-01-15</span>
                        </td>
                        <td data-label="Repetición">
                            <span class="payment-repeat">Mensual</span>
                        </td>
                        <td data-label="Metodo Pago">
                            <span class="payment-method">Tarjeta</span>
                        </td>
                        <td data-label="Estado">
                            <span class="payment-status status-pending">Pendiente</span>
                        </td>
                        <td data-label="Acciones">
                            <div class="actions-cell">
                                <button class="btn-sm complete-payment tooltip"><i class="fas fa-check"></i></button>
                                <button class="btn-sm edit-payment tooltip"><i class="fas fa-edit"></i></button>
                                <button class="btn-sm delete-payment tooltip"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr class="fade-in">
                        <td data-label="Nombre">
                            <div class="payment-name-cell">
                                <span class="payment-name">Spotify Premium</span>
                                <span class="payment-category">Suscripciones</span>
                            </div>
                        </td>
                        <td data-label="Monto">
                            <span class="payment-amount">9.99</span>
                            <span class="payment-currency">USD</span>
                        </td>
                        <td data-label="Fecha">
                            <span class="payment-date">2023-01-20</span>
                        </td>
                        <td data-label="Repetición">
                            <span class="payment-repeat">Mensual</span>
                        </td>
                        <td data-label="Metodo Pago">
                            <span class="payment-method">Tarjeta</span>
                        </td>
                        <td data-label="Estado">
                            <span class="payment-status status-completed">Completado</span>
                        </td>
                        <td data-label="Acciones">
                            <div class="actions-cell">
                                <button class="btn-sm complete-payment tooltip"><i class="fas fa-check"></i></button>
                                <button class="btn-sm edit-payment tooltip"><i class="fas fa-edit"></i></button>
                                <button class="btn-sm delete-payment tooltip"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr class="fade-in">
                        <td data-label="Nombre">
                            <div class="payment-name-cell">
                                <span class="payment-name">Alquiler Apartamento</span>
                                <span class="payment-category">Alquiler</span>
                            </div>
                        </td>
                        <td data-label="Monto">
                            <span class="payment-amount">1200.00</span>
                            <span class="payment-currency">USD</span>
                        </td>
                        <td data-label="Fecha">
                            <span class="payment-date">2023-01-01</span>
                        </td>
                        <td data-label="Repetición">
                            <span class="payment-repeat">Mensual</span>
                        </td>
                        <td data-label="Metodo Pago">
                            <span class="payment-method">Tarjeta</span>
                        </td>
                        <td data-label="Estado">
                            <span class="payment-status status-overdue">Vencido</span>
                        </td>
                        <td data-label="Acciones">
                            <div class="actions-cell">
                                <button class="btn-sm complete-payment tooltip"><i class="fas fa-check"></i></button>
                                <button class="btn-sm edit-payment tooltip"><i class="fas fa-edit"></i></button>
                                <button class="btn-sm delete-payment tooltip"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <button class="pagination-btn" disabled="">
                <i class="fas fa-chevron-left"></i>
            </button>
            <div class="pagination-pages">
                <button class="pagination-page active">1</button>
                <button class="pagination-page">2</button>
                <button class="pagination-page">3</button>
            </div>
            <button class="pagination-btn">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

    </div>

    {{-- Incluir modal de nuevo pago --}}
    @include('pagos.modal_new_pago')
@endsection

@push('scripts')
    <script src="{{ asset('js/pagos/pagos.js') }}" defer></script>
@endpush
