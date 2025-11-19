<?php
include("conexao.php");

if (!isset($_POST["idEmprestimo"])) {
    header("Location: consultarEmprestimo.php?msg=invalido");
    exit;
}

$idEmprestimo = $_POST["idEmprestimo"];

$stmt = $conn->prepare("DELETE FROM alugueis WHERE idEmprestimo = ?");
$stmt->bind_param("i", $idEmprestimo);

if ($stmt->execute()) {
    header("Location: consultarEmprestimo.php?msg=excluido");
    exit;
} else {
    header("Location: consultarEmprestimo.php?msg=erro");
    exit;
}

?>