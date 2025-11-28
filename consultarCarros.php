<?php
include "conexao.php";

$mensagem = "";

if (isset($_GET['msg'])) {
    if ($_GET['msg'] === "excluido") {
        $mensagem = "<p class='msg-success'>Veículo excluído com sucesso!</p>";
    }
}

$buscar = $_GET['buscar'] ?? "";

// Consulta com filtro
$sql = "SELECT * FROM carros
        WHERE modelo LIKE ?
        OR placa LIKE ?
        ORDER BY modelo";

$stmt = $conn->prepare($sql);
$termo = "%".$buscar."%";
$stmt->bind_param("ss", $termo, $termo);
$stmt->execute();
$result = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlugaCars - Consultar Carros</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="menuLateral.css">
    <link rel="shortcut icon" href="alugacars.ico" type="image/x-icon">

    <style>
        /* Estilização simples da disponibilidade */
        .disp-true { color: green; font-weight: bold; }
        .disp-false { color: red; font-weight: bold; }
        
        table td img {
            width: 80px;
            border-radius: 6px;
        }
    </style>
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
        <h1>Veículos</h1>

        <a href="cadastrarCarro.php"><i class="bi bi-plus-circle"></i> Adicionar Veículo</a>

        <div id="trilho" class="trilho">
            <div id="indicador" class="indicador"></div>
        </div>

        <?php echo $mensagem; ?>

        <form method="GET">
            <input type="text" name="buscar" placeholder="Modelo ou placa" value="<?php echo $buscar; ?>">
            <button type="submit">Pesquisar</button>
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Modelo</th>
                <th>Valor</th>
                <th>Placa</th>
                <th>Disponível</th>
                <th>Imagem</th>
                <th>Ações</th>
            </tr>

            <?php while($row = $result->fetch_assoc()){ ?>
            <tr>
                <td><?= $row['idCarro']; ?></td>
                <td><?= $row['modelo']; ?></td>
                <td>R$ <?= number_format($row['valor'], 2, ',', '.'); ?></td>
                <td><?= $row['placa']; ?></td>

                <td>
                    <?php if($row['disponivel']){ ?>
                        <span class="disp-true">Disponível</span>
                    <?php } else { ?>
                        <span class="disp-false">Indisponível</span>
                    <?php } ?>
                </td>

                <td>
                    <?php if(!empty($row['urlImgs'])) { ?>
                        <img src="<?= $row['urlImgs']; ?>" alt="Carro">
                    <?php } else { ?>
                        <span style="color:#999;">Sem imagem</span>
                    <?php } ?>
                </td>

                <td>
                    <form method="post" action="excluirCarro.php" style="display:inline;">
                        <input type="hidden" name="idCarro" value="<?= $row["idCarro"] ?>">
                        <button type="submit">Excluir</button>
                    </form>

                    <form method="get" action="editarCarro.php" style="display:inline; margin-left:5px;">
                        <input type="hidden" name="idCarro" value="<?= $row["idCarro"] ?>">
                        <button type="submit">Editar</button>
                    </form>
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