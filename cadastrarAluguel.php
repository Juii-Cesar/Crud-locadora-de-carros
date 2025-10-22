<?php
include("conexao.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idCliente = trim($_POST['idCliente']);
    $idCarro = trim($_POST['idCarro']);
    $dataDevolucao = trim($_POST['dataDevolucao']);

    if(!empty($idCliente)&& !empty($idCarro)) {
        $stmt = $conn->prepare("insert into alugueis (idCliente, idCarro, dataDevolucao) VALUES (?, ?, ?)");
        $stmt->bind_param("sii",$idCliente,$idCarro,$dataDevolucao);

        if ($stmt->execute()) {
            // style aqui
            echo "<p style='color:green;'>Carro cadastrado com sucesso!</p>";
        } else {
            echo "<p style='color:red;'>Erro ao cadastrar: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }else{
        echo "<p style='color:red;'>Preencha todos os campos obrigatórios!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=S, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>cadastro de aluguel</h1>
    <a href="index.php">voltar a tela principal</a>
    <form method="post" action="">
        <label>Id do Cliente:</label><br>
        <input type="number" name="idCliente" required><br><br>

        <label>Id do Carro:</label><br>
        <input type="number" name="idCarro" required><br><br>

        <label>Data de devolução:</label><br>
        <input type="date" name="dataDevolucao"><br><br>
        
        <button type="submit">cadastrar</button>
    </form>
</body>
</html>