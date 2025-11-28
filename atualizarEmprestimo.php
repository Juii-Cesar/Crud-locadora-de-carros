<?php
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idEmprestimo = $_POST["idEmprestimo"];
    $dataEmprestimo = $_POST["dataEmprestimo"];
    $dtDevolucaoPrevista = $_POST["dtDevolucaoPrevista"];
    $multa = $_POST["multa"];
    $desconto = $_POST["desconto"];
    $valorTotal = $_POST["valorTotal"];

    // Prepara o comando SQL com parâmetros
    $sql = "UPDATE alugueis SET dataEmprestimo = ?, dtDevolucaoPrevista = ?, multa = ?, desconto = ?, valorTotal = ? WHERE idEmprestimo = ?";

    // Cria a declaração preparada
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Associa as variáveis aos placeholders (s = string, i = int)
        $stmt->bind_param("sssddi", $dataEmprestimo, $dtDevolucaoPrevista, $multa, $desconto, $valorTotal, $idEmprestimo);

        // Executa a query
        if ($stmt->execute()) {
            header("Location: consultarEmprestimo.php?msg=Cliente atualizado com sucesso!");
            exit;
        } else {
            header("Location: consultarEmprestimo.php?msg=invalido");
            exit;
        }

        // Fecha o statement
        $stmt->close();
    } else {
        echo "<script>
            alert('Erro na preparação da consulta: " . addslashes($conn->error) . "');
            window.location.href = 'consultarCliente.html';
        </script>";
    }

    // Fecha a conexão
    $conn->close();

} else {
    echo "<script>
        alert('Requisição inválida.');
        window.location.href = 'consultarCliente.html';
    </script>";
}
?>