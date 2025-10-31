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
    <link rel="stylesheet" href="style.css" />
    <title>Document</title>
</head>
<body>
    <div class="container">

    
        <h2>Editar Cliente</h2>
        <a href="index.php">Voltar</a>
        <form method="post" action="atualizar.php">
            <input type="hidden" name="idClientes" value="<?php echo $clientes['idClientes']; ?>">
            <label>Nome:</label><br>
            <input type="text" name="nome" value="<?php echo $clientes['nome']; ?>" required><br><br>

            <label>Email:</label><br>
            <input type="text" name="email" value="<?php echo $clientes['email']; ?>" required><br><br>

            <label>Telefone:</label><br>
            <input type="number" name="tel" value="<?php echo $clientes['tel']; ?>" required><br><br>

            <button type="submit">Salvar Alterações</button>
        </form>
    </div>
<div style="margin-top: 20px;">
    
</div>
</body>
</html>