<?php
    session_start();

    require 'database/conectaBD.php';

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("<strong> Falha de conexão: </strong>" . $conn->connect_error);
    }

    $nome    = $conn->real_escape_string($_POST['nome']);    // prepara a string recebida para ser utilizada em comando SQL
    $email   = $conn->real_escape_string($_POST['email']);

    $quantidade = 0;

    $sql_procura_carrinho = "SELECT carrinho.quantidade AS qtd_carrinho, tamanho_carrinho.quantidade AS quantia_possivel FROM carrinho INNER JOIN tamanho_camiseta ON tamanho_camiseta.id = carrinho.id_produto WHERE tamanho_camiseta.id_camiseta = '$id_camiseta' AND carrinho.id_usuario = '$id_usuario';";
    
    $sql_insere_camiseta = "INSERT INTO carrinho (id_usuario, id_produto, quantidade) VALUES '$id_usuario', '$id_camiseta', '$quantidade';";
    
    $sql_adiciona_camiseta = "UPDATE carrinho SET quantidade WHERE id_usuario = '$id_usuario' AND id_produto = '$id_camiseta' ;";

    if ($result1 = $conn->query($sql_procura_carrinho)) {
        if ($result1->num_rows > 0) {
            // Apresenta cada linha da tabela
            while ($row = $result2->fetch_assoc()) {
                $id_usuario = $row["qtd_carrinho"];
            }
        }
    }

    if ($result1 = $conn->query($sql_insert_usuario)) {
        $msg = "Registro cadastrado com sucesso! Você já pode realizar login.";
    } else {
        $msg = "Erro executando INSERT: " . $conn-> error . " Tente novo cadastro.";
    }

    
?>