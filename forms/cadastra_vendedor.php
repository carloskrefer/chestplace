<?php
    session_start();

    require 'database/conectaBD.php'

    $conn = new mysqli(servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("<strong> Falha de conexão: </strong>" . $conn->connect_error);
    }

    $nome    = $conn->real_escape_string($_POST['nome']);    // prepara a string recebida para ser utilizada em comando SQL
    $email   = $conn->real_escape_string($_POST['email']);
    $senha   = $conn->real_escape_string($_POST['senha']);   // prepara a string recebida para ser utilizada em comando SQL
    $nome_estabelecimento = $conn->real_escape_string($_POST['nomeEstabelecimento']);
    $cpf     = $conn->real_escape_string($_POST['cpf']);
    $cnpj    = $conn->real_escape_string($_POST['cnpj']);
    
?>