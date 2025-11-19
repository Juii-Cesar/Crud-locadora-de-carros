<?php
include("conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlugaCars</title>
    <link rel="shortcut icon" href="alugacars.ico" type="image/x-icon">
    <link rel="stylesheet" href="paginaInicial.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="menuLateral.css">
</head>
<body>
    <header class="inicio">
        <div class="titulo">
            <H1><i class="bi bi-taxi-front-fill"></i></H1>
            <h1>AlugaCars</h1>
        </div>

    </header>

    <div class="container">
        <img src="carros.jpg" alt="carros estacionados">
        <h1 class="anuncioCarros">AlugaCars, Aluguel Veícular em todo Brasil! </h1>
    </div>

    <nav class="menuLateral">
        <div class="btnAbrir">
            <i class="bi bi-list"></i>
        </div>
         <ul>
            <li class="itemMenu">
                <a href="#">
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
                <a href="#">
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
</body>
</html>
