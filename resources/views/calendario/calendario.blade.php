@extends('components.plantillabase')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/calendario/calendario.css') }}">
    <link rel="stylesheet" href="{{ asset('css/calendario/responsi_calendario.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagos/modal_pagos.css') }}">
@endpush

@section('content')
    <div class="calendario-container">
        <div class="calendario-header">
            <div class="month-navigation">
                <button class="nav-button">‹</button>
                <h2>Abril 2025</h2>
                <button class="nav-button">›</button>
            </div>
            <div class="view-buttons">
                <button class="view-btn active">Mes</button>
                <button class="view-btn">Semana</button>
                <button class="view-btn">Día</button>
            </div>
            <button class="nuevo-pago-btn" onclick="showModal_pagos()">+ Nuevo Pago</button>
        </div>
        
        <div class="calendario-grid">
            <!-- Header de días de la semana -->
            <div class="calendar-weekdays">
                <div class="weekday">DOMINGO</div>
                <div class="weekday">LUNES</div>
                <div class="weekday">MARTES</div>
                <div class="weekday">MIÉRCOLES</div>
                <div class="weekday">JUEVES</div>
                <div class="weekday">VIERNES</div>
                <div class="weekday">SÁBADO</div>
            </div>
            
            <!-- Grid de días -->
            <div class="calendar-days">
                <!-- Días del mes anterior -->
                <div class="calendar-day other-month">
                    <div class="day-number">30</div>
                </div>
                <div class="calendar-day other-month">
                    <div class="day-number">31</div>
                </div>
                
                <!-- Días de abril -->
                <div class="calendar-day">
                    <div class="day-number">1</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">2</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">3</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">4</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">5</div>
                </div>
                
                <div class="calendar-day">
                    <div class="day-number">6</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">7</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">8</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">9</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">10</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">11</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">12</div>
                </div>
                
                <div class="calendar-day">
                    <div class="day-number">13</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">14</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">15</div>
                    <div class="calendar-event credito">Tarjeta de Crédito</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">16</div>
                </div>
                <div class="calendar-day today">
                    <div class="day-number">17</div>
                    <div class="calendar-event netflix">Netflix</div>
                    <div class="calendar-event internet">Internet</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">18</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">19</div>
                </div>
                
                <div class="calendar-day">
                    <div class="day-number">20</div>
                    <div class="calendar-event netflix">Netflix</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">21</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">22</div>
                    <div class="calendar-event luz">Luz CFE</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">23</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">24</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">25</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">26</div>
                </div>
                
                <div class="calendar-day">
                    <div class="day-number">27</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">28</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">29</div>
                </div>
                <div class="calendar-day">
                    <div class="day-number">30</div>
                </div>
                
                <!-- Días del mes siguiente -->
                <div class="calendar-day other-month">
                    <div class="day-number">1</div>
                </div>
                <div class="calendar-day other-month">
                    <div class="day-number">2</div>
                </div>
                <div class="calendar-day other-month">
                    <div class="day-number">3</div>
                </div>
            </div>
        </div>
    </div>
    @include('pagos.modal_new_pago')
    @push('scripts')
    <script src="{{ asset('js/pagos/pagos.js') }}" defer></script>
@endpush
@endsection
