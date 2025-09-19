# Finzly
Finzly - Sistema de Gestión Financiera Personal

Finzly es una aplicación web de gestión financiera personal desarrollada con Laravel, diseñada para ayudar a los usuarios a administrar sus finanzas de manera eficiente y organizada.

## ✨ Características Principales
- 📊 Dashboard Interactivo : Panel principal con resumen visual de pagos pendientes, vencidos y completados
- 💰 Gestión de Saldo Inicial : Configuración y seguimiento del saldo inicial de cuentas
- 💳 Administración de Pagos : Sistema completo para gestionar pagos con modales interactivos
- 📅 Calendario Financiero : Vista de calendario para programar y visualizar pagos
- 🏷️ Categorización : Sistema de categorías para organizar gastos e ingresos
- 📈 Reportes : Generación de reportes financieros detallados
- 👤 Perfil de Usuario : Gestión de información personal del usuario
## 🛠️ Tecnologías Utilizadas
- Backend : Laravel 12.x (PHP 8.2+)
- Frontend : Blade Templates, HTML5, CSS3, JavaScript
- Base de Datos : SQLite (configurable)
- Iconos : FontAwesome
- Gráficos : Chart.js (para visualizaciones del dashboard)

#Estructura del Proyecto
  Finzly/
├── app/Http/Controllers/     # Controladores de la aplicación
│   ├── HomeController.php    # Dashboard principal
│   ├── PagosController.php   # Gestión de pagos
│   ├── SaldoInicialController.php
│   ├── CalendarioController.php
│   ├── CategoriasController.php
│   ├── ReporteController.php
│   └── PerfilController.php
├── resources/views/          # Vistas Blade
│   ├── home/                 # Dashboard
│   ├── pagos/               # Gestión de pagos
│   ├── saldo_inicial/       # Configuración de saldo
│   ├── calendario/          # Vista de calendario
│   ├── categorias/          # Gestión de categorías
│   ├── reporte/            # Reportes
│   ├── perfil/             # Perfil de usuario
│   └── components/         # Componentes reutilizables
├── public/css/              # Estilos CSS organizados por módulo
├── database/migrations/     # Migraciones de base de datos
└── routes/web.php          # Definición de rutas




## 🎨 Características de Diseño
- Responsive Design : Interfaz adaptable a diferentes dispositivos
- Modular CSS : Estilos organizados por componentes y responsivos
- UI/UX Moderna : Diseño limpio y profesional
- Componentes Reutilizables : Plantilla base para consistencia visual
## 🚀 Funcionalidades Implementadas
### Dashboard
- Resumen visual de pagos (pendientes, vencidos, completados)
- Gráficos interactivos con Chart.js
- Métricas financieras en tiempo real
### Gestión de Pagos
- CRUD completo de pagos
- Modales para crear/editar pagos
- Categorización de transacciones
### Sistema de Categorías
- Organización de gastos por categorías
- Interfaz intuitiva para gestión de categorías
### Calendario Financiero
- Vista de calendario para pagos programados
- Integración con el sistema de pagos
## 📋 Requisitos del Sistema
- PHP >= 8.2
- Composer
- Laravel 12.x
- SQLite (o MySQL/PostgreSQL)
