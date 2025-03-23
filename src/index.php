<?php
// Configuración de la conexión a la base de datos
$host = 'localhost'; // El servidor MySQL
$dbname = 'seguridad_db'; // Nombre de la base de datos
$username = 'dev'; // Usuario creado
$password = 'securepass'; // Contraseña del usuario

try {
    // Crear la conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexión exitosa a la base de datos.<br>";

    // Ejecutar una consulta simple
    $stmt = $pdo->query("SELECT ID_Usuario, Nombre, Correo FROM Usuario LIMIT 5");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($usuarios)) {
        echo "Usuarios encontrados:<br>";
        foreach ($usuarios as $usuario) {
            echo "ID: {$usuario['ID_Usuario']}, Nombre: {$usuario['Nombre']}, Correo: {$usuario['Correo']}<br>";
        }
    } else {
        echo "No se encontraron usuarios en la tabla.";
    }
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>