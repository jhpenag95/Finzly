@extends('components.plantillabase')
@section('content')
    <div class="dashboard-container">
        <div class="reports-filter">
            <div class="filter-row">
                {{-- filtro por rango de fechas --}}
                <div class="filter-group">
                    <label for="date-range">Rango de fechas</label>
                    <select name="date-range" id="date-range">
                        <option value="today">Hoy</option>
                        <option value="7days">Hace 7 días</option>
                        <option value="thismonth">Este Mes</option>
                        <option value="lastmonth">Último Mes</option>
                        <option value="thisyear">Este Año</option>
                        <option value="custom">Personalizado</option>
                    </select>
                </div>
                {{-- filtro por fecha personalizada --}}
                <div class="filter-group date-custom">
                    <label for="start-date">Fecha de inicio</label>
                    <input type="date" name="start-date" id="start-date">
                </div>
                {{-- filtro por fecha personalizada --}}
                <div class="filter-group date-custom">
                    <label for="end-date">Fecha de fin</label>
                    <input type="date" name="end-date" id="end-date">
                </div>

                {{-- filtro por tipo de reporte --}}
                <div class="filter-group">
                    <label for="report-type">Tipo de reporte</label>
                    <select name="report-type" id="report-type">
                        <option value="category">Pagos por Categoría</option>
                        <option value="month">Pagos por Mes</option>
                        <option value="status">Pagos por Estado</option>
                    </select>
                </div>

                <button id="generate-report" class="btn-generate">

                    <i class="fas fa-sync-alt"></i>
                    Generar Reporte
                </button>

            </div>
        </div>

        {{--  Resultados reportes  --}}
        <div class="reports-container">
            <div class="report-chart">
                <div class="chart-header">
                    <h3>Pagos por Categoría</h3>
                    <div class="chart-actions">
                        <button class="export-btn">
                            <i class="fas fa-download"></i>
                            Exportar
                        </button>
                    </div>
                </div>

                {{--  Gráfico de barras --}}
                <div class="chart-container">
                    <canvas id="main-chart" class="main-chart">

                    </canvas>
                </div>

                {{--  Tarjetas de información --}}
                <div class="report-cards">
                    <div class="report-card">
                        <h4>Resumen de Pagos</h4>
                        <div class="stats-container">
                            <div class="stat-item">
                                <div class="stat-label">Total Pagado</div>
                                <div class="stat-value">$15,800</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-label">Pendiente</div>
                                <div class="stat-value">$2,500</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-label">Vencido</div>
                                <div class="stat-value">$3,500</div>
                            </div>
                        </div>
                    </div>
                    <div class="report-card">
                        <h4>Pagos por Estado</h4>
                        <div class="mini-chart-container">
                            <canvas id="status-chart"></canvas>
                        </div>
                    </div>
                    <div class="report-card">
                        <h4>Tendencia Mensual</h4>
                        <div class="mini-chart-container">
                            <div class="trend-chart">
                                <canvas id="monthly-trend"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
