<?php
session_start();

// Configuración de la base de datos
$servername = "localhost"; // Cambiar si es necesario
$username = "root";        // Cambiar si es necesario
$password = "";            // Cambiar si es necesario
$dbname = "DETAILS"; // Cambiar al nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir datos del formulario
$user = $_POST['username'];
$pass = $_POST['password'];

// Proteger contra SQL Injection
$user = $conn->real_escape_string($user);
$pass = $conn->real_escape_string($pass);

// Consultar base de datos
$sql = "SELECT * FROM admins WHERE usuario='$user' AND contraseña='$pass'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Login exitoso
    $_SESSION['admin'] = $user;
    header("Location: admin.html"); // Redirigir a admin.html
    exit();
} else {
    // Login fallido
    $error = "Usuario o contraseña incorrectos";
    header("Location: login_admin.php?error=" . urlencode($error)); // Redirigir al login con mensaje de error
    exit();
}

$conn->close();
?>
