<?php

include("conexao.php");

$consulta = $_POST["nome"];
$sql = "SELECT * FROM clientes WHERE nome LIKE '%$consulta%'";
$resultado = $conn->query($sql);

if ($consulta == "") {
    echo "<script>
        alert('Campo de busca vazio. Por favor, insira um nome para buscar.');
        window.location.href = 'cadastro.html';
    </script>";
} else {
    if ($resultado->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                </tr>";
        while($linha = $resultado->fetch_assoc()) {
            echo "<tr>
                    <td>" . $linha["idClientes"] . "</td>
                    <td>" . $linha["nome"] . "</td>
                    <td>" . $linha["email"] . "</td>
                    <td>" . $linha["tel"] . "</td>
                    <td>
                        <form method='post' action='excluir.php' style='display:inline;'>
                            <input type='hidden' name='idClientes' value='" . $linha["idClientes"] . "'>
                            <button type='submit'>Excluir</button>
                        </form>
                        <form method='get' action='editar.php' style='display:inline; margin-left:5px;'>
                            <input type='hidden' name='idClientes' value='" . $linha["idClientes"] . "'>
                            <button type='submit'>Editar</button>
                        </form>
                    </td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "<script>
            alert('Nenhum Cliente encontrado.');
            window.location.href = 'index.php';
        </script>";
    }
}

// Botão para voltar à página inicial
echo "<div style='margin-top: 20px; text-align: center;'>
        <a href='index.php'>
            <button style='padding: 10px 20px; font-size: 16px;'>Voltar para a página inicial</button>
        </a>
      </div>";

?>