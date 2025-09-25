# Changelog

Todos los cambios notables de este proyecto serán documentados en este archivo.

El formato está basado en [Keep a Changelog](https://keepachangelog.com/es-ES/1.0.0/),
y este proyecto adhiere a [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.1.0] - 2025-09-24

### Añadido

#### 🏗️ Arquitectura Base
- Configuración inicial de Laravel 10.x con PHP 8.4
- Configuración de Docker con Laravel Sail
- Integración de Livewire 3.x para componentes reactivos
- Configuración de TailwindCSS para estilos
- Configuración de Vite para compilación de assets

#### 🗄️ Base de Datos
- Migración para modificar tabla `users` con roles y teléfono
- Migración para tabla `clients` con información personal y financiera
- Migración para tabla `loan_applications` con flujo multi-paso
- Migración para tabla `loans` con información de préstamos aprobados
- Migración para tabla `installments` con cronograma de pagos
- Migración para tabla `payments` con registro de pagos
- Migración para tabla `documents` con gestión de archivos
- Migración para tabla `contracts` con contratos y firmas
- Migración para tabla `audit_logs` con trazabilidad del sistema
- Integración de Spatie Laravel Permission para roles y permisos

#### 🎭 Modelos y Relaciones
- Modelo `User` con roles y relaciones
- Modelo `Client` con cálculos financieros
- Modelo `LoanApplication` con lógica de evaluación
- Modelo `Loan` con generación de cronogramas
- Modelo `Installment` con gestión de cuotas
- Modelo `Payment` con registro de pagos
- Modelo `Document` con gestión segura de archivos
- Modelo `Contract` con firma electrónica
- Modelo `AuditLog` con trazabilidad completa

#### 🌱 Datos de Prueba
- Seeder para usuarios administradores (3 usuarios)
- Seeder para clientes con perfiles completos (5 usuarios)
- Seeder para solicitudes de préstamo en diferentes estados
- Configuración de evaluación de préstamos parametrizable

#### ⚙️ Configuración
- Archivo de configuración `loan-evaluation.php` con:
  - Reglas de evaluación automática
  - Tasas de interés por tipo de préstamo
  - Límites de montos por categoría
  - Opciones de plazos disponibles
  - Tipos de documentos requeridos
  - Sistema de puntuación crediticia
  - Configuración de notificaciones

#### 📚 Documentación
- README.md completo con instrucciones de instalación
- Documentación de la arquitectura del sistema
- Guía de usuarios de prueba
- Instrucciones para desarrollo

### 🔧 Configuración Técnica

#### Dependencias Principales
- `laravel/framework`: ^10.0
- `livewire/livewire`: ^3.0
- `spatie/laravel-permission`: ^6.0
- `dompdf/dompdf`: ^3.0
- `intervention/image`: ^3.0

#### Servicios Docker
- **Laravel App**: Puerto 8080
- **MySQL**: Puerto 3307
- **Redis**: Puerto 6380
- **Mailpit**: Puerto 8026 (dashboard), 1026 (SMTP)

#### Usuarios de Prueba
- **Admin**: admin@prestamos-demo.com / admin123
- **Clientes**: juan.perez@example.com / client123 (y 4 más)

### 🎯 Próximas Funcionalidades (Roadmap)

#### v0.2.0 - Flujo de Onboarding
- [ ] Componentes Livewire para onboarding multi-paso
- [ ] Validación de formularios por pasos
- [ ] Guardado automático de progreso
- [ ] Navegación entre pasos

#### v0.3.0 - Panel de Administración
- [ ] Dashboard con métricas y KPIs
- [ ] Gestión de solicitudes de préstamo
- [ ] Sistema de aprobación/rechazo
- [ ] Exportación de reportes

#### v0.4.0 - Gestión de Documentos
- [ ] Sistema de carga de archivos seguro
- [ ] Validación y verificación de documentos
- [ ] Previsualización de documentos
- [ ] Almacenamiento con URLs firmadas

#### v0.5.0 - Motor de Evaluación
- [ ] Evaluación automática de solicitudes
- [ ] Sistema de puntuación crediticia
- [ ] Reglas de negocio configurables
- [ ] Integración con bureaus de crédito

#### v0.6.0 - Contratos y Firmas
- [ ] Generación automática de contratos PDF
- [ ] Sistema de firma electrónica
- [ ] Cronograma de pagos automático
- [ ] Notificaciones por email

---

## Convenciones de Versionado

Este proyecto sigue [Semantic Versioning](https://semver.org/):

- **MAJOR** (X.0.0): Cambios incompatibles en la API
- **MINOR** (0.X.0): Nuevas funcionalidades compatibles
- **PATCH** (0.0.X): Correcciones de errores compatibles

## Convenciones de Commits

Los commits siguen [Conventional Commits](https://www.conventionalcommits.org/):

- `feat:` Nueva funcionalidad
- `fix:` Corrección de errores
- `docs:` Cambios en documentación
- `style:` Cambios de formato (sin afectar lógica)
- `refactor:` Refactorización de código
- `test:` Añadir o corregir tests
- `chore:` Tareas de mantenimiento
