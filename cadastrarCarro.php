<?php
include("conexao.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $modelo = trim($_POST['modelo']);
    $valor = trim($_POST['valor']);
    $placa = trim($_POST['placa']);

    if(!empty($modelo)&& !empty($valor) && !empty($placa)) {
        $stmt = $conn->prepare("insert into carros (modelo, valor, placa) VALUES (?, ?, ?)");
        $stmt->bind_param("sii",$modelo,$valor,$placa);

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>cadastro de carro</h1>
    <a href="index.php">voltar a tela principal</a>

    <form method="post" action="">
        <label>Modelo:</label><br>
        <input type="text" name="modelo" required><br><br>

        <label>Valor:</label><br>
        <input type="number" name="valor" required><br><br>

        <label>Placa:</label><br>
        <input type="number" name="placa" required><br><br>
        
        <button type="submit">cadastrar</button>
    </form>
</body>
</html>