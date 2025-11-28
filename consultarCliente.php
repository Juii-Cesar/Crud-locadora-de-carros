<?php
// consultarCliente.php
include "conexao.php";

// Mensagem via GET (ex.: consultarCliente.php?msg=excluido)
$msg = "";
$msgClass = "";
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'excluido') {
        $msg = "Cliente excluído com sucesso!";
        $msgClass = "msg-success";
    } elseif ($_GET['msg'] === 'erro_aluguel') {
        $msg = "Não é possível excluir: cliente possui aluguel ativo!";
        $msgClass = "msg-error";
    } elseif ($_GET['msg'] === 'erro') {
        $msg = "Ocorreu um erro ao processar a requisição.";
        $msgClass = "msg-error";
    }
}

// Recebe busca via POST
$consulta = isset($_POST['nome']) ? trim($_POST['nome']) : "";
$resultado = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Se o campo estiver vazio, volta para a mesma página sem executar query
    if ($consulta === '') {
        header("Location: consultarCliente.php");
        exit;
    }

    $sql = "SELECT * FROM clientes WHERE nome LIKE ?";
    $stmt = $conn->prepare($sql);
    $like = "%" . $consulta . "%";
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $resultado = $stmt->get_result();
    // $stmt->close(); // opcional
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AlugaCars</title>
    <link rel="shortcut icon" href="alugacars.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="menuLateral.css">
    <link rel="stylesheet" href="style.css">
    <style>
        /* estilos rápidos para mensagem, adapte ao seu style.css se quiser */
        .msg-success { background:#e6ffe6; color:#006600; padding:8px 12px; border-radius:4px; margin-bottom:12px; }
        .msg-error { background:#ffe6e6; color:#990000; padding:8px 12px; border-radius:4px; margin-bottom:12px; }
    </style>
</head>
<body>

<nav class="menuLateral">
    <div class="btnAbrir"><i class="bi bi-list"></i></div>
    <ul>
        <li class="itemMenu"><a href="index.php"><span class="icon"><i class="bi bi-house"></i></span><span class="txtLink">Home</span></a></li>
        <li class="itemMenu"><a href="consultarCliente.php"><span class="icon"><i class="bi bi-person"></i></span><span class="txtLink">Clientes</span></a></li>
        <li class="itemMenu"><a href="consultarCarros.php"><span class="icon"><i class="bi bi-car-front-fill"></i></span><span class="txtLink">Carros</span></a></li>
        <li class="itemMenu"><a href="consultarEmprestimo.php"><span class="icon"><i class="bi bi-taxi-front-fill"></i></span><span class="txtLink">Alugueis</span></a></li>
    </ul>
</nav>

<div class="container">

    <?php if ($msg !== ""): ?>
        <p class="<?= htmlspecialchars($msgClass) ?>"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <h1>Consulta de Clientes</h1>
    <a href="cadastrarCliente.php"><i class="bi bi-person-add"></i> Adicionar Cliente</a>

    <div id="trilho" class="trilho"><div id="indicador" class="indicador"></div></div>

    <form method="post" action="consultarCliente.php" class="search-form">
        <input type="text" name="nome" placeholder="Pesquisar por nome..." value="<?= htmlspecialchars($consulta) ?>">
        <button type="submit">Buscar</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>

        <?php if ($resultado && $resultado->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th><th>Nome</th><th>Email</th><th>Telefone</th><th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($linha = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($linha['idClientes']) ?></td>
                            <td><?= htmlspecialchars($linha['nome']) ?></td>
                            <td><?= htmlspecialchars($linha['email']) ?></td>
                            <td><?= htmlspecialchars($linha['tel']) ?></td>
                            <td>
                                <form method="post" action="excluirCliente.php" style="display:inline;">
                                    <input type="hidden" name="idClientes" value="<?= (int)$linha['idClientes'] ?>">
                                    <button type="submit" onclick="return confirm('Deseja realmente excluir este cliente?')">Excluir</button>
                                </form>
                                <form method="get" action="editar.php" style="display:inline; margin-left:5px;">
                                    <input type="hidden" name="idClientes" value="<?= (int)$linha['idClientes'] ?>">
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

    <?php endif; ?>

</div>

<footer class="main-footer">
    <p>&copy; 2025 AlugaCars - Desenvolvido por <strong>Júlio César</strong></p>
    <div class="social-links">
        <i class="bi bi-instagram"></i><a href="https://www.instagram.com/juii.cesar/" target="_blank">Instagram</a>
        <i class="bi bi-linkedin"></i><a href="https://www.linkedin.com/in/j%C3%BAlio-c%C3%A9sar-correa-alves-dev/" target="_blank">LinkedIn</a>
        <i class="bi bi-github"></i><a href="https://github.com/Juii-Cesar" target="_blank">GitHub</a>
    </div>
</footer>

<script src="assets/light-mode.js"></script>
<script src="assets/mask.js"></script>
</body>
</html>