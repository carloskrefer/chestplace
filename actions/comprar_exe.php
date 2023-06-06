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

    try{
        if($_SESSION ['tipo_usuario'] != "comprador"){
            throw new Exception("Apenas usuários `compradores` devidamente logados podem comprar");
        }

        // SELECT dos tamanhos
        $resultTam = mysqli_query($conn, "SELECT * FROM tamanho");

        // Para cada tamanho
        while($row = mysqli_fetch_assoc($resultTam)){
            $qtdeSelect = isset($_POST["quantidade_".$row["codigo"]]) ? $_POST["quantidade_".$row["codigo"]] : null;
            if(!is_null($qtdeSelect)){
                // Insert na compra_venda;
                $insertQuery = "INSERT INTO compra_venda (id_camiseta, id_comprador, data_hora_compra, data_hora_confirmacao_pagamento,data_hora_recebimento,quantidade) VALUES ($idCamiseta, ".$_SESSION["id_usuario"].", NOW(), NULL, NULL, ".$qtdeSelect.");";
                mysqli_query($conn, $insertQuery);
            }
            redirect("../index.php");
        }

        
    } catch (Exception $e){
        alert("Houve um erro ao comprar o produto: " . $e->getMessage());
        jsScript("history.go(-1);");
    }
?>