<?php
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idCarro = $_POST["idCarro"];
    $modelo = $_POST["modelo"];
    $valor = $_POST["valor"];
    $placa = $_POST["placa"];

    // Prepara o comando SQL com parâmetros
    $sql = "UPDATE carros SET modelo = ?, valor = ?, placa = ? WHERE idCarro = ?";

    // Cria a declaração preparada
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Associa as variáveis aos placeholders (s = string, i = int)
        $stmt->bind_param("sisi", $modelo, $valor, $placa, $idCarro);

        // Executa a query
        if ($stmt->execute()) {
            header("Location: consultarCarros.php?msg=Carro atualizado com sucesso!");
            exit;
            exit;
        } else {
            header("Location: consultarCarros.php?msg=Carro atualizado com sucesso!");
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
