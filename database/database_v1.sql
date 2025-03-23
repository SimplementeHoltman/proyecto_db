-- Tabla Rol
CREATE TABLE Rol (
    ID_Rol INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_Rol VARCHAR(50) NOT NULL
);

-- Tabla Usuario
CREATE TABLE Usuario (
    ID_Usuario INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Apellido VARCHAR(100) NOT NULL,
    Correo VARCHAR(150) UNIQUE NOT NULL,
    Contraseña VARCHAR(255) NOT NULL,
    Estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
    ID_Rol INT,
    FOREIGN KEY (ID_Rol) REFERENCES Rol(ID_Rol)
);

-- Tabla Modulo
CREATE TABLE Modulo (
    ID_Modulo INT AUTO_INCREMENT PRIMARY KEY,
    Descripción VARCHAR(100) NOT NULL,
    ID_Rol INT,
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
    Fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
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

-- Datos Iniciales de Roles
INSERT INTO Rol (Nombre_Rol) VALUES
('Superadmin'),
('Administrador'),
('Contable'),
('Técnico');