<?php
include("conexao.php");

$mensagem = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $modelo = trim($_POST['modelo']);
    $valor = trim($_POST['valor']);
    $placa = trim($_POST['placa']);

    if(!empty($modelo) && !empty($valor) && !empty($placa)) {
        $stmt = $conn->prepare("insert into carros (modelo, valor, placa) VALUES (?, ?, ?)");
        $stmt->bind_param("sii",$modelo,$valor,$placa);

        if ($stmt->execute()) {
            $mensagem = "<p class='msg-success'>Carro cadastrado com sucesso!</p>";
        } else {
            $mensagem = "<p class='msg-error'>Erro ao cadastrar: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }else{
        $mensagem = "<p class='msg-error'>Preencha todos os campos obrigatórios!</p>";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlugaCars</title>
    <link rel="shortcut icon" href="alugacars.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="menuLateral.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

     <nav class="menuLateral">
        <div class="btnAbrir">
            <i class="bi bi-list"></i>
        </div>
         <ul>
            <li class="itemMenu">
                <a href="index.php">
                    <span class="icon"><i class="bi bi-house"></i></span>
                    <span class="txtLink">Home</span>
                </a>
            </li>
            <li class="itemMenu">
                <a href="consultarCliente.html">
                    <span class="icon"><i class="bi bi-person"></i></span>
                    <span class="txtLink">Clientes</span>
                </a>
            </li>
            <li class="itemMenu">
                <a href="#">
                    <span class="icon"><i class="bi bi-car-front-fill"></i></span>
                    <span class="txtLink">Carros</span>
                </a>
            </li>
            <li class="itemMenu">
                <a href="#">
                    <span class="icon"><i class="bi bi-taxi-front-fill"></i></span>
                    <span class="txtLink">Alugueis</span>
                </a>
            </li>
         </ul>
    </nav>

    <div class="container">
        <h1>Cadastro de Carro</h1>
        <a href="index.php">Voltar</a>

        <?php echo $mensagem; ?>

        <form method="post" action="">
            <label>Modelo:</label>
            <input type="text" name="modelo" required>

            <label>Valor (R$):</label>
            <input type="number" name="valor" step="0.01" required> <label>Placa (apenas números):</label>
            <input type="number" name="placa" required>
            
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>