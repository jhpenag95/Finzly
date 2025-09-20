@extends('components.plantillabase')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/perfil/perfil.css') }}">
@endpush

@section('content')
    <div class="dashboard-container">
        <!-- Perfil de usuario -->
        <div class="profile-container">
            <div class="profile-header">
                <div class="profile-avatar-container">
                    <div class="profile-avatar">
                        <img src="{{ Auth::user()->avatar_url ?? asset('img/FinZly.png') }}" alt="Avatar"
                            id="profile-avatar-img">
                        <button class="change-avatar-btn" id="change-avatar-btn"
                            onclick="document.getElementById('avatar-upload').click()">
                            <i class="fas fa-camera"></i>
                        </button>
                        <input type="file" id="avatar-upload" name="avatar" accept="image/*" style="display: none;"
                            onchange="updateProfileImage(this)">
                    </div>
                </div>

                <div class="profile-user-info">
                    <h3 id="profile-user-name">Usuario Ejemplo</h3>
                    <p class="user-since"><i class="fas fa-clock"></i> Usuario desde: <span id="user-since-date">Abril
                            2025</span></p>
                    <div class="user-stats">
                        <div class="stat-item">
                            <div class="stat-value" id="total-payments">15</div>
                            <div class="stat-label">Pagos Totales</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value" id="active-payments">7</div>
                            <div class="stat-label">Pagos Activos</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value" id="completed-payments">8</div>
                            <div class="stat-label">Pagos Completados</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario de perfil -->
            <form class="profile-form" id="profile-form">
                <h3>Información Personal</h3>

                <div class="form-row">
                    <div class="form-group">
                        <label for="profile-name">Nombre</label>
                        <input type="text" id="profile-name" placeholder="Tu nombre">
                    </div>

                    <div class="form-group">
                        <label for="profile-lastname">Apellido</label>
                        <input type="text" id="profile-lastname" placeholder="Tu apellido">
                    </div>
                </div>

                <div class="form-group">
                    <label for="profile-email">Correo Electrónico</label>
                    <input type="email" id="profile-email" placeholder="tu@email.com">
                </div>

                <div class="form-group">
                    <label for="profile-phone">Teléfono</label>
                    <input type="tel" id="profile-phone" placeholder="Tu número de teléfono">
                </div>

                <h3>Cambiar Contraseña</h3>

                <div class="form-group">
                    <label for="profile-current-password">Contraseña Actual</label>
                    <div class="password-input">
                        <input type="password" id="profile-current-password" placeholder="Contraseña actual">
                        <button type="button" class="toggle-password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="profile-new-password">Nueva Contraseña</label>
                        <div class="password-input">
                            <input type="password" id="profile-new-password" placeholder="Nueva contraseña">
                            <button type="button" class="toggle-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="profile-confirm-password">Confirmar Contraseña</label>
                        <div class="password-input">
                            <input type="password" id="profile-confirm-password" placeholder="Confirmar contraseña">
                            <button type="button" class="toggle-password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="password-strength" id="password-strength">
                    <div class="strength-bar">
                        <div class="strength-level" style="width: 40%;"></div>
                    </div>
                    <div class="strength-text">Débil</div>
                </div>

                <div class="password-requirements">
                    <p>La contraseña debe tener al menos:</p>
                    <ul>
                        <li class="requirement met"><i class="fas fa-check-circle"></i> 8 caracteres</li>
                        <li class="requirement"><i class="fas fa-times-circle"></i> Una letra mayúscula</li>
                        <li class="requirement met"><i class="fas fa-check-circle"></i> Una letra minúscula</li>
                        <li class="requirement"><i class="fas fa-times-circle"></i> Un número</li>
                        <li class="requirement"><i class="fas fa-times-circle"></i> Un caracter especial</li>
                    </ul>
                </div>

                {{-- <h3>Sesiones Activas</h3>

                <div class="sessions-list">
                    <div class="session-item current">
                        <div class="session-device">
                            <i class="fas fa-laptop"></i>
                            <div class="device-info">
                                <div class="device-name">Windows - Chrome</div>
                                <div class="device-location">Ciudad de México, México</div>
                            </div>
                        </div>
                        <div class="session-status">
                            <span class="current-session">Sesión actual</span>
                        </div>
                    </div>

                    <div class="session-item">
                        <div class="session-device">
                            <i class="fas fa-mobile-alt"></i>
                            <div class="device-info">
                                <div class="device-name">Android - App</div>
                                <div class="device-location">Ciudad de México, México</div>
                            </div>
                        </div>
                        <div class="session-time">
                            <span><i class="fas fa-history"></i> Último acceso: 12 abr, 2025</span>
                            <button class="btn btn-sm btn-danger close-session">
                                <i class="fas fa-sign-out-alt"></i> Cerrar
                            </button>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-danger btn-block close-all-sessions">
                    <i class="fas fa-sign-out-alt"></i> Cerrar todas las sesiones
                </button> --}}

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" id="cancel-profile">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" id="save-profile">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
