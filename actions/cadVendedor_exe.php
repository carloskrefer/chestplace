<?php
    session_start();

    include("../common/functions.php");
    include("../database/conectaBD.php");

    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $nomeEstabelecimento = $_POST["nomeEstabelecimento"];
    $cnpj = $_POST["cnpj"];
    $cpf  = $_POST["cpf"];

    // echo $_POST["dataPublicacao"];
    $insertQueryUsuario = "INSERT INTO usuario (nome, email, senha) VALUES (\"".$nome."\",\"".$email."\",\"".$senha."\")";
    
    echo $insertQueryUsuario;
    if (mysqli_query($conn, $insertQueryUsuario)){
        cLog("usuario cadastrado");

        $selectIdUsuario = "SELECT MAX(id) id FROM USUARIO";

        $idUsuario = mysqli_query($conn, $selectIdUsuario);

        if (mysqli_num_rows($idUsuario) > 0) {
            while($usuario = mysqli_fetch_assoc($idUsuario)) {
                $insertQueryVendedor = "INSERT INTO vendedor (id_usuario, nome_estabelecimento, cpf, cnpj, id_endereco) 
                VALUES (\"".$usuario["id"]."\",\"".$nomeEstabelecimento."\",\"".$cpf."\",\"".$cnpj."\",1)";
            }
        }

        if (mysqli_query($conn, $insertQueryVendedor)){
            alert("Vendedor cadastrado");
        }
        redirect("../index.php");
    }
    else
       alert("Erro ao cadastrar usuário!");

?>

