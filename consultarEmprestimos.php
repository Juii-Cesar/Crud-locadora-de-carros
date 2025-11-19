<?php
include "conexao.php";

$buscar = $_GET['buscar'] ?? "";

$sql = "SELECT 
            a.idEmprestimo,
            c.nome AS clientes,
            car.modelo AS carros,
            car.placa,
            a.dataEmprestimo,
            a.dtDevolucaoPrevista
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
    <h1>Alugueis</h1>

    <a href="cadastrarAluguel.php"><i class="bi bi-plus-circle"></i> Adicionar Aluguel</a>
    <form method="GET">
        <input type="text" name="buscar" placeholder="Nome do cliente, modelo ou placa" value="<?php echo $buscar; ?>">
        <button type="submit">Pesquisar</button>
    </form>

    <table border="1" cellpadding="6">
        <tr>
            <th>ID Empréstimo</th>
            <th>Cliente</th>
            <th>Carro</th>
            <th>Placa</th>
            <th>Data Aluguel</th>
            <th>Devolução Prevista</th>
        </tr>

        <?php while($row = $result->fetch_assoc()){ ?>
        <tr>
            <td><?php echo $row['idEmprestimo']; ?></td>
            <td><?php echo $row['clientes']; ?></td>
            <td><?php echo $row['carros']; ?></td>
            <td><?php echo $row['placa']; ?></td>
            <td><?php echo $row['dataEmprestimo']; ?></td>
            <td><?php echo $row['dtDevolucaoPrevista']; ?></td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>