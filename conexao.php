<?php
$hostname = "localhost";
$database = "locadoracarros";
$user = "root";
$password = "";

$conn = new mysqli($hostname,$user,$password,$database);
if($conn ->connect_errno) {
    echo "Falha ao conectar: (" . $conn->connect_errno . ") " . $conn -> connect_error;
}
?>