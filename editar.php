<?php
include("conexao.php");

if (isset($_GET["idClientes"])) {
    $idClientes = $_GET["idClientes"];
    $sql = "SELECT * FROM clientes WHERE idClientes = $idClientes";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $clientes = $resultado->fetch_assoc();
    } else {
        echo "<script>
            alert('Cliente não encontrado.');
            window.location.href = 'index.php';
        </script>";
        exit;
    }
} else {
    echo "<script>
        alert('id do Cliente não informado.');
        window.location.href = 'index.php';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="menuLateral.css">
    <link rel="stylesheet" href="style.css" />
    <title>AlugaCars</title>
    <link rel="shortcut icon" href="alugacars.ico" type="image/x-icon">
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

    
        <h2>Editar Cliente</h2>
        <a href="consultarCliente.html">Voltar</a>
        <div id="trilho" class="trilho">
            <div id="indicador" class="indicador"></div>
        </div>
        <form method="post" action="atualizar.php">
            <input type="hidden" name="idClientes" value="<?php echo $clientes['idClientes']; ?>">
            <label>Nome:</label><br>
            <input type="text" name="nome" value="<?php echo $clientes['nome']; ?>" required><br><br>

            <label>Email:</label><br>
            <input type="text" name="email" value="<?php echo $clientes['email']; ?>" required><br><br>

            <label>Telefone:</label><br>
            <input type="tel" id="tel" name="tel" value="<?php echo $clientes['tel']; ?>" required><br><br>

            <button type="submit">Salvar Alterações</button>
        </form>
    </div>
<div style="margin-top: 20px;">
    
</div>
</body>
<footer class="main-footer">
        <p>&copy; 2025 AlugaCars - Desenvolvido por <strong>Júlio César</strong></p>

        <div class="social-links">
            <i class="bi bi-instagram"></i><a href="https://www.instagram.com/juii.cesar/" target="_blank">Instagram</a>
            <i class="bi bi-linkedin"></i><a href="https://www.linkedin.com/in/j%C3%BAlio-c%C3%A9sar-correa-alves-dev/" target="_blank">LinkedIn</a>
            <i class="bi bi-github"></i><a href="https://github.com/Juii-Cesar" target="_blank">GitHub</a>
        </div>
    </footer>
<script src="assets/mask.js"></script>
<script src="assets/light-mode.js"></script>
</html>