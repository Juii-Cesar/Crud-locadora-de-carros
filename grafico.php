<?php
include "conexao.php";

$sql = "SELECT 
            SUM(CASE WHEN dataDevolucao IS NULL THEN 1 ELSE 0 END) AS pendentes,
            SUM(CASE WHEN dataDevolucao IS NOT NULL THEN 1 ELSE 0 END) AS devolvidos
        FROM alugueis";

$result = $conn->query($sql);
$dados = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Gráfico de Aluguéis</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">
    <h1>Gráfico de Aluguéis</h1>

    <canvas id="graficoAlugueis" style="max-width: 450px; margin: 40px auto;"></canvas>

    <a href="consultarEmprestimo.php" class="btnPdf">Voltar</a>
</div>

<script>
const ctx = document.getElementById('graficoAlugueis');

const grafico = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Pendentes', 'Devolvidos'],
        datasets: [{
            data: [<?= $dados['pendentes'] ?>, <?= $dados['devolvidos'] ?>],
            backgroundColor: ['#e74c3c', '#27ae60'],
            borderWidth: 1
        }]
    }
});

</script>

</body>
</html>