<?php
    session_start();
    include("../common/functions.php");
    include("../database/conectaBD.php");

    $nomeEstabelecimento = $_POST["nomeEstabelecimento"];
    if(isset($_POST["cpf"])){
        $cpf = $_POST["cpf"];
        $cnpj = null;
    }
    else{
        $cpf = null;
        $cnpj = $_POST["cnpj"];
    }

    $alterQuery = "
    UPDATE vendedor 
    SET 
    nome_estabelecimento = \"".$nomeEstabelecimento."\",
    cpf = \"".$cpf."\",
    cnpj = \"".$cnpj."\"
    WHERE id_usuario = ".$_SESSION["idVendedor"].";";

    if (mysqli_query($conn, $alterQuery)){
        echo "<script>alert(\"Cadastro alterado com sucesso\")</script>";
        redirect("../page_gerProdutos.php?id=".$_SESSION["idVendedor"]);
    }


?>