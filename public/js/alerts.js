/**
 * ===== SISTEMA DE ALERTAS MODERNAS =====
 * Sistema completo de alertas reutilizables para la aplicación
 * Autor: Sistema de Alertas FinZly
 * Versión: 1.0.0
 */

class AlertSystem {
    constructor() {
        this.container = null;
        this.alerts = new Map();
        this.defaultDuration = 5000; // 5 segundos
        this.maxAlerts = 5;
        this.init();
    }

    /**
     * Inicializa el sistema de alertas
     */
    init() {
        // Crear contenedor si no existe
        if (!document.querySelector('.alert-container')) {
            this.container = document.createElement('div');
            this.container.className = 'alert-container';
            document.body.appendChild(this.container);
        } else {
            this.container = document.querySelector('.alert-container');
        }
    }

    /**
     * Muestra una alerta de éxito
     * @param {string} title - Título de la alerta
     * @param {string} message - Mensaje de la alerta
     * @param {Object} options - Opciones adicionales
     */
    success(title, message = '', options = {}) {
        return this.show('success', title, message, options);
    }

    /**
     * Muestra una alerta de error
     * @param {string} title - Título de la alerta
     * @param {string} message - Mensaje de la alerta
     * @param {Object} options - Opciones adicionales
     */
    error(title, message = '', options = {}) {
        return this.show('error', title, message, options);
    }

    /**
     * Muestra una alerta de advertencia
     * @param {string} title - Título de la alerta
     * @param {string} message - Mensaje de la alerta
     * @param {Object} options - Opciones adicionales
     */
    warning(title, message = '', options = {}) {
        return this.show('warning', title, message, options);
    }

    /**
     * Muestra una alerta de información
     * @param {string} title - Título de la alerta
     * @param {string} message - Mensaje de la alerta
     * @param {Object} options - Opciones adicionales
     */
    info(title, message = '', options = {}) {
        return this.show('info', title, message, options);
    }

    /**
     * Método principal para mostrar alertas
     * @param {string} type - Tipo de alerta (success, error, warning, info)
     * @param {string} title - Título de la alerta
     * @param {string} message - Mensaje de la alerta
     * @param {Object} options - Opciones adicionales
     */
    show(type, title, message = '', options = {}) {
        const config = {
            duration: options.duration || this.defaultDuration,
            closable: options.closable !== false,
            persistent: options.persistent || false,
            animation: options.animation || 'slide',
            pulse: options.pulse || false,
            onClick: options.onClick || null,
            onClose: options.onClose || null,
            ...options
        };

        // Limitar número de alertas
        if (this.alerts.size >= this.maxAlerts) {
            const oldestAlert = this.alerts.keys().next().value;
            this.close(oldestAlert);
        }

        const alertId = this.generateId();
        const alertElement = this.createAlertElement(alertId, type, title, message, config);
        
        // Agregar al contenedor
        this.container.appendChild(alertElement);
        this.alerts.set(alertId, {
            element: alertElement,
            config: config,
            timer: null
        });

        // Configurar auto-close si no es persistente
        if (!config.persistent && config.duration > 0) {
            this.setAutoClose(alertId, config.duration);
        }

        // Trigger de animación de entrada
        setTimeout(() => {
            alertElement.classList.add('show');
        }, 10);

        return alertId;
    }

    /**
     * Crea el elemento HTML de la alerta
     */
    createAlertElement(id, type, title, message, config) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.setAttribute('data-alert-id', id);

        // Agregar animación especial si se especifica
        if (config.animation === 'bounce') {
            alert.classList.add('bounce');
        }
        if (config.pulse) {
            alert.classList.add('pulse');
        }

        // Estructura HTML
        alert.innerHTML = `
            <div class="alert-icon"></div>
            <div class="alert-content">
                ${title ? `<div class="alert-title">${this.escapeHtml(title)}</div>` : ''}
                ${message ? `<div class="alert-message">${this.escapeHtml(message)}</div>` : ''}
            </div>
            ${config.closable ? '<button class="alert-close" type="button">&times;</button>' : ''}
            ${!config.persistent && config.duration > 0 ? '<div class="alert-progress"></div>' : ''}
        `;

        // Event listeners
        this.attachEventListeners(alert, id, config);

