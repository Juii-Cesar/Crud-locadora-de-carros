<?php
include("conexao.php");

if (!isset($_GET["idEmprestimo"])) {
    header("Location: consultarEmprestimo.php?msg=invalido");
    exit;
}

$idEmprestimo = $_GET["idEmprestimo"];

$sql = "SELECT 
            a.*, 
            c.nome AS cliente, 
            car.modelo, 
            car.valor AS valorDiaria,
            car.idCarro
        FROM alugueis a
        JOIN clientes c ON a.idCliente = c.idClientes
        JOIN carros car ON a.idCarro = car.idCarro
        WHERE a.idEmprestimo = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idEmprestimo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    header("Location: consultarEmprestimo.php?msg=invalido");
    exit;
}

$dados = $resultado->fetch_assoc();
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

    <h1>Devolução do Empréstimo #<?= $dados["idEmprestimo"] ?></h1>

    <a href="consultarEmprestimo.php">Voltar</a>
    <div id="trilho" class="trilho">
        <div id="indicador" class="indicador"></div>
    </div>

    <form method="post" action="finalizarLocacao.php">

        <input type="hidden" name="idEmprestimo" value="<?= $dados["idEmprestimo"] ?>">
        <input type="hidden" name="idCarro" value="<?= $dados["idCarro"] ?>">
        <input type="hidden" id="valorDiaria" value="<?= $dados["valorDiaria"] ?>">
        <input type="hidden" id="dataInicio" value="<?= $dados["dataEmprestimo"] ?>">
        <div class= "infoAluguel">
            <div>
                <p><strong>Cliente:</strong> <?= $dados["cliente"] ?></p>
                <p><strong>Carro:</strong> <?= $dados["modelo"] ?></p>
                
            </div>
            <div>
                <p><strong>Data do Empréstimo:</strong> <?= $dados["dataEmprestimo"] ?></p>
                <p><strong>Devolução Prevista:</strong> <?= $dados["dtDevolucaoPrevista"] ?></p>
                
            </div>
        </div>
        
        <br><label>Data da Devolução Real:</label>
        <input type="date" id="dataDevolucao" name="dataDevolucao" required><br>

        <br><label>Multa:</label>
        <input type="number" id="multa" name="multa" value="0" step="0.01"><br>

       <br> <label>Desconto:</label>
        <input type="number" id="desconto" name="desconto" value="0" step="0.01"><br>

        <br><label>Valor Total:</label>
        <input type="number" id="valorTotal" name="valorTotal" readonly><br>

        <button type="submit">Finalizar Devolução</button>
    </form>
</div>

<script>
// cálculo automático
function calcularTotal() {
    const valorDiaria = parseFloat(document.getElementById('valorDiaria').value);
    const dataInicio = new Date(document.getElementById('dataInicio').value);
    const dataFim = new Date(document.getElementById('dataDevolucao').value);

    if (!dataFim) return;

    const multa = parseFloat(document.getElementById('multa').value) || 0;
    const desconto = parseFloat(document.getElementById('desconto').value) || 0;

    const diffTime = Math.abs(dataFim - dataInicio);
    let dias = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    if (dias < 1) dias = 1;

    const valorBase = dias * valorDiaria;
    const total = valorBase + multa - desconto;

    document.getElementById('valorTotal').value = total.toFixed(2);
}

document.querySelectorAll("#dataDevolucao, #multa, #desconto").forEach(campo => {
    campo.addEventListener("input", calcularTotal);
});
</script>
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