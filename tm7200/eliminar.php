<?php
session_start();

// Eliminar los datos almacenados en la sesión
unset($_SESSION['registroGastos']);

// Redirigir de vuelta a la página principal
header("Location: gastos.php");
exit;
?>