<?php
    session_start();
    include("../common/functions.php");
    include("../database/conectaBD.php");

    //Query's de deleção de registros em tabelas que camiseta interfer
    $delImgQuery = "DELETE FROM imagem WHERE id_produto = " . $_GET["id"];
    $delTamQuery = "DELETE FROM estoque WHERE id_camiseta = " . $_GET["id"];
    $delQuery    = "DELETE FROM camiseta WHERE id = " . $_GET["id"];

    // alert($delImgQuery);
    // alert($delTamQuery);
    // alert($delQuery);

    if (mysqli_query($conn, $delImgQuery)){
        if(mysqli_query($conn, $delTamQuery)){
            if(mysqli_query($conn, $delQuery)){
                echo "<script>alert(\"Anúncio apagado com sucesso\");</script>";
            }
            echo "<script>console.log(\"Estoque e tamanhos de anúncio apagados com sucesso\");</script>";
        }
        echo "<script>console.log(\"Imagens de anúncio apagadas com sucesso\");</script>";
    }
    else
        echo "<script>alert(\"Erro ao apagar anúncio:" . mysqli_error($conn) . "\");</script>";

    redirect("../page_gerProdutos.php?id=".$_SESSION["idVendedor"]);

?>