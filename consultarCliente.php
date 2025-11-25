<?php
include("conexao.php");

$consulta = isset($_POST["nome"]) ? trim($_POST["nome"]) : "";

if ($consulta == "") {
    echo "<script>
        alert('Campo de busca vazio. Por favor, insira um nome para buscar.');
        window.location.href = 'index.php';
    </script>";
    exit;
}

$sql = "SELECT * FROM clientes WHERE nome LIKE ?";
$stmt = $conn->prepare($sql);
$like = "%" . $consulta . "%";
$stmt->bind_param("s", $like);
$stmt->execute();
$resultado = $stmt->get_result();
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
    <h1>Consulta de Clientes</h1>

    <a href="consultarCliente.html">Voltar</a>
    <form method="post" action="consultarCliente.php" class="search-form">
        <input type="text" name="nome" placeholder="Pesquisar por nome..." value="<?= htmlspecialchars($consulta) ?>">
        <button type="submit">Buscar</button>
    </form>

    <?php if ($resultado->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($linha = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($linha["idClientes"]) ?></td>
                        <td><?= htmlspecialchars($linha["nome"]) ?></td>
                        <td><?= htmlspecialchars($linha["email"]) ?></td>
                        <td><?= htmlspecialchars($linha["tel"]) ?></td>
                        <td>
                            <form method="post" action="excluirCliente.php" style="display:inline;">
                                <input type="hidden" name="idClientes" value="<?= $linha["idClientes"] ?>">
                                <button type="submit">Excluir</button>
                            </form>
                            <form method="get" action="editar.php" style="display:inline; margin-left:5px;">
                                <input type="hidden" name="idClientes" value="<?= $linha["idClientes"] ?>">
                                <button type="submit">Editar</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="msg-error">Nenhum cliente encontrado.</p>
    <?php endif; ?>
</div>
</body>
</html>