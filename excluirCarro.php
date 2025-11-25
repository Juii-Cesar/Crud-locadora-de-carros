<?php
include("conexao.php");

if (!isset($_POST["idCarro"])) {
    header("Location: consultarCarros.php?msg=invalido");
    exit;
}

$idCarro = $_POST["idCarro"];

$stmt = $conn->prepare("DELETE FROM carros WHERE idCarro = ?");
$stmt->bind_param("i", $idCarro);

if ($stmt->execute()) {
    header("Location: consultarCarros.php?msg=excluido");
    exit;
} else {
    header("Location: consultarCarros.php?msg=erro");
    exit;
}

?>