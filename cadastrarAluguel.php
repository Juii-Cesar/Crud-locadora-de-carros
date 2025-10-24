<?php
include("conexao.php");

$mensagem = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idCliente = trim($_POST['idCliente']);
    $idCarro = trim($_POST['idCarro']);
    $dataDevolucao = trim($_POST['dataDevolucao']);
    
    if(empty($dataDevolucao)) {
        $dataDevolucao = NULL;
    }

    if(!empty($idCliente) && !empty($idCarro)) {
        $stmt = $conn->prepare("insert into alugueis (idCliente, idCarro, dataDevolucao) VALUES (?, ?, ?)");
        $stmt->bind_param("iis",$idCliente,$idCarro,$dataDevolucao);

        if ($stmt->execute()) {
            $mensagem = "<p class='msg-success'>Aluguel cadastrado com sucesso!</p>";
        } else {
            $mensagem = "<p class='msg-error'>Erro ao cadastrar: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }else{
        $mensagem = "<p class='msg-error'>Preencha os campos de ID do Cliente e ID do Carro!</p>";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=S, initial-scale=1.0">
    <title>Cadastro de Aluguel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Cadastro de Aluguel</h1>
        <a href="index.php">Voltar</a>
        
        <?php echo $mensagem; ?>

        <form method="post" action="">
            <label>ID do Cliente:</label>
            <input type="number" name="idCliente" required>

            <label>ID do Carro:</label>
            <input type="number" name="idCarro" required>

            <label>Data de Devolução (Opcional):</label>
            <input type="date" name="dataDevolucao">
            
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>