<?php
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

include("conexao.php");

if (!isset($_POST["idCarro"])) {
    $_SESSION["message"] = "Requisição inválida.";
    $_SESSION["msg_type"] = "error";
    header("Location: consultarCarros.php");
    exit;
}

$idCarro = intval($_POST["idCarro"]);

// 1️⃣ Verifica se o carro existe e sua disponibilidade
$sqlCarro = "SELECT disponivel FROM carros WHERE idCarro = ?";
$stmtCarro = $conn->prepare($sqlCarro);
$stmtCarro->bind_param("i", $idCarro);
$stmtCarro->execute();
$resultCarro = $stmtCarro->get_result();

if ($resultCarro->num_rows === 0) {
    $_SESSION["message"] = "Veículo não encontrado.";
    $_SESSION["msg_type"] = "error";
    header("Location: consultarCarros.php");
    exit;
}

$carro = $resultCarro->fetch_assoc();
$stmtCarro->close();

// 2️⃣ Verifica se o carro está indisponível
if ($carro["disponivel"] == 0) {
    $_SESSION["message"] = "Este veículo está alugado e não pode ser excluído.";
    $_SESSION["msg_type"] = "error";
    header("Location: consultarCarros.php");
    exit;
}

// 3️⃣ Verifica se existe algum aluguel vinculado historicamente
$sqlCheckAluguel = "SELECT idEmprestimo FROM alugueis WHERE idCarro = ?";
$stmtAluguel = $conn->prepare($sqlCheckAluguel);
$stmtAluguel->bind_param("i", $idCarro);
$stmtAluguel->execute();
$resultAluguel = $stmtAluguel->get_result();

if ($resultAluguel->num_rows > 0) {
    $_SESSION["message"] = "Este veículo não pode ser excluído pois possui registros de aluguel.";
    $_SESSION["msg_type"] = "error";
    $stmtAluguel->close();
    header("Location: consultarCarros.php");
    exit;
}

$stmtAluguel->close();

// 4️⃣ Pode excluir com segurança
$stmtDelete = $conn->prepare("DELETE FROM carros WHERE idCarro = ?");
$stmtDelete->bind_param("i", $idCarro);
$stmtDelete->execute();

$_SESSION["message"] = "Veículo excluído com sucesso!";
$_SESSION["msg_type"] = "success";

$stmtDelete->close();
$conn->close();

header("Location: consultarCarros.php");
exit;

?>