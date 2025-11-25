<?php
include("conexao.php");

$mensagem = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $tel = trim($_POST['tel']);

    if(!empty($nome) && !empty($email) && !empty($tel)) {
        $stmt = $conn->prepare("insert into clientes (nome, email, tel) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi",$nome,$email,$tel);

        if ($stmt->execute()) {
            $mensagem = "<p class='msg-success'>Cliente cadastrado com sucesso!</p>";
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
        <h1>Cadastro de Cliente</h1>
        <a href="consultarCliente.html">Voltar</a>

        <?php echo $mensagem; ?>
        
        <form method="post" action="">
            <label>Nome:</label>
            <input type="text" name="nome" required>

            <label>Email:</label>
            <input type="email" name="email" required> 
            <label>Telefone:</label>
            <input type="tel" name="tel" required>
            <br><br>
            
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>