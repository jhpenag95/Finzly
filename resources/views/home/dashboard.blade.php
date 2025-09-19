@extends('components.plantillabase')
@section('content')
    <div class="dashboard-container">
        {{--  Resumen de pagos  --}}
        <div class="dashboard-summary">

            {{-- pagos pendientes --}}

            <div class="summary-card_dash pending">
                <div class="card-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="card-content">
                    <h3>Pagos Pendientes</h3>
                    <div class="card-value">5</div>
                    <p>$10,000</p>
                </div>
            </div>

            {{-- pagos vencidos --}}

            <div class="summary-card_dash overdue">
                <div class="card-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="card-content">
                    <h3>Pagos Vencidos</h3>
                    <div class="card-value">3</div>
                    <p>$300</p>
                </div>
            </div>

            {{-- pagos completados --}}
            <div class="summary-card_dash completed">
                <div class="card-icon">
                    <i class="fas fa-check"></i>
                </div>
                <div class="card-content">
                    <h3>Pagos Completados</h3>
                    <div class="card-value">10</div>
                    <p>$500</p>
                </div>
            </div>
        </div>
        {{--  Gráfica resumen  --}}
        <div class="dashboard-chart">
            <div class="chart-container">
                <h3>Resumen Mensual</h3>
                <canvas id="monthlyChart" style="box-sizing: border-box; display: block; height: 300px; width: 1185.6px;"
                    width="1482" height="375"></canvas>
            </div>
        </div>

        {{--  Próximos pagos  --}}
        <div class="dashboard-upcoming">
            {{-- sección nuevo pago --}}
            <div class="section-header">
                <h3>Próximos Pagos</h3>
                <button id="new-payment-btn" class="btn_new_payment" onclick="showModal_pagos()">
                    <i class="fas fa-plus"></i>
                    <span>Nuevo Pago</span>
                </button>
            </div>

            {{-- lista de pagos pendientes--}}
            <div class="payments-list">
                <div class="payment-item">
                    <div class="payment-date">
                        <span class="day">1</span>
                        <span class="month">Enero</span>
                    </div>
                    <div class="payment-details">
                        <h4>Netflix</h4>
                        <p class="category">Suscripciones</p>
                    </div>
                    <div class="payment-amount">
                        <p class="amount">-$100</p>
                    </div>
                    <div class="payment-actions">
                        <button class="mark-completed">
                            <i class="fas fa-check"></i>
                        </button>
                        <button class="edit-payment">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @include('pagos.modal_new_pago')
@endsection
