<?php
    session_start();

    // Pré-configurações
    date_default_timezone_set('America/Sao_Paulo');

    // Imports
    include("../common/functions.php");
    include("../database/conectaBD.php");

    // Verificar se o acesso para a página foi feita por POST (evitar vendedores de acessar ela)
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirect("../page_gerProdutos.php");
    }

    $idCamiseta = $_POST["idCamiseta"];
    $quantidade = $_POST["quantidade"];
    
    $insertQuery = "INSERT INTO compra_venda (id_camiseta, id_comprador, data_hora_compra, data_hora_confirmacao_pagamento,data_hora_recebimento,quantidade) VALUES ($idCamiseta, ".$_SESSION["id_usuario"].", NOW(), NULL, NULL, $quantidade);";

    try{
        mysqli_query($conn, $insertQuery);
    } catch (Exception $e){
        alert("Houve um erro ao comprar o produto: " . $e->getMessage());
    }
?>