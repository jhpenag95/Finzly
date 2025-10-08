@extends('components.plantillabase')
@include('components.alerts-include')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pagos/pagos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagos/responsi_pagos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagos/modal_pagos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagos/modal_responsi_pagos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagos/pagiandor_tablaPagos.css') }}">
@endpush

@section('content')
    <div class=".dashboard-container payments-view">
        <h2 class="title" style="color: #2f487c; border-bottom: 2px solid #2f487c; padding-bottom: 10px; margin-bottom: 20px;">Pagos</h2>
        
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

                {{-- Filtro de categoría --}}
                <div class="filter-group">
                    <select id="filter-category">
                    </select>
                </div>

                <button class="add-payment-btn" id="add-payment-btn" onclick="showModal_pagos()">
                    <i class="fas fa-plus"></i>
                    Nuevo Pago
                </button>
            </div>
        </div>

        @include('pagos.tablaPagos')

    </div>

    {{-- Incluir modal de nuevo pago --}}
    @include('pagos.modal_new_pago')

@endsection

@push('scripts')
    <script src="{{ asset('js/pagos/pagos.js') }}" defer></script>
    <script src="{{ asset('js/pagos/tablaPagos.js') }}" defer></script>
    <script src="{{ asset('js/recursosGenerales.js') }}" defer></script>  
@endpush
