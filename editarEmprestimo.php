<?php
include("conexao.php");

if (isset($_GET["idEmprestimo"])) {
    $idEmprestimo = $_GET["idEmprestimo"];
    $sql = "SELECT * FROM alugueis WHERE idEmprestimo = $idEmprestimo";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $alugueis = $resultado->fetch_assoc();
    } else {
       header("Location: consultarEmprestimo.php?msg=invalido");
    exit;
    }
} else {
    header("Location: consultarEmprestimo.php?msg=id nao informado");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
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

    
        <h2>Editar Aluguel</h2>
        <a href="consultarEmprestimo.php">Voltar</a>
        <div id="trilho" class="trilho">
            <div id="indicador" class="indicador"></div>
        </div>
        <form method="post" action="atualizar.php">
            <input type="hidden" name="idEmprestimo" value="<?php echo $alugueis['idEmprestimo']; ?>">

            <br><label>Data de emprestimo:</label>
            <input type="date" name="dataEmprestimo" value="<?php echo $alugueis['dataEmprestimo']; ?>" required><br>

            <br><label>Data de devolução:</label>
            <input type="date" name="dataDevolucao" value="<?php echo $alugueis['dataDevolucao']; ?>" required><br>

            <br><label>Data de devolução prevista:</label>
            <input type="date" name="dataDevolucao" value="<?php echo $alugueis['dataDevolucao']; ?>" required><br>

            <br><label>multa:</label>
            <input type="number" name="multa" value="<?php echo $alugueis['multa']; ?>" required><br>

            <br><label>desconto:</label>
            <input type="number" name="desconto" value="<?php echo $alugueis['desconto']; ?>" required><br>

            <br><label>valor Total:</label>
            <input type="number" name="valorTotal" value="<?php echo $alugueis['valorTotal']; ?>" required><br>
            
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
<script src="assets/light-mode.js"></script>
</html>