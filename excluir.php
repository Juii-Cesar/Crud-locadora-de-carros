<?php
include("conexao.php");

$idClientes = $_POST["idClientes"];
$sql = "DELETE FROM clientes WHERE idClientes = $idClientes";

if ($conn->query($sql) === TRUE) {
    echo "<script>
        alert('cliente excluído com sucesso!');
        window.location.href = 'index.php';
    </script>";
} else {
    echo "<script>
        alert('Erro ao excluir Cliente: " . addslashes($conexao->error) . "');
        window.location.href = 'index.php';
    </script>";
}
?>