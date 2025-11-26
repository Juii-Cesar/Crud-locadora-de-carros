<?php
require 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

include "conexao.php";

$tipo = $_GET["tipo"] ?? "pendentes";

if ($tipo === "pendentes") {
    $titulo = "Relatório de Aluguéis Pendentes";
    $sql = "SELECT 
                a.idEmprestimo,
                c.nome AS cliente,
                car.modelo,
                car.placa,
                a.dataEmprestimo,
                a.dtDevolucaoPrevista
            FROM alugueis a
            JOIN clientes c ON a.idCliente = c.idClientes
            JOIN carros car ON a.idCarro = car.idCarro
            WHERE a.dataDevolucao IS NULL
            ORDER BY a.idEmprestimo DESC";
} else {
    $titulo = "Relatório de Aluguéis Devolvidos";
    $sql = "SELECT 
                a.idEmprestimo,
                c.nome AS cliente,
                car.modelo,
                car.placa,
                a.dataEmprestimo,
                a.dataDevolucao,
                a.multa,
                a.desconto,
                a.valorTotal
            FROM alugueis a
            JOIN clientes c ON a.idCliente = c.idClientes
            JOIN carros car ON a.idCarro = car.idCarro
            WHERE a.dataDevolucao IS NOT NULL
            ORDER BY a.idEmprestimo DESC";
}

$result = $conn->query($sql);

$html = "<h1 style='text-align:center;'>$titulo</h1>";
$html .= "<table border='1' cellspacing='0' width='100%' style='font-size:14px;'>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Modelo</th>
                <th>Placa</th>
                <th>Data Aluguel</th>";

if ($tipo === "pendentes") {
    $html .= "<th>Devolução Prevista</th>";
} else {
    $html .= "<th>Devolução</th>
              <th>Multa</th>
              <th>Desconto</th>
              <th>Total</th>";
}

$html .= "</tr>";

while ($row = $result->fetch_assoc()) {
    $html .= "<tr>
                <td>{$row['idEmprestimo']}</td>
                <td>{$row['cliente']}</td>
                <td>{$row['modelo']}</td>
                <td>{$row['placa']}</td>
                <td>{$row['dataEmprestimo']}</td>";

    if ($tipo === "pendentes") {
        $html .= "<td>{$row['dtDevolucaoPrevista']}</td>";
    } else {
        $html .= "<td>{$row['dataDevolucao']}</td>
                  <td>R$ {$row['multa']}</td>
                  <td>R$ {$row['desconto']}</td>
                  <td>R$ {$row['valorTotal']}</td>";
    }

    $html .= "</tr>";
}

$html .= "</table>";

$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper("A4", "portrait");
$dompdf->render();
$dompdf->stream("relatorio-$tipo.pdf", ["Attachment" => true]);
?>