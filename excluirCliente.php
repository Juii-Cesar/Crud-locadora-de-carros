<?php
// excluirCliente.php
include "conexao.php";

// Verifica se foi enviado via POST e id é válido
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['idClientes'])) {
    header("Location: consultarCliente.php?msg=erro");
    exit;
}

$idClientes = intval($_POST['idClientes']);

try {
    // 1) Verifica se existe aluguel pendente para o cliente
    $sqlCheck = "SELECT COUNT(*) AS total FROM alugueis WHERE idCliente = ? AND dataDevolucao IS NULL";
    $stmt = $conn->prepare($sqlCheck);
    $stmt->bind_param("i", $idClientes);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($res['total'] > 0) {
        // Não pode excluir: possui aluguel pendente
        header("Location: consultarCliente.php?msg=erro_aluguel");
        exit;
    }

    // 2) Caso não haja pendentes, excluir o cliente (mesmo que tenha alugueis devolvidos)
    $sqlDel = "DELETE FROM clientes WHERE idClientes = ?";
    $stmtDel = $conn->prepare($sqlDel);
    $stmtDel->bind_param("i", $idClientes);
    if ($stmtDel->execute()) {
        $stmtDel->close();
        header("Location: consultarCliente.php?msg=excluido");
        exit;
    } else {
        $stmtDel->close();
        header("Location: consultarCliente.php?msg=erro");
        exit;
    }

} catch (mysqli_sql_exception $e) {
    // Em caso de erro inesperado
    // opcional: error_log($e->getMessage());
    header("Location: consultarCliente.php?msg=erro");
    exit;
}