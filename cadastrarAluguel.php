<?php
include("conexao.php");

$mensagem = "";

// Buscar lista de clientes
$clientes = $conn->query("SELECT idClientes, nome FROM clientes ORDER BY nome");

// Buscar lista de carros disponíveis
$carros = $conn->query("SELECT idCarro, modelo, placa, valor 
                        FROM carros 
                        WHERE disponivel = 1 
                        ORDER BY modelo");

// Se enviou o formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idClientes = trim($_POST['idClientes']);
    $idCarro = trim($_POST['idCarro']);
    $dtDevolucaoPrevista = trim($_POST['dtDevolucaoPrevista']);
    
    if(empty($dtDevolucaoPrevista)) {
        $dtDevolucaoPrevista = NULL;
    }

    if(!empty($idClientes) && !empty($idCarro)) {

        // Cadastrar o aluguel
        $stmt = $conn->prepare("INSERT INTO alugueis (idCliente, idCarro, dtDevolucaoPrevista) 
                                VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $idClientes, $idCarro, $dtDevolucaoPrevista);

        if ($stmt->execute()) {

            // Marcar carro como indisponível
            $conn->query("UPDATE carros SET disponivel = 0 WHERE idCarro = $idCarro");

            $mensagem = "<p class='msg-success'>Aluguel cadastrado com sucesso!</p>";

            // Recarregar carros disponíveis após cadastro
            $carros = $conn->query("SELECT idCarro, modelo, placa, valor 
                                    FROM carros WHERE disponivel = 1 
                                    ORDER BY modelo");

        } else {
            $mensagem = "<p class='msg-error'>Erro ao cadastrar: " . $stmt->error . "</p>";
        }

        $stmt->close();

    } else {
        $mensagem = "<p class='msg-error'>Selecione um cliente e um carro!</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=S, initial-scale=1.0">
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
                <a href="consultarCarros.php">
                    <span class="icon"><i class="bi bi-car-front-fill"></i></span>
                    <span class="txtLink">Carros</span>
                </a>
            </li>
            <li class="itemMenu">
                <a href="consultarEmprestimo.php">
                    <span class="icon"><i class="bi bi-taxi-front-fill"></i></span>
                    <span class="txtLink">Alugueis</span>
                </a>
            </li>
         </ul>
    </nav>

    <div class="container">
        <h1>Cadastro de Aluguel</h1>
        <a href="consultarEmprestimo.php">Voltar</a>

        <?php echo $mensagem; ?>

        <form method="post" action="">
            <label>Cliente:</label>
            <select name="idClientes" required>
                <option value="">Selecione um cliente</option>
                <?php while($c = $clientes->fetch_assoc()) { ?>
                <option value="<?php echo $c['idClientes']; ?>">
                    <?php echo $c['nome']; ?>
                </option>
                <?php } ?>
            </select>

        
            <label>Carro:</label>
            <select name="idCarro" required>
                <option value="">Selecione um carro</option>
                <?php if($carros->num_rows > 0) { 
                    while($car = $carros->fetch_assoc()) { ?>
                <option value="<?php echo $car['idCarro']; ?>">
                    <?php echo $car['modelo'] . " | Placa: " . $car['placa'] . " | R$ " . number_format($car['valor'], 2, ',', '.'); ?>
                </option>
                <?php } 
                } else { ?>
                <option disabled>Nenhum carro disponível no momento</option>
                <?php } ?>
            </select>

        
            <label>Data de Devolução (Opcional):</label>
            <input type="date"  name="dtDevolucaoPrevista" required>
        
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>