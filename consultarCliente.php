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
    <title>Consulta de Clientes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Consulta de Clientes</h1>

    <a href="index.php">Voltar</a>
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
                            <form method="post" action="excluir.php" style="display:inline;">
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