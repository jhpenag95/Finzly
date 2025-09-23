@extends('components.plantillabase')
@include('components.alerts-include')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/saldo_inicial/saldo_inicial.css') }}">
    <link rel="stylesheet" href="{{ asset('css/saldo_inicial/responsi_saldo_inicial.css') }}">
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
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="concepto">Concepto</label>
                            <div class="select-group">
                                <select id="concepto" name="concepto" required>
                                    <option value="">Seleccionar concepto...</option>
                                    <option value="efectivo">💵 Dinero en Efectivo</option>
                                    <option value="cuenta_corriente">🏦 Cuenta Corriente</option>
                                    <option value="cuenta_ahorros">💰 Cuenta de Ahorros</option>
                                    <option value="inversiones">📈 Inversiones y Fondos</option>
                                    <option value="criptomonedas">₿ Criptomonedas</option>
                                    <option value="tarjetas_prepago">💳 Tarjetas Prepago</option>
                                    <option value="otros_activos">🏛️ Otros Activos</option>
                                </select>
                                <i class="fas fa-chevron-down select-arrow"></i>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="valor">Valor</label>
                            <div class="input-group">
                                <span class="currency-symbol">$</span>
                                <input type="number" id="valor" name="valor" placeholder="0.00" step="0.01" min="0" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="button" class="btn-add" id="addSaldoBtn" onclick="validarCampos(event)">
                                <i class="fas fa-plus"></i>
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Lista de Saldos Registrados --}}
                <div class="saldos-registrados">
                    <div class="section-header">
                        <i class="fas fa-table"></i>
                        <h3>Saldos Registrados</h3>
                    </div>
                    <div class="table-container">
                        <table class="saldos-table" id="saldos-table">
                            <thead>
                            <tr>
                                <th>CONCEPTO</th>
                                <th>MONTO</th>
                                <th>FECHA</th>
                            </tr>
                        </thead>
                        <tbody id="saldos-tbody">
                            <tr class="empty-row">
                               <td>Efectivo</td>
                               <td>$10000</td>
                               <td>{{ date('d/m/Y') }}</td>
                            </tr>
                        </tbody>
                        </table>
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
                    <button type="button" class="btn-secondary" id="resetBtn" onclick="limpiarFormularioSaldoInicial()">
                        <i class="fas fa-undo"></i>
                        Limpiar
                    </button>
                    <button type="submit" class="btn-primary" id="saveBtn" onclick="validarCampos(event)">
                        <i class="fas fa-save"></i>
                        Guardar Saldo Inicial
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/saldo_inicial/saldo_inicial.js') }}" defer></script>
@endpush
