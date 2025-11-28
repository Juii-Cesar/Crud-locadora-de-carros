<?php
include "conexao.php";

// Deleta todos os alugueis que possuem dataDevolucao preenchida
$sql = "DELETE FROM alugueis WHERE dataDevolucao IS NOT NULL";
$stmt = $conn->prepare($sql);

if ($stmt->execute()) {
    header("Location: consultarEmprestimo.php?msg=devolvidos_excluidos");
    exit;
} else {
    header("Location: consultarEmprestimo.php?msg=erro_excluir");
    exit;
}