# Préstamos Demo - Sistema de Gestión de Préstamos

Sistema completo de gestión de préstamos desarrollado con Laravel 10, que incluye solicitudes multi-paso, evaluación automatizada, gestión de contratos digitales y seguimiento de pagos.

## 📋 Tabla de Contenidos

- [Características](#-características)
- [Requisitos Previos](#-requisitos-previos)
- [Instalación](#-instalación)
- [Configuración](#-configuración)
- [Uso](#-uso)
- [Desarrollo](#-desarrollo)
- [Estructura del Proyecto](#-estructura-del-proyecto)
- [Tecnologías](#-tecnologías)
- [Solución de Problemas](#-solución-de-problemas)
- [Licencia](#-licencia)

## ✨ Características

### Para Clientes
- ✅ Solicitud de préstamo en 4 pasos
- ✅ Carga segura de documentos
- ✅ Seguimiento en tiempo real del estado de la solicitud
- ✅ Firma digital de contratos
- ✅ Historial y gestión de pagos
- ✅ Tabla de amortización interactiva
- ✅ Descarga de estados de cuenta en PDF

### Para Administradores
- ✅ Revisión y aprobación de solicitudes
- ✅ Motor de evaluación automatizado
- ✅ Verificación de documentos
- ✅ Gestión completa de préstamos
- ✅ Dashboard analítico con estadísticas
- ✅ Exportación de datos a CSV
- ✅ Panel de configuración del sistema

## 🔧 Requisitos Previos

Antes de comenzar, asegúrate de tener instalado:

- **Docker Desktop** (versión 20.10 o superior)
- **Docker Compose** (versión 2.0 o superior)
- **Git** (para clonar el repositorio)
- **Node.js** (versión 18 o superior) y **npm** (para compilar assets)
- **Composer** (solo si no usas Sail)

> **Nota**: Este proyecto utiliza Laravel Sail, que maneja automáticamente PHP, MySQL, Redis y Mailpit mediante Docker. No necesitas instalar PHP ni MySQL directamente en tu máquina.

## 🚀 Instalación

### Paso 1: Clonar el Repositorio

```bash
git clone <repository-url> prestamos-demo
cd prestamos-demo
```

### Paso 2: Configurar el Entorno

Si es la primera vez que clonas el proyecto, copia el archivo de ejemplo de variables de entorno:

```bash
cp .env.example .env
```

> **Nota**: Si el archivo `.env` ya existe, verifica que esté configurado correctamente.

### Paso 3: Instalar Dependencias de Composer

Si es la primera vez o necesitas actualizar las dependencias:

```bash
./vendor/bin/sail composer install
```

> **Importante**: Si no tienes `./vendor/bin/sail`, primero ejecuta:
> ```bash
> composer install
> ```

### Paso 4: Generar Clave de Aplicación

```bash
./vendor/bin/sail artisan key:generate
```

### Paso 5: Levantar los Contenedores Docker

```bash
./vendor/bin/sail up -d
```

Este comando iniciará los siguientes servicios:
- **Laravel** (PHP 8.4)
- **MySQL 8.0** (Base de datos)
- **Redis** (Cache y colas)
- **Mailpit** (Servidor de email para pruebas)

> **Nota**: La primera vez que ejecutes este comando, Docker descargará las imágenes necesarias, lo cual puede tomar varios minutos.

### Paso 6: Ejecutar Migraciones y Seeders

```bash
./vendor/bin/sail artisan migrate --seed
```

Este comando:
- Creará todas las tablas en la base de datos
- Ejecutará los seeders con datos de prueba:
  - Usuario administrador
  - Usuario cliente con préstamo completo
  - Clientes adicionales con datos de prueba

### Paso 7: Instalar y Compilar Assets Frontend

```bash
# Instalar dependencias de Node.js
npm install

# Compilar assets para producción
npm run build

# O ejecutar en modo desarrollo (con hot reload)
npm run dev
```

### Paso 8: Crear Enlace Simbólico para Storage

```bash
./vendor/bin/sail artisan storage:link
```

Este paso es necesario para que los archivos cargados (documentos, contratos PDF) sean accesibles públicamente.

## ⚙️ Configuración

### Variables de Entorno Principales

Edita el archivo `.env` para configurar tu entorno:

```env
APP_NAME="Préstamos Demo"
APP_ENV=local
APP_KEY=base64:...  # Generado automáticamente con key:generate
APP_DEBUG=true
APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=prestamos_demo
DB_USERNAME=sail
DB_PASSWORD=password
```

> **Nota**: Las variables de base de datos están pre-configuradas para trabajar con Laravel Sail. Si usas Sail, no necesitas cambiarlas.

### Configuración de Puerto (Opcional)

Si el puerto 8080 está ocupado, puedes cambiarlo en el archivo `.env`:

```env
APP_PORT=8080
```

Y luego reinicia los contenedores:

```bash
./vendor/bin/sail down
./vendor/bin/sail up -d
```

### Configuración del Sistema

Una vez iniciada la aplicación, los administradores pueden configurar:
- Tasas de interés por tipo de préstamo
- Límites de préstamos
- Reglas de evaluación crediticia

Desde el panel de administración → **Configuración**.

## 🎯 Uso

### Acceso a la Aplicación

Una vez completada la instalación, puedes acceder a:

- **Aplicación Principal**: http://localhost:8080
- **Mailpit (Email Testing)**: http://localhost:8025

### Usuarios de Prueba

El seeder crea automáticamente los siguientes usuarios:

#### Administrador
- **Email**: `admin@prestamos-demo.com`
- **Contraseña**: `admin123`
- **Funcionalidades**: Acceso completo al panel de administración

#### Cliente de Prueba
- **Email**: `client@prestamos-demo.com`
- **Contraseña**: `client123`
- **Datos Incluidos**:
  - ✅ Préstamo activo de $12,000.00
  - ✅ Tabla de amortización completa
  - ✅ 3 cuotas pagadas (para pruebas)
  - ✅ Cuotas pendientes
  - ✅ Contrato generado y firmado

### Flujo de Uso

#### Como Cliente:
1. **Iniciar Sesión** con las credenciales del cliente
2. **Ver Préstamos Activos** en el dashboard
3. **Realizar Pagos** desde la vista de detalles del préstamo
4. **Descargar Estados de Cuenta** en formato PDF
5. **Crear Nueva Solicitud** (si no hay préstamos pendientes)

#### Como Administrador:
1. **Iniciar Sesión** con las credenciales del administrador
2. **Revisar Solicitudes** pendientes
3. **Evaluar y Aprobar** préstamos
4. **Gestionar Préstamos** activos
5. **Ver Estadísticas** y exportar datos
6. **Configurar Sistema** desde el panel de configuración

## 💻 Desarrollo

### Comandos Útiles

```bash
# Levantar servidor de desarrollo
./vendor/bin/sail artisan serve --host=0.0.0.0 --port=8080

# Compilar assets en modo desarrollo (hot reload)
npm run dev

# Ver logs de Laravel
./vendor/bin/sail artisan tail

# Ver logs de los contenedores
./vendor/bin/sail logs -f

# Ejecutar migraciones
./vendor/bin/sail artisan migrate

# Ejecutar solo seeders (sin migraciones)
./vendor/bin/sail artisan db:seed

# Limpiar caché
./vendor/bin/sail artisan cache:clear
./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan view:clear

# Reiniciar contenedores
./vendor/bin/sail restart

# Detener contenedores
./vendor/bin/sail down

# Ejecutar tests
./vendor/bin/sail artisan test

# Formatear código (PHP)
./vendor/bin/sail pint
```

### Estructura de Alias para Sail (Opcional)

Para no tener que escribir `./vendor/bin/sail` cada vez, puedes crear un alias en tu `~/.bashrc` o `~/.zshrc`:

```bash
alias sail='./vendor/bin/sail'
```

Luego puedes usar simplemente:

```bash
sail artisan migrate
sail composer install
```

### Modo de Desarrollo Completo

Para trabajar en desarrollo con recarga automática de cambios:

**Terminal 1 - Servidor Laravel:**
```bash
./vendor/bin/sail artisan serve --host=0.0.0.0 --port=8080
```

**Terminal 2 - Compilación de Assets (Vite):**
```bash
npm run dev
```

**Terminal 3 - Logs (Opcional):**
```bash
./vendor/bin/sail artisan tail
```

## 📁 Estructura del Proyecto

```
prestamos-demo/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Controladores del panel admin
│   │   │   ├── Client/          # Controladores del panel cliente
│   │   │   └── Auth/            # Controladores de autenticación
│   │   └── Middleware/          # Middleware personalizado
│   ├── Models/                  # Modelos Eloquent
│   │   ├── Loan.php
│   │   ├── Client.php
│   │   ├── LoanApplication.php
│   │   ├── AmortizationSchedule.php
│   │   └── Contract.php
│   └── Services/                # Servicios de negocio
│       └── ContractService.php
├── database/
│   ├── migrations/              # Migraciones de base de datos
│   └── seeders/                 # Seeders de datos
│       ├── AdminSeeder.php
│       ├── RobustTestDataSeeder.php
│       └── DatabaseSeeder.php
├── resources/
│   ├── views/                   # Plantillas Blade
│   │   ├── admin/               # Vistas del panel admin
│   │   ├── client/               # Vistas del panel cliente
│   │   ├── auth/                 # Vistas de autenticación
│   │   └── layouts/              # Layouts base
│   ├── js/                      # JavaScript
│   └── css/                     # Estilos CSS
├── routes/
│   └── web.php                  # Rutas de la aplicación
├── config/                      # Archivos de configuración
├── public/                      # Punto de entrada público
└── storage/                     # Archivos almacenados
    └── app/
        └── public/              # Archivos públicos (enlazados)
```

## 🛠 Tecnologías

### Backend
- **Laravel 10.x** - Framework PHP
- **PHP 8.4** - Lenguaje de programación
- **MySQL 8.0** - Base de datos relacional
- **Redis** - Sistema de cache y colas
- **DomPDF** - Generación de PDFs

### Frontend
- **TailwindCSS 3.x** - Framework CSS
- **Alpine.js** - JavaScript reactivo
- **Vite** - Build tool y dev server
- **SweetAlert2** - Alertas y modales modernos

### Infraestructura
- **Docker** - Contenedorización
- **Laravel Sail** - Entorno de desarrollo Docker
- **Mailpit** - Servidor de email para pruebas

### Librerías Adicionales
- **Laravel Sanctum** - Autenticación API
- **Spatie Laravel Permission** - Gestión de permisos
- **Intervention Image** - Procesamiento de imágenes
- **Livewire 3.x** - Componentes reactivos

## 🔍 Solución de Problemas

### Error: "Port already in use"

Si el puerto 8080 está ocupado:

1. Cambia el puerto en `.env`:
   ```env
   APP_PORT=8081
   ```

2. Reinicia los contenedores:
   ```bash
   ./vendor/bin/sail down
   ./vendor/bin/sail up -d
   ```

### Error: "Permission denied" en Linux/Mac

Ejecuta:

```bash
sudo chown -R $USER:$USER .
chmod -R 755 storage bootstrap/cache
```

### Error: "Sail not found"

Si `./vendor/bin/sail` no existe:

```bash
composer require laravel/sail --dev
php artisan sail:install
```

### Los assets no se cargan

1. Asegúrate de que Vite esté corriendo:
   ```bash
   npm run dev
   ```

2. Verifica que `APP_URL` en `.env` coincida con la URL que estás usando.

3. Limpia el caché:
   ```bash
   ./vendor/bin/sail artisan view:clear
   ./vendor/bin/sail artisan config:clear
   ```

### Base de datos no conecta

1. Verifica que los contenedores estén corriendo:
   ```bash
   ./vendor/bin/sail ps
   ```

2. Revisa las variables de entorno en `.env`:
   ```env
   DB_HOST=mysql
   DB_DATABASE=prestamos_demo
   DB_USERNAME=sail
   DB_PASSWORD=password
   ```

3. Reinicia los contenedores:
   ```bash
   ./vendor/bin/sail down
   ./vendor/bin/sail up -d
   ```

### Los seeders no funcionan

Si los seeders fallan:

1. Asegúrate de que las migraciones estén ejecutadas:
   ```bash
   ./vendor/bin/sail artisan migrate:fresh --seed
   ```

2. Verifica que el modelo de usuario tenga los campos necesarios.

### Error al generar PDFs

Si los contratos PDF no se generan:

1. Verifica que DomPDF esté instalado:
   ```bash
   ./vendor/bin/sail composer show barryvdh/laravel-dompdf
   ```

2. Asegúrate de que el directorio de storage tenga permisos:
   ```bash
   chmod -R 755 storage
   ```

3. Crea el enlace simbólico:
   ```bash
   ./vendor/bin/sail artisan storage:link
   ```

## 📝 Notas Adicionales

### Seeders

El proyecto incluye seeders robustos que crean:

- ✅ Usuarios administrativos
- ✅ Usuarios cliente con préstamos completos
- ✅ Tablas de amortización
- ✅ Pagos realizados y pendientes
- ✅ Contratos generados y firmados
- ✅ Datos de prueba realistas

Puedes ejecutar los seeders individualmente:

```bash
./vendor/bin/sail artisan db:seed --class=RobustTestDataSeeder
```

### Archivos y Storage

Los archivos subidos (documentos, contratos) se almacenan en:
- `storage/app/public/`
- Accesibles públicamente en `/storage/` (después de `storage:link`)

### Seguridad

**⚠️ Importante**: Este proyecto está configurado para desarrollo. Para producción:

1. Cambia `APP_DEBUG=false` en `.env`
2. Configura `APP_ENV=production`
3. Asegura las credenciales de base de datos
4. Configura HTTPS
5. Revisa y ajusta los permisos de archivos
6. Implementa políticas de seguridad adicionales

## 📄 Licencia

MIT License

---

**Desarrollado con ❤️ usando Laravel**

Si encuentras algún problema o tienes sugerencias, por favor abre un issue en el repositorio.
