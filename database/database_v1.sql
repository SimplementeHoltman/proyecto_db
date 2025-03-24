-- Tabla Rol
CREATE TABLE Rol (
    ID_Rol INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_Rol VARCHAR(50) NOT NULL UNIQUE
);

-- Insertar roles iniciales
INSERT INTO Rol (Nombre_Rol) VALUES
('Superadmin'),
('Administrador'),
('Contable'),
('Técnico');

-- Tabla Usuario
CREATE TABLE Usuario (
    ID_Usuario INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Apellido VARCHAR(100) NOT NULL,
    Correo VARCHAR(150) NOT NULL UNIQUE,
    Contraseña VARCHAR(255) NOT NULL,
    Estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
    ID_Rol INT,
    FOREIGN KEY (ID_Rol) REFERENCES Rol(ID_Rol)
);

-- Crear tabla Modulo para permisos granulares
CREATE TABLE Modulo (
    ID_Modulo INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(50) NOT NULL,
    Descripcion TEXT,
    Ruta VARCHAR(100) NOT NULL,
    ID_Rol INT,
    Permiso_lectura BOOLEAN DEFAULT 0,
    Permiso_escritura BOOLEAN DEFAULT 0,
    FOREIGN KEY (ID_Rol) REFERENCES Rol(ID_Rol)
);

-- Tabla Cliente
CREATE TABLE Cliente (
    ID_Cliente INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Apellido VARCHAR(100) NOT NULL,
    Correo VARCHAR(150),
    Teléfono VARCHAR(20),
    Dirección TEXT,
    Estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
    NIT VARCHAR(20)
);

-- Tabla Producto
CREATE TABLE Producto (
    ID_Producto INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_Producto VARCHAR(100) NOT NULL,
    Descripción TEXT,
    Precio DECIMAL(10,2) NOT NULL,
    Stock INT DEFAULT 0
);

-- Tabla Tipo_Factura
CREATE TABLE Tipo_Factura (
    ID_Tipo_Factura INT AUTO_INCREMENT PRIMARY KEY,
    NIT_Emisor VARCHAR(20) NOT NULL,
    Dirección_Emisor TEXT NOT NULL,
    Teléfono_Emisor VARCHAR(20) NOT NULL
);

-- Tabla Factura
CREATE TABLE Factura (
    ID_Factura INT AUTO_INCREMENT PRIMARY KEY,
    Serie_Factura VARCHAR(10) NOT NULL,
    Número_Factura VARCHAR(20) NOT NULL,
    Fecha DATE NOT NULL,
    Total DECIMAL(10,2) NOT NULL,
    Estado ENUM('Pendiente', 'Pagada', 'Anulada') DEFAULT 'Pendiente',
    ID_Cliente INT,
    ID_Tipo_Factura INT,
    FOREIGN KEY (ID_Cliente) REFERENCES Cliente(ID_Cliente),
    FOREIGN KEY (ID_Tipo_Factura) REFERENCES Tipo_Factura(ID_Tipo_Factura)
);

-- Tabla Detalle_Factura
CREATE TABLE Detalle_Factura (
    ID_Detalle INT AUTO_INCREMENT PRIMARY KEY,
    Cantidad INT NOT NULL,
    Descripción_Concepto TEXT NOT NULL,
    Descuento DECIMAL(10,2) DEFAULT 0.00,
    Subtotal DECIMAL(10,2) NOT NULL,
    ID_Factura INT,
    ID_Producto INT,
    FOREIGN KEY (ID_Factura) REFERENCES Factura(ID_Factura),
    FOREIGN KEY (ID_Producto) REFERENCES Producto(ID_Producto)
);


ALTER TABLE Usuario MODIFY Contraseña VARCHAR(255) NOT NULL;



-- Insertar módulos iniciales
INSERT INTO Modulo (Nombre, Descripcion, Ruta, ID_Rol) VALUES
('Dashboard', 'Panel principal', '/dashboard/index.php', 1),
('Usuarios', 'Gestión de usuarios', '/dashboard/crear_editar_usuario.php', 1),
('Clientes', 'Mantenimiento de clientes', '/pages/mantenimientos/clientes.php', 4),
('Facturación', 'Procesos contables', '/pages/facturacion/index.php', 3);

INSERT INTO Usuario (Nombre, Apellido, Correo, Contraseña, Estado, ID_Rol)
VALUES (
    'Admin', 
    'Sistema', 
    'superadmin@empresa.com', 
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',  -- password = "password"
    'Activo', 
    (SELECT ID_Rol FROM Rol WHERE Nombre_Rol = 'Superadmin')
);

INSERT INTO Usuario (Nombre, Apellido, Correo, Contraseña, Estado, ID_Rol)
VALUES (
    'Contador', 
    'Sistema', 
    'contador@empresa.com', 
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',  -- password = "password"
    'Activo', 
    (SELECT ID_Rol FROM Rol WHERE Nombre_Rol = 'Contable')
);