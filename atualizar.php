<?php
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idClientes = $_POST["idClientes"];
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $tel = $_POST["tel"];

    // Prepara o comando SQL com parâmetros
    $sql = "UPDATE clientes SET nome = ?, email = ?, tel = ? WHERE idClientes = ?";

    // Cria a declaração preparada
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Associa as variáveis aos placeholders (s = string, i = int)
        $stmt->bind_param("sssi", $nome, $email, $tel, $idClientes);

        // Executa a query
        if ($stmt->execute()) {
            echo "<script>
                alert('Cliente atualizado com sucesso!');
                window.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Erro ao atualizar Cliente: " . addslashes($stmt->error) . "');
                window.location.href = 'index.php';
            </script>";
        }

        // Fecha o statement
        $stmt->close();
    } else {
        echo "<script>
            alert('Erro na preparação da consulta: " . addslashes($conn->error) . "');
            window.location.href = 'index.php';
        </script>";
    }

    // Fecha a conexão
    $conn->close();

} else {
    echo "<script>
        alert('Requisição inválida.');
        window.location.href = 'index.php';
    </script>";
}
?>