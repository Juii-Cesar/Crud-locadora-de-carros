<?php
include "conexao.php";

$mensagem = "";

$buscar = $_GET['buscar'] ?? "";

$sql = "SELECT 
            a.idEmprestimo,
            c.nome AS clientes,
            car.modelo AS carros,
            car.placa,
            a.dataEmprestimo,
            a.dtDevolucaoPrevista,
            a.dataDevolucao
        FROM alugueis a
        JOIN clientes c ON a.idCliente = c.idClientes
        JOIN carros car ON a.idCarro = car.idCarro
        WHERE c.nome LIKE ?
           OR car.modelo LIKE ?
           OR car.placa LIKE ?
        ORDER BY a.idEmprestimo DESC";

$stmt = $conn->prepare($sql);
$termo = "%".$buscar."%";
$stmt->bind_param("sss", $termo, $termo, $termo);
$stmt->execute();
$result = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="menuLateral.css">
    <link rel="stylesheet" href="style.css">
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

<h1>Aluguéis</h1>

<a href="cadastrarAluguel.php" class="btn"><i class="bi bi-plus-circle"></i> Adicionar Aluguel</a>
<div id="trilho" class="trilho">
    <div id="indicador" class="indicador"></div>
</div>

<div class="btnsPdf" style="margin-top: 10px;">
    <a class="btnPdf" href="gerar_pdf.php?tipo=pendentes"><i class="bi bi-filetype-pdf"></i> Gerar PDF Pendentes</a>

    <a id="btnPdfRight" class="btnPdf" href="gerar_pdf.php?tipo=devolvidos"><i class="bi bi-filetype-pdf"></i> Gerar PDF Devolvidos</a>

    <a id="btnGrafico" class="btnPdf" href="grafico.php"><i class="bi bi-bar-chart-line"></i> Gráfico Geral</a>
    
</div>

<form method="GET">
    <input type="text" name="buscar" placeholder="Nome, modelo ou placa" value="<?= $buscar ?>">
    <button type="submit">Pesquisar</button>
</form>

<table border="1" cellpadding="6">
    <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Carro</th>
        <th>Placa</th>
        <th>Data Aluguel</th>
        <th>Previsão</th>
        <th>Status</th>
        <th>Ações</th>
    </tr>

<?php while($row = $result->fetch_assoc()){ ?>
<tr>
    <td><?= $row['idEmprestimo'] ?></td>
    <td><?= $row['clientes'] ?></td>
    <td><?= $row['carros'] ?></td>
    <td><?= $row['placa'] ?></td>
    <td><?= $row['dataEmprestimo'] ?></td>
    <td><?= $row['dtDevolucaoPrevista'] ?></td>
    <td>
        <?php if ($row['dataDevolucao'] == null): ?>
            <span style="color:red;">Pendente</span>
        <?php else: ?>
            <span style="color:green;">Devolvido</span>
        <?php endif; ?>
    </td>
    <td class="btnsEmprestimo">

        <?php if ($row['dataDevolucao'] == null): ?>
            <a class="btnEmprestimo" href="devolverAluguel.php?idEmprestimo=<?= $row['idEmprestimo'] ?>">Devolver</a>
        <?php else: ?>
            
        <?php endif; ?>

        <a class="btnEmprestimo" href="editar.php?idEmprestimo=<?= $row['idEmprestimo'] ?>">Editar</a>
    </td>
</tr>
<?php } ?>

</table>

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