        return alert;
    }

    /**
     * Adjunta event listeners a la alerta
     */
    attachEventListeners(alertElement, alertId, config) {
        // Botón de cerrar
        const closeBtn = alertElement.querySelector('.alert-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                this.close(alertId);
            });
        }

        // Click en la alerta
        if (config.onClick) {
            alertElement.addEventListener('click', () => {
                config.onClick(alertId);
            });
            alertElement.style.cursor = 'pointer';
        }

        // Pausar auto-close en hover
        if (!config.persistent) {
            alertElement.addEventListener('mouseenter', () => {
                this.pauseAutoClose(alertId);
            });

            alertElement.addEventListener('mouseleave', () => {
                this.resumeAutoClose(alertId);
            });
        }
    }

    /**
     * Cierra una alerta específica
     */
    close(alertId) {
        const alertData = this.alerts.get(alertId);
        if (!alertData) return;

        const { element, config, timer } = alertData;

        // Limpiar timer si existe
        if (timer) {
            clearTimeout(timer);
        }

        // Ejecutar callback onClose
        if (config.onClose) {
            config.onClose(alertId);
        }

        // Animación de salida
        element.classList.add('fade-out');
        
        setTimeout(() => {
            if (element.parentNode) {
                element.parentNode.removeChild(element);
            }
            this.alerts.delete(alertId);
        }, 300);
    }

    /**
     * Cierra todas las alertas
     */
    closeAll() {
        const alertIds = Array.from(this.alerts.keys());
        alertIds.forEach(id => this.close(id));
    }

    /**
     * Configura el auto-close de una alerta
     */
    setAutoClose(alertId, duration) {
        const alertData = this.alerts.get(alertId);
        if (!alertData) return;

        alertData.timer = setTimeout(() => {
            this.close(alertId);
        }, duration);
    }

    /**
     * Pausa el auto-close de una alerta
     */
    pauseAutoClose(alertId) {
        const alertData = this.alerts.get(alertId);
        if (!alertData || !alertData.timer) return;

        clearTimeout(alertData.timer);
        alertData.timer = null;

        // Pausar animación de progreso
        const progressBar = alertData.element.querySelector('.alert-progress');
        if (progressBar) {
            progressBar.style.animationPlayState = 'paused';
        }
    }

    /**
     * Reanuda el auto-close de una alerta
     */
    resumeAutoClose(alertId) {
        const alertData = this.alerts.get(alertId);
        if (!alertData || alertData.config.persistent) return;

        // Reanudar animación de progreso
        const progressBar = alertData.element.querySelector('.alert-progress');
        if (progressBar) {
            progressBar.style.animationPlayState = 'running';
        }

        // Calcular tiempo restante (aproximado)
        const remainingTime = alertData.config.duration * 0.3; // Tiempo aproximado restante
        this.setAutoClose(alertId, remainingTime);
    }

    /**
     * Genera un ID único para la alerta
     */
    generateId() {
        return 'alert_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    }

    /**
     * Escapa HTML para prevenir XSS
     */
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    /**
     * Obtiene el número de alertas activas
     */
    getActiveCount() {
        return this.alerts.size;
    }

    /**
     * Verifica si una alerta específica está activa
     */
    isActive(alertId) {
        return this.alerts.has(alertId);
    }
}

// ===== FUNCIONES DE CONVENIENCIA GLOBALES =====

// Crear instancia global
window.AlertSystem = new AlertSystem();

// Funciones de conveniencia globales
window.showAlert = {
    success: (title, message, options) => window.AlertSystem.success(title, message, options),
    error: (title, message, options) => window.AlertSystem.error(title, message, options),
    warning: (title, message, options) => window.AlertSystem.warning(title, message, options),
    info: (title, message, options) => window.AlertSystem.info(title, message, options),
    close: (alertId) => window.AlertSystem.close(alertId),
    closeAll: () => window.AlertSystem.closeAll()
};

// ===== EJEMPLOS DE USO =====

/**
 * EJEMPLOS DE CÓMO USAR EL SISTEMA DE ALERTAS:
 * 
 * // Alerta básica de éxito
 * showAlert.success('¡Éxito!', 'Los datos se guardaron correctamente');
 * 
 * // Alerta de error con opciones personalizadas
 * showAlert.error('Error', 'No se pudo conectar al servidor', {
 *     duration: 10000,
 *     persistent: false,
 *     pulse: true
 * });
 * 
 * // Alerta persistente (no se cierra automáticamente)
 * const alertId = showAlert.warning('Advertencia', 'Revisa los datos antes de continuar', {
 *     persistent: true,
 *     onClick: (id) => {
 *         console.log('Alerta clickeada:', id);
 *     }
 * });
 * 
 * // Cerrar alerta específica
 * showAlert.close(alertId);
 * 
 * // Cerrar todas las alertas
 * showAlert.closeAll();
 * 
 * // Alerta con animación bounce
 * showAlert.info('Información', 'Nueva actualización disponible', {
 *     animation: 'bounce',
 *     duration: 7000
 * });
 */

// ===== INICIALIZACIÓN AUTOMÁTICA =====
document.addEventListener('DOMContentLoaded', function() {
    // El sistema se inicializa automáticamente
    console.log('Sistema de Alertas FinZly inicializado correctamente');
});