@extends('components.plantillabase')
@section('content')
    <div class="dashboard-container saldo-inicial-view">
        
        {{-- Encabezado --}}
        <div class="saldo-header">
            <h1><i class="fas fa-hand-holding-usd"></i> Configurar Saldo Inicial</h1>
            <p>Define tus saldos iniciales para comenzar a gestionar tus finanzas</p>
        </div>

        {{-- Formulario de Saldo Inicial --}}
        <div class="saldo-form-container">
            <form class="saldo-form" id="saldoForm">
                
                {{-- Sección Efectivo --}}
                <div class="saldo-section">
                    <div class="section-header">
                        <i class="fas fa-money-bill-wave"></i>
                        <h3>Efectivo</h3>
                    </div>
                    <div class="form-group">
                        <label for="efectivo">Dinero en efectivo</label>
                        <div class="input-group">
                            <input type="number" id="efectivo" name="efectivo" placeholder="0.00" step="0.01" min="0">
                        </div>
                    </div>
                </div>

                {{-- Sección Cuentas Bancarias --}}
                <div class="saldo-section">
                    <div class="section-header">
                        <i class="fas fa-university"></i>
                        <h3>Cuentas Bancarias</h3>
                    </div>
                    
                    <div class="form-group">
                        <label for="cuenta_corriente">Cuenta Corriente</label>
                        <div class="input-group">
                            <input type="number" id="cuenta_corriente" name="cuenta_corriente" placeholder="0.00" step="0.01" min="0">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="cuenta_ahorros">Cuenta de Ahorros</label>
                        <div class="input-group">
                            <input type="number" id="cuenta_ahorros" name="cuenta_ahorros" placeholder="0.00" step="0.01" min="0">
                        </div>
                    </div>
                </div>

                {{-- Sección Inversiones --}}
                <div class="saldo-section">
                    <div class="section-header">
                        <i class="fas fa-chart-line"></i>
                        <h3>Inversiones</h3>
                    </div>
                    
                    <div class="form-group">
                        <label for="inversiones">Inversiones y Fondos</label>
                        <div class="input-group">
                            <input type="number" id="inversiones" name="inversiones" placeholder="0.00" step="0.01" min="0">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="criptomonedas">Criptomonedas</label>
                        <div class="input-group">
                            <input type="number" id="criptomonedas" name="criptomonedas" placeholder="0.00" step="0.01" min="0">
                        </div>
                    </div>
                </div>

                {{-- Sección Otros Activos --}}
                <div class="saldo-section">
                    <div class="section-header">
                        <i class="fas fa-coins"></i>
                        <h3>Otros Activos</h3>
                    </div>
                    
                    <div class="form-group">
                        <label for="tarjetas_prepago">Tarjetas Prepago</label>
                        <div class="input-group">
                            <input type="number" id="tarjetas_prepago" name="tarjetas_prepago" placeholder="0.00" step="0.01" min="0">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="otros_activos">Otros Activos</label>
                        <div class="input-group">
                            <input type="number" id="otros_activos" name="otros_activos" placeholder="0.00" step="0.01" min="0">
                        </div>
                    </div>
                </div>

                {{-- Resumen Total --}}
                <div class="saldo-summary">
                    <div class="summary-card">
                        <h3>Total de Activos</h3>
                        <div class="total-amount" id="totalAmount">$0.00</div>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="form-actions">
                    <button type="button" class="btn-secondary" id="resetBtn">
                        <i class="fas fa-undo"></i>
                        Limpiar
                    </button>
                    <button type="submit" class="btn-primary" id="saveBtn">
                        <i class="fas fa-save"></i>
                        Guardar Saldo Inicial
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
