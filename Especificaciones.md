**Especificaciones Técnicas del Módulo de Seguridad**

---

### **1. Objetivo del Proyecto**
Desarrollar un módulo de seguridad con autenticación de usuarios, control de accesos por roles y gestión de operaciones comerciales básicas. El sistema debe incluir interfaces front-end y back-end, integración con base de datos MySQL y documentación clara para su implementación.

---

### **2. Requisitos Funcionales**
#### **Interfaz de Usuario (Front-End)**
- **Páginas Básicas:**
  - Página de inicio.
  - Página de login/registro.

- **Submódulos y Accesos:**
  - **Acerca de la Empresa:** Visible para todos los roles, incluidos usuarios no autenticados.
  - **Creación de Usuario/Contraseña:** Accesible para todos los roles, pero para crear un suario se debe de estar logueado como superadmin.
  - **Mantenimientos (Acceso exclusivo para Técnicos):**
    - Gestión de Clientes.
    - Gestión de Productos.
  - **Reportes:*(Acceso exclusivo para Administradores)*
    - Reportes de Clientes.
    - Reportes de Productos.
  - **Procesos/Movimientos:(Acceso exclusivo para Contables)**
    - Módulo de Facturación.

#### **Interfaz de Administración (Back-End)**
- **Submódulo de Asignación de Accesos:**<nav>
    <ul>
        <li><a href="/index.php">Inicio</a></li>
        <li><a href="/acercade.php">Acerca de</a></li>
        <li><a href="/pages/facturacion/index.php">Facturación</a></li>
        <li><a href="/pages/mantenimientos/clientes.php">Mantenimiento</a></li>
        <li><a href="/pages/reportes/clientes.php">Reportes</a></li>
        
        <?php if(isset($_SESSION['user_id'])): ?>
            <li><a href="/dashboard/dashboard.php">Dashboard</a></li>
            <li class="user-info">
                <?= htmlspecialchars($_SESSION['nombre']) ?> 
                (<a href="/auth/logout.php">Salir</a>)
            </li>
        <?php else: ?>
            <li><a href="/auth/login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>
  - Asignación de roles: Superadmin, Administrador, Contable, Técnico.
  - Configuración de permisos por módulo.

---

### **3. Roles y Permisos**
| Rol         | Permisos                                                                                   |
|-------------|-------------------------------------------------------------------------------------------|
| Invitado    | Acceso solo a "Acerca de la Empresa" y Login.                                              |
| Superadmin  | Creación de roles, asignación global de permisos y acceso completo al sistema.            |
| Administrador| Acceso a módulo de Reportes.                                                |
| Contable    | Acceso a módulo de Procesos/Movimientos.                                   |
| Técnico     | Acceso a módulo de Mantenimientos.                                                    |

---

### **4. Estructura de la Base de Datos**
#### **Tablas Principales**
1. **Usuario**
   - Campos: `ID_Usuario (PK)`, `Nombre`, `Apellido`, `Correo`, `Contraseña`, `Estado`, `ID_Rol (FK)`.
   - Relación: N:1 con **Rol**.

2. **Rol**
   - Campos: `ID_Rol (PK)`, `Nombre_Rol`.
   - Relaciones: 1:N con **Usuario** y **Modulo**.

3. **Modulo**
   - Campos: `ID_Modulo (PK)`, `Descripción`, `ID_Rol (FK)`.

4. **Cliente**
   - Campos: `ID_Cliente (PK)`, `Nombre`, `Apellido`, `Correo`, `Teléfono`, `Dirección`, `Estado`, `NIT`.
   - Relación: 1:N con **Factura**.

5. **Factura**
   - Campos: `ID_Factura (PK)`, `Serie_Factura`, `Número_Factura`, `Fecha`, `Total`, `Estado`, `ID_Cliente (FK)`, `ID_Detalle (FK)`, `ID_Encabezado (FK)`.
   - Relaciones: N:1 con **Cliente** y **Detalle_Factura**; 1:1 con **Tipo_Factura**.

