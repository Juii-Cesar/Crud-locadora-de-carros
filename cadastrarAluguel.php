<?php
include("conexao.php");

$mensagem = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idCliente = trim($_POST['idCliente']);
    $idCarro = trim($_POST['idCarro']);
    $dtDevolucaoPrevista = trim($_POST['dtDevolucaoPrevista']);
    
    if(empty($dtDevolucaoPrevista)) {
        $dtDevolucaoPrevista = NULL;
    }

    if(!empty($idCliente) && !empty($idCarro)&& !empty($dtDevolucaoPrevista)) {
        $stmt = $conn->prepare("insert into alugueis (idCliente, idCarro, dtDevolucaoPrevista) VALUES (?, ?, ?)");
        $stmt->bind_param("iis",$idCliente,$idCarro,$dtDevolucaoPrevista);

        if ($stmt->execute()) {
            $mensagem = "<p class='msg-success'>Aluguel cadastrado com sucesso!</p>";
        } else {
            $mensagem = "<p class='msg-error'>Erro ao cadastrar: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }else{
        $mensagem = "<p class='msg-error'>Preencha os campos de ID do Cliente e ID do Carro!</p>";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=S, initial-scale=1.0">
    <title>Cadastro de Aluguel</title>
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
        <h1>Cadastro de Aluguel</h1>
        <a href="index.php">Voltar</a>
        
        <?php echo $mensagem; ?>

        <form method="post" action="">
            <label>ID do Cliente:</label>
            <input type="number" name="idCliente" required>

            <label>ID do Carro:</label>
            <input type="number" name="idCarro" required>

            <label>Data de Devolução (Opcional):</label>
            <input type="date" name="dtDevolucaoPrevista">
            
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>