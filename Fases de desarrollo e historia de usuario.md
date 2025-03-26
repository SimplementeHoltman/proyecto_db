# Planificación del Proyecto y Manual de Usuario

## **Fase 1: Configuración Inicial y Estructura Básica**
### **Objetivo**  
Configurar el entorno de desarrollo y definir la estructura base del sistema.

#### **Entregables Técnicos**  
1. **Entorno de Desarrollo**  
   - Servidor local (XAMPP/WAMP).  
   - Repositorio Git inicializado.  
2. **Base de Datos**  
   - Tablas: `Usuarios`, `Productos`, `Clientes`, `Facturas`.  
   - Script SQL: `database_v1.sql`.  
3. **Front-End**  
   - Plantillas HTML/CSS para:  
     - Login (`login.php`).  
     - Dashboard (`dashboard.php`).  

---

## **Fase 2: Autenticación y Gestión de Usuarios**
### **Objetivo**  
Implementar registro, login y control de roles (administrador, técnico, contador).

#### **Entregables Técnicos**  
1. **Funcionalidades**  
   - Registro con roles (ej: `Rol_id` en `Usuarios`).  
   - Login con validación de credenciales y sesión segura (`$_SESSION`).  
   - Protección contra SQLi: Sentencias preparadas con PDO.  
2. **Base de Datos Actualizada**  
   - Campo `Estado` en `Usuarios` (activo/inactivo).  
   - Script: `database_v2.sql`.  
3. **Sistema de Roles**  
   - Middleware para verificar permisos (ej: `auth.php`).  

#### **Manual de Usuario**  
**Acceso al Sistema**  
1. **Registro**:  
   - Ruta: `/registro.php` (solo administradores).  
   - Campos: Nombre, correo, contraseña, rol.  
2. **Login**:  
   - Ruta: `/login.php`.  
   - Ingrese correo y contraseña.  
   - Si es técnico o contador, verá módulos específicos.  

---

## **Fase 3: Módulos de Gestión (Técnicos)**
### **Objetivo**  
Desarrollar interfaces para gestión de productos y clientes.

#### **Entregables Técnicos**  
1. **Módulo de Productos**  
   - CRUD: `modulo_productos_mantenimiento.php`.  
   - Acciones: Agregar, editar, eliminar.  
2. **Módulo de Clientes**  
   - CRUD: `modulo_clientes_mantenimiento.php`.  

#### **Manual de Usuario**  
**Para Técnicos**  
1. **Gestionar Productos**:  
   - Navegue a `Mantenimiento > Productos`.  
   - Use el formulario para actualizar datos.  
2. **Gestionar Clientes**:  
   - Ruta: `Mantenimiento > Clientes`.  

---

## **Fase 4: Módulos de Reportes (Contadores)**
### **Objetivo**  
Implementar generación de reportes y facturación.

#### **Entregables Técnicos**  
1. **Módulo de Facturación**  
   - Interfaz: `modulo_facturacion.php`.  
   - Generación de PDF con librería `FPDF`.  
2. **Reportes**  
   - Clientes: `modulo_cliente_reportes.php`.  
   - Productos: `modulo_productos_reportes.php`.  

#### **Manual de Usuario**  
**Para Contadores**  
1. **Generar Factura**:  
   - Ruta: `Facturación > Nueva Factura`.  
   - Seleccione cliente y productos.  
2. **Descargar Reportes**:  
   - Ej: `Reportes > Exportar a PDF`.  

---

## **Fase 5: Pruebas y Optimización**
### **Objetivo**  
Asegurar estabilidad y rendimiento.

#### **Entregables Técnicos**  
1. **Pruebas**  
   - Test de carga con Apache JMeter.  
   - Validación de roles (ej: técnicos no acceden a reportes).  
2. **Optimización**  
   - Índices en campos frecuentes (ej: `Usuarios.email`).  

#### **Manual de Usuario**  
**Reporte de Errores**  
- Si encuentra un fallo, use el formulario en `Ayuda > Reportar Problema`.  

---

## **Fase 6: Despliegue y Documentación Final**
### **Objetivo**  
Publicar el sistema y documentar su uso.

#### **Entregables Técnicos**  
1. **Despliegue**  
   - Configuración de producción en `config.php`.  
   - Script de backup: `scripts/backup_db.sh`.  

#### **Manual de Usuario**  
**Acceso a Producción**  
- URL: `https://sportvintagegt.com`  
- Credenciales proporcionadas por el administrador.  

---

## **Apéndices (Manual de Usuario)**  
1. **Glosario**  
   - **CRUD**: Crear, Leer, Actualizar, Eliminar.  
   - **PDF**: Formato de documento para reportes.  
2. **Soporte**  
   - Contacto: holtmanjose@umes.edu.gt.  
   - Horario: L-V, 9:00-18:00.  