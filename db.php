<?php

$db_name = "moviestar";
$host = "localhost";
$user = "root";
$pass = "";

$conn = new PDO("mysql:dbname=" . $db_name . ";host=" . $host, $user, $pass);

// Habilitar Erros
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

?>