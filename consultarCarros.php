<?php
include "conexao.php";

$mensagem = "";

if (isset($_GET['msg'])) {
    if ($_GET['msg'] === "excluido") {
        $mensagem = "<p class='msg-success'>Veículo excluído com sucesso!</p>";
    }
}

$buscar = $_GET['buscar'] ?? "";

$sql = "SELECT * FROM carros
WHERE modelo like ?
    or placa LIKE ?
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
    <title>AlugaCars-ConsultarCarros</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="menuLateral.css">
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
        <h1>Veículos</h1>

        <a href="cadastrarCarro.php"><i class="bi bi-plus-circle"></i> Adicionar Veículo</a>
        <?php echo $mensagem; ?>
        <form method="GET">
            <input type="text" name="buscar" placeholder="Modelo ou placa" value="<?php echo $buscar; ?>">
            <button type="submit">Pesquisar</button>
        </form>

        <table>
            <tr>
                <th>Id Carro</th>
                <th>Modelo</th>
                <th>Valor</th>
                <th>Placa</th>
                <th>Disponibilidade</th>
            </tr>

            <?php while($row = $result->fetch_assoc()){ ?>
            <tr>
                <td><?php echo $row['idCarro']; ?></td>
                <td><?php echo $row['modelo']; ?></td>
                <td><?php echo $row['valor']; ?></td>
                <td><?php echo $row['placa']; ?></td>
                <td><?php echo $row['disponivel']; ?></td>
                <td>
                    <form method="post" action="excluirCarro.php" style="display:inline;">
                        <input type="hidden" name="idCarro" value="<?= $row["idCarro"] ?>">
                        <button type="submit">Excluir</button>
                    </form>

                    <form method="get" action="editar.php" style="display:inline; margin-left:5px;">
                        <input type="hidden" name="idCarro" value="<?= $row["idCarro"] ?>">
                        <button type="submit">Editar</button>
                    </form>
                </td>

            </tr>
            <?php } ?>
        </table>
    </div>

</body>
</html>