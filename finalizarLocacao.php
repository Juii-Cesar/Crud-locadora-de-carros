<?php
include("conexao.php");

$idEmprestimo = $_POST["idEmprestimo"];
$idCarro = $_POST["idCarro"];
$dataDevolucao = $_POST["dataDevolucao"];
$multa = $_POST["multa"];
$desconto = $_POST["desconto"];
$valorTotal = $_POST["valorTotal"];


$sql = "UPDATE alugueis SET 
            dataDevolucao = ?, 
            multa = ?, 
            desconto = ?, 
            valorTotal = ?
        WHERE idEmprestimo = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sdddi", $dataDevolucao, $multa, $desconto, $valorTotal, $idEmprestimo);
$stmt->execute();


$sql2 = "UPDATE carros SET disponivel = 1 WHERE idCarro = ?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("i", $idCarro);
$stmt2->execute();

header("Location: consultarEmprestimo.php?msg=devolvido");
exit;