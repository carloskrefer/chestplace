<?php
    include("../database/conectaBD.php");
    include("../common/functions.php");

    $idImagem = $_GET["idImagem"];
    $idCamiseta = $_GET["idCamiseta"];

    $removeQuery = "DELETE FROM imagem WHERE id = ". $idImagem;

    if (mysqli_query($conn, $removeQuery)){
        alert("Imagem apagada");
        redirect("../forms/form_alterProduto.php?id=".$idCamiseta);
    }

?>