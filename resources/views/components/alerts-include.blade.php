{{-- 
    ===== COMPONENTE DE ALERTAS MODERNAS =====
    Incluye los archivos CSS y JS necesarios para el sistema de alertas
    
    Uso en cualquier vista Blade:
    @include('components.alerts-include')
    
    O como componente:
    <x-alerts-include />
--}}

{{-- CSS del sistema de alertas --}}
<link rel="stylesheet" href="{{ asset('css/alerts.css') }}">

{{-- Contenedor para las alertas (se crea automáticamente, pero se puede personalizar aquí) --}}
<div class="alert-container" id="alert-container"></div>

{{-- Estilos adicionales para integración con el tema de la aplicación --}}
<style>
    /* Ajustes específicos para el tema de FinZly */
    .alert-container {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    /* Ajuste para dispositivos móviles */
    @media (max-width: 768px) {
        .alert-container {
            top: 10px;
            right: 10px;
            left: 10px;
        }
    }
    
    /* Integración con el navbar si existe */
    @media (min-width: 769px) {
        .alert-container {
            top: 80px; /* Ajustar según la altura del navbar */
        }
    }
</style>

@push('scripts')
{{-- JavaScript del sistema de alertas - se carga antes que otros scripts --}}
<script src="{{ asset('js/alerts.js') }}"></script>

{{-- Script de inicialización personalizada (opcional) --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuración personalizada del sistema de alertas
    if (window.AlertSystem) {
        // Personalizar duración por defecto
        window.AlertSystem.defaultDuration = 5000;
        
        // Personalizar número máximo de alertas
        window.AlertSystem.maxAlerts = 5;
        
        // Mostrar alerta de bienvenida si es necesario
        @if(session('success'))
            showAlert.success('¡Éxito!', '{{ session('success') }}');
        @endif
        
        @if(session('error'))
            showAlert.error('Error', '{{ session('error') }}');
        @endif
        
        @if(session('warning'))
            showAlert.warning('Advertencia', '{{ session('warning') }}');
        @endif
        
        @if(session('info'))
            showAlert.info('Información', '{{ session('info') }}');
        @endif
        
        @if($errors->any())
            @foreach($errors->all() as $error)
                showAlert.error('Error de Validación', '{{ $error }}');
            @endforeach
        @endif
    }
});
</script>
@endpush