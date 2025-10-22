<?php
include("conexao.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $idade = trim($_POST['tel']);

    if(!empty($nome)&& !empty($email) && !empty($tel)) {
        $stmt = $conn->prepare("insert into clientes (nome, email, tel) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi",$nome,$email,$tel);

        if ($stmt->execute()) {
            // style aqui
            echo "<p style='color:green;'>Cliente cadastrado com sucesso!</p>";
        } else {
            echo "<p style='color:red;'>Erro ao cadastrar: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }else{
        echo "<p style='color:red;'>Preencha todos os campos obrigatórios!</p>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>cadastro de cliente</h1>
    <a href="index.php">voltar a tela principal</a>
    
    <form method="post" action="">
        <label>Nome:</label><br>
        <input type="text" name="nome" required><br><br>

        <label>Email:</label><br>
        <input type="text" name="email" required><br><br>

        <label>Telefone:</label><br>
        <input type="number" name="tel" required><br><br>
        
        <button type="submit">cadastrar</button>
    </form>
</body>
</html>