<?php
    /*
        Adicionar require("./database/validacaoAcessoVendedor.php"); nas páginas
        de acesso exclusivo do vendedor. 
        Será verificado se ele está logado e se ele de fato é um vendedor. 
        Se não for, é redirecionado para o index.php.
    */
  $isLogado = isset($_SESSION ['id_usuario']);
  if (isset($_SESSION ['tipo_usuario'])) {
    $isVendedor = $_SESSION ['tipo_usuario'] == "vendedor";
  }
  if (!$isLogado and !$isVendedor) {
    header('location: /chestplace/index.php'); 
  }
?>