6. **Tipo_Factura**
   - Campos: `ID_Tipo_Factura (PK)`, `NIT_Emisor`, `Dirección_Emisor`, `Teléfono_Emisor`.

7. **Detalle_Factura**
   - Campos: `ID_Detalle (PK)`, `Cantidad`, `Descripción_Concepto`, `Descuento`, `Subtotal`, `ID_Producto (FK)`.
   - Relaciones: N:1 con **Factura** y **Producto**.

8. **Producto**
   - Campos: `ID_Producto (PK)`, `Nombre_Producto`, `Descripción`, `Precio`, `Stock`.
   - Relación: N:N con **Detalle_Factura**.

---

### **5. Especificaciones Técnicas**
- **Tecnologías:**
  - Lenguaje: PHP (sin frameworks).
  - Base de Datos: MySQL.
- **Seguridad:**
  - Validación de sesiones por rol.
  - Protección contra SQL Injection.

---

### **6. Estructura de Navegación**
```/proyecto-seguridad
    ├── /src                     # Código fuente principal
    │   ├── /auth                # Archivos relacionados con autenticación
    │   │   ├── login.php        # Página de inicio de sesión donde se puedan crear usuarios, para crear usuarios hay que estar logueado como superdamin
    │   │   ├── register.php     # Página de registro de usuarios
    │   │   └── logout.php       # Cerrar sesión
    │   ├── /dashboard           # Panel de control (Superadmin)
    │   │   ├── crear_editar_usuario.php # Editar y cerar usuario # accesible para superadmin
    │   │   └── eliminar_usuario.php # Eliminar usuario # accesible para superdamin
    │   ├── /pages               # Páginas públicas y privadas
    │   │   ├── index.php        # Página de inicio pública
    │   │   ├── modulo_productos_mantenimiento.php (modificar, agregar y elimiar)   # accesible para tecnicos
    │   │   ├── modulo_clientes_mantenimiento.php  (modificar, agregar y elimiar)   # accesible para tecnicos
    │   │   ├── modulo_cliente_reportes.php   (visualizara y descargar)             # accesible para contadores
    │   │   ├── modulo_productos_reportes.php (visualizara y descargar              # accesible para contadores
    │   │   └── modulo_facturacion.php # accesible para contadores
    │   ├── /includes            # Archivos reutilizables
    │   │   ├── db.php           # Conexión a la base de datos
    │   │   ├── header.php       # Encabezado común y para accesar a los modulos
    │   │   ├── footer.php       # Pie de página común
    │   │   ├── functions.php    # Funciones auxiliares
    │   │   └── middleware.php   # Validar sesiones
    │   ├── /css                 # Archivos CSS
    │   │   └── styles.css       # Estilos globales
    │   └── /js                  # Archivos JavaScript
    │       └── scripts.js       # Scripts globales
    ├── /database                # Scripts SQL
    │   ├── database_v1.sql      # Versión inicial de la base de datos
    ├── /docs                    # Documentación
    │   ├── README.md            # Instrucciones generales
    │   └── especificaciones.md  # Especificaciones técnicas
    └── .gitignore               # Archivos ignorados por Git
```
---
### 7 Middleware de Seguridad (`/src/includes/middleware.php`)
```php
<?php
session_start();
require_once __DIR__ . '/db.php';

function checkAuth() {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        header("Location: /auth/login.php");
        exit();
    }
    
    global $pdo;
    $stmt = $pdo->prepare("SELECT Estado FROM Usuario WHERE ID_Usuario = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $usuario = $stmt->fetch();

    if ($usuario['Estado'] !== 'Activo') {
        session_destroy();
        header("Location: /auth/login.php?error=Cuenta desactivada");
        exit();
    }
}

function requireRole($roles) {
    checkAuth();
    if (!in_array($_SESSION['rol'], (array)$roles)) {
        http_response_code(403);
        die("Acceso denegado: Rol {$_SESSION['rol']} no autorizado.");
    }
}
?>
``` 

### 8 Conexión a Base de Datos (`/src/includes/db.php`)
```php
<?php
$host = 'localhost';
$dbname = 'seguridad_db';
$username = 'dev';
$password = 'securepass';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
```
