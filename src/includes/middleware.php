<?php
session_start();

function require_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: /proyecto-seguridad/auth/login.php");
        exit();
    }
}

function require_role($allowed_roles) {
    require_login();
    if (!in_array($_SESSION['rol'], $allowed_roles)) {
        die("Acceso denegado. No tienes permiso para esta acción.");
    }
}
?>